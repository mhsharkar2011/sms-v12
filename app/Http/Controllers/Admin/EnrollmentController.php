<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class EnrollmentController extends Controller
{
    /**
     * Display a listing of enrollments.
     */
    public function index(Request $request)
    {
        $query = Enrollment::with(['student.user', 'class', 'enrolledBy'])
            ->latest();

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('enrollment_id', 'like', "%{$search}%")
                    ->orWhereHas('student.user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->orWhereHas('class', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('code', 'like', "%{$search}%");
                    });
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Class filter
        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }

        // Academic year filter
        if ($request->filled('academic_year')) {
            $query->whereHas('class', function ($q) use ($request) {
                $q->where('academic_year', $request->academic_year);
            });
        }

        $enrollments = $query->paginate(20);
        $classes = SchoolClass::active()->orderBy('name')->get();
        $academicYears = SchoolClass::distinct()->pluck('academic_year');

        return view('admin.enrollments.index', compact('enrollments', 'classes', 'academicYears'));
    }

    /**
     * Show the form for creating a new enrollment.
     */
    public function create(Request $request)
    {
        $students = Student::with('user')
            ->whereDoesntHave('enrollments', function ($query) use ($request) {
                $query->where('status', 'enrolled');
            })
            ->orderByHasUser('name')
            ->get();

        $classes = SchoolClass::withCount('students')
            ->active()
            ->orderBy('name')
            ->get()
            ->filter(function ($class) {
                return $class->hasAvailableSeats();
            });

        $selectedClass = $request->class_id ? SchoolClass::find($request->class_id) : null;
        $selectedStudent = $request->student_id ? Student::find($request->student_id) : null;

        return view('admin.enrollments.create', compact('students', 'classes', 'selectedClass', 'selectedStudent'));
    }

    /**
     * Store a newly created enrollment in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => [
                'required',
                'exists:students,id',
                Rule::unique('enrollments')->where(function ($query) use ($request) {
                    return $query->where('class_id', $request->class_id)
                        ->whereIn('status', ['pending', 'enrolled']);
                })
            ],
            'class_id' => 'required|exists:school_classes,id',
            'enrollment_date' => 'required|date',
            'start_date' => 'required|date',
            'tuition_fee' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string|max:500',
        ]);

        // Check if class has available seats
        $class = SchoolClass::findOrFail($validated['class_id']);
        if (!$class->hasAvailableSeats()) {
            return back()->withInput()
                ->with('error', 'Class has reached maximum capacity. No seats available.');
        }

        DB::beginTransaction();

        try {
            $enrollment = Enrollment::create([
                'student_id' => $validated['student_id'],
                'class_id' => $validated['class_id'],
                'enrollment_date' => $validated['enrollment_date'],
                'start_date' => $validated['start_date'],
                'tuition_fee' => $validated['tuition_fee'] ?? $class->default_tuition_fee,
                'notes' => $validated['notes'],
                'status' => Enrollment::STATUS_ENROLLED,
                'enrolled_by' => auth()->id(),
            ]);

            DB::commit();

            return redirect()->route('admin.enrollments.show', $enrollment)
                ->with('success', 'Student enrolled successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withInput()
                ->with('error', 'Failed to enroll student: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified enrollment.
     */
    public function show(Enrollment $enrollment)
    {
        $enrollment->load(['student.user', 'class', 'enrolledBy', 'approvedBy', 'transferredToClass']);

        return view('admin.enrollments.show', compact('enrollment'));
    }

    /**
     * Show the form for editing the specified enrollment.
     */
    public function edit(Enrollment $enrollment)
    {
        $students = Student::with('user')->orderByHasUser('name')->get();
        $classes = SchoolClass::active()->orderBy('name')->get();

        return view('admin.enrollments.edit', compact('enrollment', 'students', 'classes'));
    }

    /**
     * Update the specified enrollment in storage.
     */
    public function update(Request $request, Enrollment $enrollment)
    {
        $validated = $request->validate([
            'student_id' => [
                'required',
                'exists:students,id',
                Rule::unique('enrollments')->ignore($enrollment->id)->where(function ($query) use ($request) {
                    return $query->where('class_id', $request->class_id)
                        ->whereIn('status', ['pending', 'enrolled']);
                })
            ],
            'class_id' => 'required|exists:school_classes,id',
            'enrollment_date' => 'required|date',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:pending,enrolled,completed,withdrawn,transferred',
            'final_grade' => 'nullable|numeric|min:0|max:100',
            'grade_letter' => 'nullable|string|max:2',
            'gpa' => 'nullable|numeric|min:0|max:4',
            'tuition_fee' => 'nullable|numeric|min:0',
            'amount_paid' => 'nullable|numeric|min:0',
            'withdrawal_date' => 'nullable|date',
            'withdrawal_reason' => 'nullable|string|max:500',
            'notes' => 'nullable|string|max:500',
        ]);

        DB::beginTransaction();

        try {
            // If class is changed, check availability
            if ($enrollment->class_id != $validated['class_id']) {
                $newClass = SchoolClass::findOrFail($validated['class_id']);
                if (!$newClass->hasAvailableSeats()) {
                    return back()->withInput()
                        ->with('error', 'Selected class has reached maximum capacity.');
                }
            }

            $enrollment->update($validated);

            DB::commit();

            return redirect()->route('admin.enrollments.show', $enrollment)
                ->with('success', 'Enrollment updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withInput()
                ->with('error', 'Failed to update enrollment: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified enrollment from storage.
     */
    public function destroy(Enrollment $enrollment)
    {
        DB::beginTransaction();

        try {
            $enrollment->delete();

            DB::commit();

            return redirect()->route('admin.enrollments.index')
                ->with('success', 'Enrollment deleted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Failed to delete enrollment: ' . $e->getMessage());
        }
    }

    /**
     * Approve a pending enrollment.
     */
    public function approve(Enrollment $enrollment)
    {
        if ($enrollment->status !== Enrollment::STATUS_PENDING) {
            return back()->with('error', 'Only pending enrollments can be approved.');
        }

        DB::beginTransaction();

        try {
            $enrollment->update([
                'status' => Enrollment::STATUS_ENROLLED,
                'approved_by' => auth()->id(),
                'approved_at' => now(),
            ]);

            DB::commit();

            return back()->with('success', 'Enrollment approved successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Failed to approve enrollment: ' . $e->getMessage());
        }
    }

    /**
     * Withdraw an enrollment.
     */
    public function withdraw(Request $request, Enrollment $enrollment)
    {
        $validated = $request->validate([
            'withdrawal_reason' => 'required|string|max:500',
            'withdrawal_date' => 'required|date',
        ]);

        if (!$enrollment->isActive()) {
            return back()->with('error', 'Only active enrollments can be withdrawn.');
        }

        DB::beginTransaction();

        try {
            $enrollment->withdraw($validated['withdrawal_reason'], $validated['withdrawal_date']);

            DB::commit();

            return back()->with('success', 'Enrollment withdrawn successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Failed to withdraw enrollment: ' . $e->getMessage());
        }
    }

    /**
     * Complete an enrollment.
     */
    public function complete(Request $request, Enrollment $enrollment)
    {
        $validated = $request->validate([
            'final_grade' => 'required|numeric|min:0|max:100',
            'grade_letter' => 'required|string|max:2',
            'gpa' => 'nullable|numeric|min:0|max:4',
            'end_date' => 'required|date',
        ]);

        if (!$enrollment->isActive()) {
            return back()->with('error', 'Only active enrollments can be completed.');
        }

        DB::beginTransaction();

        try {
            $enrollment->update([
                'status' => Enrollment::STATUS_COMPLETED,
                'final_grade' => $validated['final_grade'],
                'grade_letter' => $validated['grade_letter'],
                'gpa' => $validated['gpa'],
                'end_date' => $validated['end_date'],
            ]);

            DB::commit();

            return back()->with('success', 'Enrollment completed successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Failed to complete enrollment: ' . $e->getMessage());
        }
    }

    /**
     * Record a payment for an enrollment.
     */
    public function recordPayment(Request $request, Enrollment $enrollment)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'payment_method' => 'required|string',
            'reference' => 'nullable|string|max:100',
            'notes' => 'nullable|string|max:500',
        ]);

        DB::beginTransaction();

        try {
            // Create payment record (you might have a Payment model)
            // For now, we'll update the enrollment directly
            $enrollment->recordPayment($validated['amount']);

            // You could also create a payment record here

            DB::commit();

            return back()->with('success', 'Payment recorded successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Failed to record payment: ' . $e->getMessage());
        }
    }

    /**
     * Update attendance for an enrollment.
     */
    public function updateAttendance(Request $request, Enrollment $enrollment)
    {
        $validated = $request->validate([
            'total_classes' => 'required|integer|min:0',
            'classes_attended' => 'required|integer|min:0|max:' . $request->total_classes,
        ]);

        DB::beginTransaction();

        try {
            $enrollment->update([
                'total_classes' => $validated['total_classes'],
                'classes_attended' => $validated['classes_attended'],
                'classes_absent' => $validated['total_classes'] - $validated['classes_attended'],
            ]);

            DB::commit();

            return back()->with('success', 'Attendance updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Failed to update attendance: ' . $e->getMessage());
        }
    }

    /**
     * Transfer enrollment to another class.
     */
    public function transfer(Request $request, Enrollment $enrollment)
    {
        $validated = $request->validate([
            'new_class_id' => 'required|exists:school_classes,id',
            'transfer_date' => 'required|date',
            'notes' => 'nullable|string|max:500',
        ]);

        if (!$enrollment->isActive()) {
            return back()->with('error', 'Only active enrollments can be transferred.');
        }

        $newClass = SchoolClass::findOrFail($validated['new_class_id']);

        if (!$newClass->hasAvailableSeats()) {
            return back()->with('error', 'The new class has reached maximum capacity.');
        }

        DB::beginTransaction();

        try {
            $newEnrollment = $enrollment->transferTo($newClass, $validated['transfer_date']);

            DB::commit();

            return redirect()->route('admin.enrollments.show', $newEnrollment)
                ->with('success', 'Student transferred successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Failed to transfer enrollment: ' . $e->getMessage());
        }
    }

    /**
     * Get enrollments for a specific class.
     */
    public function classEnrollments(SchoolClass $class)
    {
        $enrollments = $class->enrollments()
            ->with(['student.user', 'enrolledBy'])
            ->latest()
            ->paginate(20);

        return view('admin.enrollments.class', compact('class', 'enrollments'));
    }

    /**
     * Get enrollments for a specific student.
     */
    public function studentEnrollments(Student $student)
    {
        $enrollments = $student->enrollments()
            ->with(['class', 'enrolledBy'])
            ->latest()
            ->paginate(20);

        return view('admin.enrollments.student', compact('student', 'enrollments'));
    }
}
