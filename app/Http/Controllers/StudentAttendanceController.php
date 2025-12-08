<?php

namespace App\Http\Controllers;

use App\Models\StudentAttendance;
use App\Models\Student;
use App\Models\Classes;
use App\Models\SchoolClass;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentAttendanceController extends Controller
{
    public function index()
    {
        $attendances = StudentAttendance::with(['student', 'class', 'section'])
            ->orderBy('attendance_date', 'desc')
            ->paginate(20);
        $classes = SchoolClass::all();
        return view('attendance.student.index', compact('attendances', 'classes'));
    }

    public function create()
    {
        $classes = SchoolClass::all();
        $sections = Section::all();

        return view('attendance.student.create', compact('classes', 'sections'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'attendance_date' => 'required|date',
            'class_id' => 'required|exists:school_classes,id',
            'section_id' => 'required|exists:sections,id',
            'attendances' => 'required|array',
            'attendances.*.student_id' => 'required|exists:students,id',
            'attendances.*.status' => 'required|in:present,absent,late,excused',
            'attendances.*.check_in_time' => 'nullable|date_format:H:i',
            'attendances.*.check_out_time' => 'nullable|date_format:H:i|after:attendances.*.check_in_time',
            'attendances.*.remark' => 'nullable|string|max:255'
        ]);

        foreach ($request->attendances as $attendance) {
            StudentAttendance::updateOrCreate(
                [
                    'student_id' => $attendance['student_id'],
                    'attendance_date' => $request->attendance_date,
                    'class_id' => $request->class_id,
                    'section_id' => $request->section_id
                ],
                [
                    'status' => $attendance['status'],
                    'check_in_time' => $attendance['check_in_time'] ?? null,
                    'check_out_time' => $attendance['check_out_time'] ?? null,
                    'remark' => $attendance['remark'] ?? null,
                    'marked_by' => Auth::id()
                ]
            );
        }

        return redirect()->route('student-attendance.index')
            ->with('success', 'Attendance marked successfully!');
    }

    public function show(StudentAttendance $studentAttendance)
    {
        return view('attendance.student.show', compact('studentAttendance'));
    }

    public function edit(StudentAttendance $studentAttendance)
    {
        $studentAttendance->load(['student.user', 'class', 'section', 'markedBy']);

        // $classes = SchoolClass::all();
        // $sections = Section::all();

        return view('attendance.student.edit', compact('studentAttendance'));
    }

    public function update(Request $request, StudentAttendance $studentAttendance)
    {
        $request->validate([
            'status' => 'required|in:present,absent,late,excused',
            'check_in_time' => 'nullable|date_format:H:i',
            'check_out_time' => 'nullable|date_format:H:i|after:check_in_time',
            'remark' => 'nullable|string|max:255'
        ]);

        $studentAttendance->update([
            'status' => $request->status,
            'check_in_time' => $request->check_in_time,
            'check_out_time' => $request->check_out_time,
            'remark' => $request->remark
        ]);

        return redirect()->route('student-attendance.index')
            ->with('success', 'Attendance updated successfully!');
    }


    
    public function destroy(StudentAttendance $studentAttendance)
    {
        $studentAttendance->delete();

        return redirect()->route('student-attendance.index')
            ->with('success', 'Attendance record deleted successfully!');
    }

    public function getStudentsByClassSection(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:school_classes,id',
            'section_id' => 'required|exists:sections,id'
        ]);

        $students = Student::where('class_id', $request->class_id)
            ->where('section_id', $request->section_id)
            ->with('user') // Assuming you have user relationship
            ->get()
            ->map(function ($student) {
                return [
                    'id' => $student->id,
                    'roll_number' => $student->roll_number,
                    'name' => $student->user->name ?? 'N/A',
                    'user' => [
                        'name' => $student->user->name ?? 'N/A',
                        'email' => $student->user->email ?? 'N/A'
                    ]
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $students,
            'count' => $students->count()
        ]);
    }

    public function getAttendanceByDate(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'class_id' => 'required|exists:school_classes,id',
            'section_id' => 'required|exists:sections,id'
        ]);

        $attendances = StudentAttendance::where('attendance_date', $request->date)
            ->where('class_id', $request->class_id)
            ->where('section_id', $request->section_id)
            ->get()
            ->map(function ($attendance) {
                return [
                    'student_id' => $attendance->student_id,
                    'status' => $attendance->status,
                    'check_in_time' => $attendance->check_in_time,
                    'check_out_time' => $attendance->check_out_time,
                    'remark' => $attendance->remark
                ];
            });
        return response()->json([
            'success' => true,
            'data' => $attendances
        ]);
    }
}
