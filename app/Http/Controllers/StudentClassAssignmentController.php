<?php
// app/Http/Controllers/StudentClassAssignmentController.php

namespace App\Http\Controllers;

use App\Models\StudentClassAssignment;
use App\Models\User;
use App\Models\StudentClass;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class StudentClassAssignmentController extends Controller
{
    /**
     * Display a listing of assignments.
     */
    public function index(): View
    {
        $assignments = StudentClassAssignment::with(['student', 'class'])
            ->latest()
            ->paginate(20);

        return view('assignments.student-class.index', compact('assignments'));
    }

    /**
     * Show the form for creating a new assignment.
     */
    public function create(): View
    {
        $students = User::where('type', 'student')->active()->get();
        $classes = StudentClass::active()->get();

        return view('assignments.student-class.create', compact('students', 'classes'));
    }

    /**
     * Store a newly created assignment.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:users,id',
            'class_id' => 'required|exists:student_classes,id',
            'roll_number' => 'nullable|string|max:20',
            'enrollment_date' => 'required|date',
            'notes' => 'nullable|string|max:500',
        ]);

        // Check if student is already assigned to this class
        $existing = StudentClassAssignment::where('student_id', $validated['student_id'])
            ->where('class_id', $validated['class_id'])
            ->active()
            ->exists();

        if ($existing) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Student is already assigned to this class.');
        }

        StudentClassAssignment::create($validated);

        // Update student count in class
        $class = StudentClass::find($validated['class_id']);
        $class->increment('current_students_count');

        return redirect()->route('student-class-assignments.index')
            ->with('success', 'Student assigned to class successfully.');
    }

    /**
     * Update the specified assignment.
     */
    public function update(Request $request, StudentClassAssignment $assignment): RedirectResponse
    {
        $validated = $request->validate([
            'roll_number' => 'nullable|string|max:20',
            'status' => 'required|in:active,inactive,transferred,graduated',
            'completion_date' => 'nullable|date',
            'notes' => 'nullable|string|max:500',
        ]);

        $assignment->update($validated);

        return redirect()->route('student-class-assignments.index')
            ->with('success', 'Assignment updated successfully.');
    }

    /**
     * Remove the specified assignment.
     */
    public function destroy(StudentClassAssignment $assignment): RedirectResponse
    {
        // Update student count in class before deletion
        if ($assignment->status === 'active') {
            $assignment->class->decrement('current_students_count');
        }

        $assignment->delete();

        return redirect()->route('student-class-assignments.index')
            ->with('success', 'Assignment removed successfully.');
    }
}
