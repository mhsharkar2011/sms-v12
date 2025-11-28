<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Http\Request;

class ClassManagementController extends Controller
{
    public function index()
    {
        $classes = SchoolClass::with('classTeacher')
            ->withCount('students')
            ->orderBy('grade_level')
            ->orderBy('section')
            ->paginate(12);

        $totalClasses = SchoolClass::count();
        $activeClasses = SchoolClass::where('status', 'active')->count();
        $totalStudents = Student::count();
        $averageClassSize = $totalClasses > 0 ? $totalStudents / $totalClasses : 0;

        // Get unique grade levels for filter
        $gradeLevels = SchoolClass::distinct()
            ->pluck('grade_level')
            ->sort()
            ->values();

        return view('admin.classes.index', compact(
            'classes',
            'totalClasses',
            'activeClasses',
            'totalStudents',
            'averageClassSize',
            'gradeLevels'
        ));
    }

    public function show(SchoolClass $class)
    {
        $class->load(['classTeacher', 'students', 'students.guardians']);

        return view('admin.classes.show', compact('class'));
    }

    public function create()
    {
        return view('admin.classes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:school_classes,code',
            'grade_level' => 'required|string',
            'section' => 'required|string',
            'capacity' => 'required|integer|min:1',
            'room_number' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        SchoolClass::create(array_merge($validated, [
            'academic_year' => '2024-2025',
            'status' => 'active',
        ]));

        return redirect()->route('admin.classes.index')
            ->with('success', 'Class created successfully!');
    }

    public function edit(SchoolClass $class)
    {
        return view('admin.classes.edit', compact('class'));
    }

    public function update(Request $request, SchoolClass $class)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:school_classes,code,' . $class->id,
            'grade_level' => 'required|string',
            'section' => 'required|string',
            'capacity' => 'required|integer|min:1',
            'room_number' => 'nullable|string',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $class->update($validated);

        return redirect()->route('admin.classes.index')
            ->with('success', 'Class updated successfully!');
    }

    public function destroy(SchoolClass $class)
    {
        if ($class->students()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Cannot delete class with students. Please reassign students first.');
        }

        $class->delete();

        return redirect()->route('admin.classes.index')
            ->with('success', 'Class deleted successfully!');
    }

    // Helper method for the view
    public function getStreamFromName($name)
    {
        if (str_contains($name, 'Science')) return 'Science';
        if (str_contains($name, 'Commerce')) return 'Commerce';
        if (str_contains($name, 'Arts')) return 'Arts';
        return 'General';
    }


    public function getStudentsData(SchoolClass $class)
    {
        $students = Student::where('status', 'active')
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get(['id', 'first_name', 'last_name', 'student_id', 'email']);

        $assignedStudents = $class->students()->pluck('students.id')->toArray();

        return response()->json([
            'students' => $students,
            'assignedStudents' => $assignedStudents
        ]);
    }

    public function assignStudents(Request $request, SchoolClass $class)
    {
        $request->validate([
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:students,id'
        ]);

        try {
            // Sync students with the class
            $class->students()->sync($request->student_ids);

            // Update class strength
            $class->update(['current_strength' => count($request->student_ids)]);

            return response()->json([
                'success' => true,
                'message' => 'Students assigned successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to assign students: ' . $e->getMessage()
            ], 500);
        }
    }
}
