<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Subject;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get unique academic years from exams
        $academicYearsFromDB = Exam::select('academic_year')
            ->distinct()
            ->orderBy('academic_year', 'desc')
            ->pluck('academic_year')
            ->toArray();

        // If no academic years in DB, generate default years
        $currentYear = date('Y');
        $defaultYears = [];
        for ($year = $currentYear; $year >= ($currentYear - 2); $year--) {
            $defaultYears[] = $year . '-' . ($year + 1);
        }

        // Merge and deduplicate
        $academicYears = array_unique(array_merge($academicYearsFromDB, $defaultYears));
        rsort($academicYears); // Sort in descending order

        // Query exams with filters
        $query = Exam::with(['schoolClass', 'section', 'subject'])
            ->latest();

        // Apply filters
        if ($request->filled('academic_year')) {
            $query->where('academic_year', $request->academic_year);
        }

        if ($request->filled('term')) {
            $query->where('term', $request->term);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Get paginated results
        $exams = $query->paginate(20);

        // Get statistics
        $totalExams = Exam::count();
        $publishedExams = Exam::where('is_published', true)->count();
        $scheduledExams = Exam::where('status', 'scheduled')->count();
        $cancelledExams = Exam::where('status', 'cancelled')->count();

        return view('admin.exams.index', compact(
            'exams',
            'academicYears',
            'totalExams',
            'publishedExams',
            'scheduledExams',
            'cancelledExams'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $classes = SchoolClass::orderBy('name')->get();
        $subjects = Subject::orderBy('name')->get();
        $sections = Section::orderBy('name')->get();

        return view('admin.exams.create', compact('classes', 'subjects','sections'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'academic_year' => 'required|string|max:9',
            'term' => 'required|string|max:1',
            'school_class_id' => 'required|exists:school_classes,id',
            'section_id' => 'required|exists:sections,id',
            'subject_id' => 'required|exists:subjects,id',
            'exam_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'total_marks' => 'required|integer|min:1|max:1000',
            'passing_percentage' => 'nullable|integer|min:0|max:100',
            'description' => 'nullable|string',
            'status' => 'required|in:scheduled,ongoing,completed,cancelled',
            'is_published' => 'boolean',
        ]);

        // Handle published_at
        if ($request->has('is_published') && $request->is_published) {
            $validated['published_at'] = now();
        }

        // Create exam
        $exam = Exam::create($validated);

        return redirect()->route('admin.exams.index')
            ->with('success', 'Exam created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Exam $exam)
    {
        $exam->load(['schoolClass', 'section', 'subject', 'results']);

        return view('admin.exams.show', compact('exam'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Exam $exam)
    {
        $classes = SchoolClass::orderBy('name')->get();
        $subjects = Subject::orderBy('name')->get();

        // If you need sections for the selected class
        $sections = Section::where('school_class_id', $exam->school_class_id)
            ->orderBy('name')
            ->get();

        return view('admin.exams.edit', compact('exam', 'classes', 'subjects', 'sections'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Exam $exam)
    {
        // Validation
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'academic_year' => 'required|string|max:9',
            'term' => 'required|string|max:1',
            'school_class_id' => 'required|exists:school_classes,id',
            'section_id' => 'required|exists:sections,id',
            'subject_id' => 'required|exists:subjects,id',
            'exam_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'total_marks' => 'required|integer|min:1|max:1000',
            'passing_percentage' => 'nullable|integer|min:0|max:100',
            'description' => 'nullable|string',
            'status' => 'required|in:scheduled,ongoing,completed,cancelled',
            'is_published' => 'boolean',
        ]);

        // Handle published_at
        if ($request->has('is_published') && $request->is_published && !$exam->is_published) {
            $validated['published_at'] = now();
        } elseif (!$request->has('is_published') || !$request->is_published) {
            $validated['published_at'] = null;
        }

        // Update exam
        $exam->update($validated);

        return redirect()->route('admin.exams.index')
            ->with('success', 'Exam updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Exam $exam)
    {
        $exam->delete();

        return redirect()->route('admin.exams.index')
            ->with('success', 'Exam deleted successfully!');
    }

    /**
     * Publish an exam
     */
    public function publish(Exam $exam)
    {
        if (!$exam->is_published) {
            $exam->update([
                'is_published' => true,
                'published_at' => now()
            ]);

            return redirect()->back()
                ->with('success', 'Exam published successfully!');
        }

        return redirect()->back()
            ->with('warning', 'Exam is already published.');
    }

    /**
     * Update exam status
     */
    public function updateStatus(Request $request, Exam $exam)
    {
        $request->validate([
            'status' => 'required|in:scheduled,ongoing,completed,cancelled'
        ]);

        $exam->update(['status' => $request->status]);

        return redirect()->back()
            ->with('success', 'Exam status updated successfully!');
    }

    /**
     * Get sections by class ID (for AJAX)
     */
    public function getSectionsByClass($classId)
    {
        $sections = Section::where('school_class_id', $classId)
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($sections);
    }
}
