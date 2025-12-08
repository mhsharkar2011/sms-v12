<?php

namespace App\Http\Controllers;

use App\Models\StaffAttendance;
use App\Models\Staff;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffAttendanceController extends Controller
{
    public function index()
    {
        $attendances = StaffAttendance::with(['staff', 'markedBy'])
            ->orderBy('attendance_date', 'desc')
            ->paginate(20);

        return view('attendance.staff.index', compact('attendances'));
    }

    public function create()
    {
        $staffMembers = Teacher::with('user')->get();

        return view('attendance.staff.create', compact('staffMembers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'attendance_date' => 'required|date',
            'attendances' => 'required|array',
            'attendances.*.staff_id' => 'required|exists:staff,id',
            'attendances.*.status' => 'required|in:present,absent,late,half_day,leave',
            'attendances.*.check_in_time' => 'nullable|date_format:H:i',
            'attendances.*.check_out_time' => 'nullable|date_format:H:i|after:check_in_time',
            'attendances.*.remark' => 'nullable|string|max:255'
        ]);

        foreach ($request->attendances as $attendance) {
            StaffAttendance::updateOrCreate(
                [
                    'staff_id' => $attendance['staff_id'],
                    'attendance_date' => $request->attendance_date
                ],
                [
                    'status' => $attendance['status'],
                    'check_in_time' => $attendance['check_in_time'] ?? null,
                    'check_out_time' => $attendance['check_out_time'] ?? null,
                    'working_hours' => $this->calculateWorkingHours(
                        $attendance['check_in_time'] ?? null,
                        $attendance['check_out_time'] ?? null
                    ),
                    'remark' => $attendance['remark'] ?? null,
                    'marked_by' => Auth::id()
                ]
            );
        }

        return redirect()->route('staff-attendance.index')
            ->with('success', 'Staff attendance marked successfully!');
    }

    private function calculateWorkingHours($checkIn, $checkOut)
    {
        if (!$checkIn || !$checkOut) {
            return null;
        }

        $start = \Carbon\Carbon::createFromFormat('H:i', $checkIn);
        $end = \Carbon\Carbon::createFromFormat('H:i', $checkOut);

        return $end->diffInMinutes($start) / 60;
    }

    public function show(StaffAttendance $staffAttendance)
    {
        return view('attendance.staff.show', compact('staffAttendance'));
    }

    public function edit(StaffAttendance $staffAttendance)
    {
        return view('attendance.staff.edit', compact('staffAttendance'));
    }

    public function update(Request $request, StaffAttendance $staffAttendance)
    {
        $request->validate([
            'status' => 'required|in:present,absent,late,half_day,leave',
            'check_in_time' => 'nullable|date_format:H:i',
            'check_out_time' => 'nullable|date_format:H:i|after:check_in_time',
            'remark' => 'nullable|string|max:255'
        ]);

        $data = $request->all();
        $data['working_hours'] = $this->calculateWorkingHours(
            $request->check_in_time,
            $request->check_out_time
        );

        $staffAttendance->update($data);

        return redirect()->route('staff-attendance.index')
            ->with('success', 'Attendance updated successfully!');
    }

    public function destroy(StaffAttendance $staffAttendance)
    {
        $staffAttendance->delete();

        return redirect()->route('staff-attendance.index')
            ->with('success', 'Attendance record deleted successfully!');
    }

    public function getAttendanceByDate(Request $request)
    {
        $attendances = StaffAttendance::where('attendance_date', $request->date)
            ->get()
            ->keyBy('staff_id');

        return response()->json($attendances);
    }
}
