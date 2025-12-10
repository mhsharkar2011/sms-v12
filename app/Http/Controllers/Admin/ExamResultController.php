<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamResult;
use App\Models\Student;
use Illuminate\Http\Request;

class ExamResultController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Exam $exam)
    {
        // Get all results for this exam
        $results = ExamResult::where('exam_id', $exam->id)
            ->with(['student'])
            ->orderBy('marks_obtained', 'desc')
            ->get();

        $exam->load(['schoolClass', 'section', 'subject']);

        return view('admin.exam-results.index', compact('exam', 'results'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Exam $exam)
    {
        // Get students from the same class and section
        $students = Student::where('school_class_id', $exam->school_class_id)
            ->where('section_id', $exam->section_id)
            ->orderBy('name')
            ->get();

        // Get existing results to mark which students already have results
        $existingResults = ExamResult::where('exam_id', $exam->id)
            ->pluck('student_id')
            ->toArray();

        $exam->load(['schoolClass', 'section', 'subject']);

        return view('admin.exam-results.create', compact('exam', 'students', 'existingResults'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Exam $exam)
    {
        // Validate the request
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'marks_obtained' => 'required|numeric|min:0|max:' . $exam->total_marks,
            'grade' => 'nullable|string|max:10',
            'remarks' => 'nullable|string|max:500',
        ]);

        // Add exam_id to validated data
        $validated['exam_id'] = $exam->id;

        // Calculate percentage
        $validated['percentage'] = ($validated['marks_obtained'] / $exam->total_marks) * 100;

        // Determine pass/fail
        $validated['is_passed'] = $validated['percentage'] >= $exam->passing_percentage;

        // Create the exam result
        ExamResult::create($validated);

        return redirect()->route('admin.exams.results.index', ['exam' => $exam->id])
            ->with('success', 'Exam result added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Exam $exam, ExamResult $result)
    {
        $result->load(['student', 'exam']);

        return view('admin.exam-results.show', compact('exam', 'result'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Exam $exam, ExamResult $result)
    {
        // Get students from the same class and section
        $students = Student::where('school_class_id', $exam->school_class_id)
            ->where('section_id', $exam->section_id)
            ->orderBy('name')
            ->get();

        return view('admin.exam-results.edit', compact('exam', 'result', 'students'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Exam $exam, ExamResult $result)
    {
        // Validate the request
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'marks_obtained' => 'required|numeric|min:0|max:' . $exam->total_marks,
            'grade' => 'nullable|string|max:10',
            'remarks' => 'nullable|string|max:500',
        ]);

        // Calculate percentage
        $validated['percentage'] = ($validated['marks_obtained'] / $exam->total_marks) * 100;

        // Determine pass/fail
        $validated['is_passed'] = $validated['percentage'] >= $exam->passing_percentage;

        // Update the exam result
        $result->update($validated);

        return redirect()->route('admin.exams.results.index', ['exam' => $exam->id])
            ->with('success', 'Exam result updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Exam $exam, ExamResult $result)
    {
        $result->delete();

        return redirect()->route('admin.exams.results.index', ['exam' => $exam->id])
            ->with('success', 'Exam result deleted successfully!');
    }

    /**
     * Store bulk results
     */
    public function storeBulk(Request $request, Exam $exam)
    {
        $request->validate([
            'results' => 'required|array',
            'results.*.student_id' => 'required|exists:students,id',
            'results.*.marks_obtained' => 'required|numeric|min:0|max:' . $exam->total_marks,
        ]);

        foreach ($request->results as $resultData) {
            $percentage = ($resultData['marks_obtained'] / $exam->total_marks) * 100;

            ExamResult::updateOrCreate(
                [
                    'exam_id' => $exam->id,
                    'student_id' => $resultData['student_id'],
                ],
                [
                    'marks_obtained' => $resultData['marks_obtained'],
                    'percentage' => $percentage,
                    'is_passed' => $percentage >= $exam->passing_percentage,
                    'grade' => $resultData['grade'] ?? null,
                    'remarks' => $resultData['remarks'] ?? null,
                ]
            );
        }

        return redirect()->route('admin.exams.results.index', ['exam' => $exam->id])
            ->with('success', 'Bulk results added successfully!');
    }
}
