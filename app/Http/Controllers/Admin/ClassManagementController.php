<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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



    public function create()
    {
        // Get all teachers for the dropdown
        $teachers = User::where('role', 'teacher')
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        return view('admin.classes.create', compact('teachers'));
    }

    /**
     * Store a newly created class in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate($this->validationRules());

        // Convert meeting days array to string
        if (isset($validated['meeting_days'])) {
            $validated['meeting_days'] = implode(',', $validated['meeting_days']);
        }

        // Generate a slug for the class
        $validated['slug'] = $this->generateUniqueSlug($validated['name']);

        DB::beginTransaction();

        try {
            // Create the class
            $class = SchoolClass::create($validated);

            // If teacher is assigned, update the teacher's class_id
            if (!empty($validated['teacher_id'])) {
                $teacher = Teacher::find($validated['teacher_id']);
                if ($teacher) {
                    $teacher->update(['class_id' => $class->id]);
                }
            }

            DB::commit();

            return redirect()->route('admin.classes.index')
                ->with('success', 'Class created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withInput()
                ->with('error', 'Failed to create class. Please try again.');
        }
    }

    /**
     * Show the form for editing the specified class.
     */
    public function edit(ClassModel $class)
    {
        // Get all teachers for the dropdown
        $teachers = User::where('role', 'teacher')
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        // Convert meeting days string back to array
        if ($class->meeting_days) {
            $class->meeting_days = explode(',', $class->meeting_days);
        }

        return view('admin.classes.edit', compact('class', 'teachers'));
    }


    /**
     * Update the specified class in storage.
     */
    public function update(Request $request, ClassModel $class)
    {
        // Validate the request
        $validated = $request->validate($this->validationRules($class->id));

        // Convert meeting days array to string
        if (isset($validated['meeting_days'])) {
            $validated['meeting_days'] = implode(',', $validated['meeting_days']);
        } else {
            $validated['meeting_days'] = null;
        }

        DB::beginTransaction();

        try {
            // Update the class
            $class->update($validated);

            // Handle teacher assignment changes
            $this->handleTeacherAssignment($class, $validated['teacher_id'] ?? null);

            DB::commit();

            return redirect()->route('admin.classes.index')
                ->with('success', 'Class updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withInput()
                ->with('error', 'Failed to update class. Please try again.');
        }
    }


    /**
     * Get the validation rules.
     */
    private function validationRules($classId = null)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:classes,code' . ($classId ? ',' . $classId : ''),
            'grade_level' => 'required|string|max:50',
            'section' => 'required|string|max:10',
            'subject' => 'nullable|string|max:255',
            'room_number' => 'nullable|string|max:50',
            'academic_year' => 'required|string|max:9|regex:/^\d{4}-\d{4}$/',
            'capacity' => 'required|integer|min:1|max:100',
            'description' => 'nullable|string',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'meeting_days' => 'nullable|array',
            'meeting_days.*' => 'string|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'status' => 'required|string|in:active,inactive,planned',
            'teacher_id' => 'nullable|exists:users,id'
        ];

        // Add conditional rule for end_time
        $rules['end_time'] = [
            'nullable',
            'date_format:H:i',
            function ($attribute, $value, $fail) use ($request) {
                $startTime = $request->input('start_time');
                if ($startTime && $value && $startTime >= $value) {
                    $fail('End time must be after start time.');
                }
            },
        ];

        return $rules;
    }

    /**
     * Generate a unique slug for the class.
     */
    private function generateUniqueSlug($name)
    {
        $slug = \Str::slug($name);
        $originalSlug = $slug;
        $count = 1;

        while (SchoolClass::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        return $slug;
    }


    /**
     * Handle teacher assignment logic.
     */
    private function handleTeacherAssignment(SchoolClass $class, $newTeacherId = null)
    {
        // Get current teacher if exists
        $currentTeacher = Teacher::where('class_id', $class->id)
            ->where('role', 'teacher')
            ->first();

        // If teacher changed
        if ($currentTeacher && $currentTeacher->id != $newTeacherId) {
            // Remove current teacher from this class
            $currentTeacher->update(['class_id' => null]);
        }

        // Assign new teacher if provided
        if ($newTeacherId) {
            $newTeacher = Teacher::find($newTeacherId);
            if ($newTeacher) {
                // Check if teacher is already assigned to another class
                if ($newTeacher->class_id && $newTeacher->class_id != $class->id) {
                    // You might want to show a warning here or prevent reassignment
                    // For now, we'll allow reassignment
                }

                $newTeacher->update(['class_id' => $class->id]);
            }
        }
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
