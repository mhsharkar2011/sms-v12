<?php

namespace App\Http\Controllers\Admin;

use App\http\Controllers\Controller;
use App\Models\Student;
use App\Models\Attendance;
use App\Models\ExamResult;
use App\Models\Fee;
use App\Models\Report;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Inventory;
use App\Models\StudentAddress;
use App\Models\StudentAttendance;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $dateRange = $request->get('date_range', 7);
        $startDate = $this->getStartDate($dateRange, $request);

        // Total Students
        $totalStudents = Student::count();
        $lastMonthStudents = Student::where('created_at', '<', now()->subMonth())
            ->count();
        $studentGrowth = $lastMonthStudents > 0 ?
            (($totalStudents - $lastMonthStudents) / $lastMonthStudents * 100) : 0;

        // Attendance Data
        $attendanceData = StudentAttendance::where('date', '>=', $startDate)
            ->selectRaw('COUNT(*) as total, SUM(CASE WHEN status = "present" THEN 1 ELSE 0 END) as present')
            ->first();

        $avgAttendance = $attendanceData->total > 0 ?
            ($attendanceData->present / $attendanceData->total * 100) : 0;

        $lastMonthAttendance = StudentAttendance::whereBetween(
            'date',
            [now()->subMonth()->subDays(30), now()->subMonth()]
        )
            ->selectRaw('COUNT(*) as total, SUM(CASE WHEN status = "present" THEN 1 ELSE 0 END) as present')
            ->first();

        $lastMonthAvg = $lastMonthAttendance->total > 0 ?
            ($lastMonthAttendance->present / $lastMonthAttendance->total * 100) : 0;
        $attendanceGrowth = $lastMonthAvg > 0 ? ($avgAttendance - $lastMonthAvg) : 0;

        // Exam Performance
        $examResults = \ExamResult::with('exam')
            ->whereHas('exam', function ($q) use ($startDate) {
                $q->where('exam_date', '>=', $startDate);
            })
            ->get();

        $totalExams = $examResults->count();
        $passedExams = $examResults->where('marks', '>=', 40)->count();
        $avgPassPercentage = $totalExams > 0 ? ($passedExams / $totalExams * 100) : 0;

        // Get previous term pass percentage (simplified)
        $passGrowth = 3.8; // You would calculate this from actual data

        // Financial Data
        $totalRevenue = Fee::where('status', 'paid')
            ->where('paid_at', '>=', $startDate)
            ->sum('amount');

        $lastMonthRevenue = Fee::where('status', 'paid')
            ->whereBetween('paid_at', [now()->subMonth()->subDays(30), now()->subMonth()])
            ->sum('amount');

        $revenueGrowth = $lastMonthRevenue > 0 ?
            (($totalRevenue - $lastMonthRevenue) / $lastMonthRevenue * 100) : 0;

        // Attendance Trend (Last 5 days)
        $attendanceTrend = [];
        for ($i = 4; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $dayAttendance = StudentAttendance::whereDate('date', $date)
                ->selectRaw('COUNT(*) as total, SUM(CASE WHEN status = "present" THEN 1 ELSE 0 END) as present')
                ->first();

            $attendanceTrend[$date->format('D')] = [
                'total' => $dayAttendance->total ?? 0,
                'present' => $dayAttendance->present ?? 0,
                'percentage' => $dayAttendance->total > 0 ?
                    round(($dayAttendance->present / $dayAttendance->total * 100), 1) : 0
            ];
        }

        // Subject Performance
        $subjectPerformance = Subject::with(['examResults' => function ($q) use ($startDate) {
            $q->whereHas('exam', function ($q2) use ($startDate) {
                $q2->where('exam_date', '>=', $startDate);
            });
        }])->get()->mapWithKeys(function ($subject) {
            $results = $subject->examResults;
            $total = $results->count();
            $passed = $results->where('marks', '>=', 40)->count();
            $average = $total > 0 ? $results->avg('marks') : 0;

            return [$subject->name => [
                'students' => $results->unique('student_id')->count(),
                'total' => $total,
                'passed' => $passed,
                'average' => round($average, 1)
            ]];
        })->sortByDesc('average')->take(8);

        // Recent Reports
        $recentReports = Report::orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('admin.reports.index', compact(
            'totalStudents',
            'studentGrowth',
            'avgAttendance',
            'attendanceGrowth',
            'avgPassPercentage',
            'passGrowth',
            'totalRevenue',
            'revenueGrowth',
            'attendanceTrend',
            'subjectPerformance',
            'recentReports'
        ));
    }

    private function getStartDate($range, $request)
    {
        switch ($range) {
            case 'custom':
                return $request->get('custom_start') ?? now()->subDays(30);
            case '30':
                return now()->subDays(30);
            case '90':
                return now()->subDays(90);
            case '365':
                return now()->subDays(365);
            default:
                return now()->subDays(7);
        }
    }

    public function generateAcademicReport(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'class_id' => 'nullable|exists:classes,id',
            'subject_id' => 'nullable|exists:subjects,id'
        ]);

        // Generate academic report logic
        $report = Report::create([
            'name' => 'Academic Performance Report',
            'type' => 'academic',
            'period' => $request->start_date . ' to ' . $request->end_date,
            'status' => 'processing',
            'parameters' => json_encode($request->all())
        ]);

        // Queue report generation
        dispatch(new GenerateAcademicReport($report));

        return response()->json([
            'success' => true,
            'message' => 'Academic report generation started',
            'report_id' => $report->id
        ]);
    }

    public function generateAttendanceReport(Request $request)
    {
        // Similar implementation for attendance reports
    }

    public function generateFinancialReport(Request $request)
    {
        // Similar implementation for financial reports
    }

    public function exportReport($id)
    {
        $report = Report::findOrFail($id);

        if ($report->status !== 'completed') {
            return redirect()->back()->with('error', 'Report is not ready for download');
        }

        return response()->download(storage_path('app/reports/' . $report->file_path));
    }

    public function deleteReport($id)
    {
        $report = Report::findOrFail($id);

        // Delete file if exists
        if ($report->file_path && file_exists(storage_path('app/reports/' . $report->file_path))) {
            unlink(storage_path('app/reports/' . $report->file_path));
        }

        $report->delete();

        return redirect()->back()->with('success', 'Report deleted successfully');
    }

    public function getMetrics()
    {
        // Return real-time metrics for AJAX updates
        $totalStudents = Student::count();
        $avgAttendance = StudentAttendance::whereDate('date', today())
            ->selectRaw('COUNT(*) as total, SUM(CASE WHEN status = "present" THEN 1 ELSE 0 END) as present')
            ->first();

        $attendance = $avgAttendance->total > 0 ?
            round(($avgAttendance->present / $avgAttendance->total * 100), 1) : 0;

        $totalRevenue = Fee::whereDate('paid_at', today())
            ->where('status', 'paid')
            ->sum('amount');

        return response()->json([
            'totalStudents' => $totalStudents,
            'avgAttendance' => $attendance,
            'totalRevenue' => number_format($totalRevenue, 2),
            'studentGrowth' => 5.2, // Calculate actual growth
            'attendanceGrowth' => 2.1,
            'revenueGrowth' => 12.5
        ]);
    }
}
