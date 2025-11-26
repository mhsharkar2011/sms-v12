<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\TeacherSubject;
use App\Models\Timetable;
use Illuminate\Http\Request;

class TimetableController extends Controller
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
        // Get available teachers for different subjects
        $mathTeachers = TeacherSubject::canTeach('Mathematics')->get();
        $physicsTeachers = TeacherSubject::canTeach('Physics')->get();
        $biologyTeachers = TeacherSubject::canTeach('Biology')->get();

        return view('admin.timetables.create', compact(
            'mathTeachers',
            'physicsTeachers',
            'biologyTeachers'
        ));
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
    public function show(Timetable $timetable)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Timetable $timetable)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Timetable $timetable)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Timetable $timetable)
    {
        //
    }

    public function getAvailableTeachers(Request $request)
    {
        $subject = $request->get('subject');
        $day = $request->get('day');

        // Get available teachers for a specific subject and day
        $availableTeachers = TeacherSubject::getAvailableTeachers($subject, $day);

        return response()->json($availableTeachers);
    }

    public function checkTeacherQualification(Request $request)
    {
        $teacherId = $request->get('teacher_id');
        $subject = $request->get('subject');

        $teacher = Teacher::find($teacherId);
        $isQualified = $teacher->canTeach($subject, 'intermediate');

        return response()->json(['qualified' => $isQualified]);
    }
}
