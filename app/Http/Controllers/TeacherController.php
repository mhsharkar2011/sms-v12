<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\TeacherSubject;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
         // Start with base query
        $query = Teacher::query();

        // Apply search filter
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('teacher_id', 'like', '%' . $request->search . '%');
            });
        }

        // Apply subject filter
        if ($request->has('subject') && $request->subject != '') {
            $query->where('subject', $request->subject);
        }

        // Apply status filter
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Get paginated results
        $teachers = $query->latest()->paginate(10);

        // Calculate stats
        $stats = [
            'total_teachers' => Teacher::count(),
            'active_today' => Teacher::where('status', 'active')->count(),
            'on_leave' => Teacher::where('status', 'on_leave')->count(),
            'subjects_covered' => Teacher::distinct('subject')->count('subject'),
        ];

        // Get unique subjects for filter dropdown
        $subjects = Teacher::distinct()->whereNotNull('subject')->pluck('subject');

        return view('admin.teachers', compact('teachers', 'stats', 'subjects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.teachers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Basic store method for testing
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:teachers,email',
            'teacher_id' => 'required|unique:teachers,teacher_id',
            'subject' => 'required|string|max:255',
        ]);

        Teacher::create($validated);

        return redirect()->route('admin.teachers.index')->with('success', 'Teacher created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Teacher $teacher)
    {
        // Get teacher's subjects and primary subject
        $subjects = $teacher->activeSubjects;
        $primarySubject = $teacher->primarySubject;

        return view('admin.teachers.show', compact('teacher', 'subjects', 'primarySubject'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Teacher $teacher)
    {
        return view('admin.teachers.edit', compact('teacher'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Teacher $teacher)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:teachers,email,' . $teacher->id,
            'teacher_id' => 'required|unique:teachers,teacher_id,' . $teacher->id,
            'subject' => 'required|string|max:255',
        ]);

        $teacher->update($validated);

        return redirect()->route('admin.teachers.index')->with('success', 'Teacher updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Teacher $teacher)
    {
        $teacher->delete();
        return redirect()->route('admin.teachers.index')->with('success', 'Teacher deleted successfully!');
    }

    public function addSubject(Request $request, Teacher $teacher)
    {
        $validated = $request->validate([
            'subject_name' => 'required|string|max:255',
            'proficiency_level' => 'required|in:beginner,intermediate,advanced,expert',
            'years_of_experience' => 'required|integer|min:0',
            'qualifications' => 'nullable|string',
            'is_primary' => 'boolean'
        ]);

        // Add new subject to teacher
        TeacherSubject::create(array_merge($validated, ['teacher_id' => $teacher->id]));

        return redirect()->back()->with('success', 'Subject added successfully!');
    }

    public function getSubjects(Teacher $teacher)
    {
        // Get all subjects a teacher can teach
        $subjects = $teacher->activeSubjects;
        return response()->json($subjects);
    }
}
