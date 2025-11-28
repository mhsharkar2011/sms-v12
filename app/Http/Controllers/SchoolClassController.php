<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use App\Models\Teacher;
use App\Models\TeacherSubject;
use Illuminate\Http\Request;

class SchoolClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(SchoolClass $schoolClass)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SchoolClass $schoolClass)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SchoolClass $schoolClass)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SchoolClass $schoolClass)
    {
        //
    }


    public function assignTeacher(Request $request, SchoolClass $class)
    {
        $validated = $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'subject' => 'required|string'
        ]);

        $teacher = Teacher::find($validated['teacher_id']);

        // Check if teacher is qualified to teach this subject
        $isQualified = $teacher->canTeach($validated['subject'], 'intermediate');

        if (!$isQualified) {
            return redirect()->back()->with('error', 'Teacher is not qualified to teach this subject!');
        }

        // Assign teacher to class
        $class->teachers()->attach($teacher->id, ['subject' => $validated['subject']]);

        return redirect()->back()->with('success', 'Teacher assigned successfully!');
    }

    public function getSubjectTeachers(Request $request)
    {
        $subject = $request->get('subject');

        // Get all teachers who can teach the selected subject
        $teachers = TeacherSubject::canTeach($subject)->get();

        return response()->json($teachers);
    }
}
