<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use PhpParser\Node\Expr\FuncCall;

class ClassManagementController extends Controller
{
    public function index(Request $request)
    {
        // Query classes WITHOUT the withCount that's causing the error
        $query = SchoolClass::with(['teachers.user']); // Remove 'students.user' for now

        // Apply filters if needed
        if ($request->has('q') && $request->q) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->orWhere('room_number', 'like', "%{$search}%");
            });
        }

        if ($request->has('grade_level') && $request->grade_level) {
            $query->where('grade_level', $request->grade_level);
        }

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Paginate with query string
        $classes = $query->paginate($request->per_page ?? 10)
            ->withQueryString();

        // Manually count students for each class
        $classes->each(function ($class) {
            // Try to get student count without using pivot table
            try {
                // If using class_id in students table
                if (Schema::hasColumn('students', 'class_id')) {
                    $class->current_strength = Student::where('class_id', $class->id)->count();
                }
                // If pivot table exists
                elseif (Schema::hasTable('class_student')) {
                    $class->current_strength = DB::table('class_student')
                        ->where('class_id', $class->id)
                        ->count();
                }
                // Fallback to 0
                else {
                    $class->current_strength = 0;
                }
            } catch (\Exception $e) {
                $class->current_strength = 0;
            }

            // Calculate percentages
            $class->capacity_percentage = $class->capacity > 0
                ? min(100, ($class->current_strength / $class->capacity) * 100)
                : 0;

            // Mock data for demo
            $class->average_attendance = rand(85, 98);
            $class->average_grade = rand(65, 95);

            // Get teacher info
            if ($class->relationLoaded('teachers') && $class->teachers->count() > 0) {
                $teacher = $class->teachers->first();
                $class->teacher_name = optional($teacher->user)->name ?? $teacher->name ?? 'Not Assigned';
                $class->teacher_email = optional($teacher->user)->email ?? $teacher->email ?? '';
            } else {
                $class->teacher_name = 'Not Assigned';
                $class->teacher_email = '';
            }
        });

        // Statistics - FIXED
        $totalClasses = SchoolClass::count();
        $activeClasses = SchoolClass::where('status', 'active')->count();

        // Calculate total students
        $totalStudents = Student::count();

        // Calculate average class size
        $totalStudentAssignments = 0;
        if (Schema::hasColumn('students', 'class_id')) {
            $totalStudentAssignments = Student::whereNotNull('class_id')->count();
        } elseif (Schema::hasTable('class_student')) {
            $totalStudentAssignments = DB::table('class_student')->count();
        }

        $averageClassSize = $totalClasses > 0 ? $totalStudentAssignments / $totalClasses : 0;

        // Additional statistics
        $maxCapacity = SchoolClass::max('capacity') ?? 100;

        // Fix overcrowded classes calculation
        $overcrowdedClasses = 0;
        foreach ($classes as $class) {
            if ($class->current_strength > $class->capacity) {
                $overcrowdedClasses++;
            }
        }

        $teacherStudentRatio = $totalStudents > 0 ? $totalStudents / Teacher::count() : 0;

        // Growth calculation (compared to last month)
        $lastMonthClasses = SchoolClass::whereMonth('created_at', now()->subMonth()->month)->count();
        $classGrowth = $lastMonthClasses > 0 ? (($totalClasses - $lastMonthClasses) / $lastMonthClasses) * 100 : 0;

        // Grade distribution
        $gradeDistribution = SchoolClass::select('grade_level', DB::raw('count(*) as count'))
            ->groupBy('grade_level')
            ->orderBy('grade_level')
            ->pluck('count', 'grade_level')
            ->toArray();

        // Get recent activities and upcoming events
        $recentActivities = $this->getRecentActivities();
        $upcomingEvents = $this->getUpcomingEvents($totalClasses);

        // Get available teachers for filter
        $teachers = Teacher::with('user')
            ->where('status', 'active')
            ->orderBy('id')
            ->get();

        // Get unique subjects
        $subjects = \App\Models\Subject::orderBy('name')
            ->pluck('name', 'id')
            ->toArray();

        // Get academic years
        $academicYears = SchoolClass::whereNotNull('academic_year')
            ->distinct()
            ->orderBy('academic_year', 'desc')
            ->pluck('academic_year')
            ->toArray();

        // Get grade levels for filter
        $gradeLevels = SchoolClass::distinct()
            ->orderBy('grade_level')
            ->pluck('grade_level')
            ->toArray();

        return view('admin.classes.index', compact(
            'classes',
            'totalClasses',
            'activeClasses',
            'totalStudents',
            'averageClassSize',
            'gradeLevels',
            'maxCapacity',
            'overcrowdedClasses',
            'teacherStudentRatio',
            'classGrowth',
            'gradeDistribution',
            'recentActivities',
            'upcomingEvents',
            'teachers',
            'subjects',
            'academicYears'
        ));
    }

    /**
     * Get recent activities from database logs
     */
    private function getRecentActivities()
    {
        // Try to get real activities from activity logs if you have them
        try {
            // If you have activity logs
            if (class_exists('\Spatie\Activitylog\Models\Activity')) {
                $activities = \Spatie\Activitylog\Models\Activity::where('log_name', 'class')
                    ->orderBy('created_at', 'desc')
                    ->take(5)
                    ->get()
                    ->map(function ($activity) {
                        return [
                            'icon' => $this->getActivityIcon($activity->description),
                            'color' => $this->getActivityColor($activity->description),
                            'description' => $activity->description . ' - ' . optional($activity->causer)->name,
                            'time' => $activity->created_at->diffForHumans(),
                            'type' => ucfirst($activity->description),
                            'type_color' => 'text-blue-600',
                            'class_id' => $activity->subject_id ?? null
                        ];
                    })
                    ->toArray();

                if (!empty($activities)) {
                    return $activities;
                }
            }
        } catch (\Exception $e) {
            // Fall back to sample data
        }

        // Sample data
        return [
            [
                'icon' => 'person_add',
                'color' => 'bg-green-500',
                'description' => 'New students assigned to classes',
                'time' => '2 hours ago',
                'type' => 'Assignment',
                'type_color' => 'text-green-600',
                'class_id' => 1
            ],
            [
                'icon' => 'edit',
                'color' => 'bg-blue-500',
                'description' => 'Class schedule updated',
                'time' => '5 hours ago',
                'type' => 'Update',
                'type_color' => 'text-blue-600',
                'class_id' => 2
            ],
            [
                'icon' => 'class',
                'color' => 'bg-purple-500',
                'description' => 'New class created: Grade 11-B',
                'time' => '1 day ago',
                'type' => 'Creation',
                'type_color' => 'text-purple-600',
                'class_id' => null
            ],
        ];
    }

    /**
     * Get upcoming events
     */
    private function getUpcomingEvents($totalClasses)
    {
        // You can query from events table if you have one
        return [
            [
                'title' => 'Mid-term Exams',
                'description' => 'All classes',
                'date' => 'Next Week',
                'time' => 'Mon-Fri',
                'class_count' => $totalClasses
            ],
            [
                'title' => 'Parent-Teacher Meeting',
                'description' => 'Grade 10 Parents',
                'date' => now()->addDays(7)->format('M d'),
                'time' => '2:00 PM',
                'class_count' => 8
            ],
            [
                'title' => 'Sports Day',
                'description' => 'All students',
                'date' => now()->addDays(14)->format('M d'),
                'time' => '9:00 AM',
                'class_count' => $totalClasses
            ],
        ];
    }

    /**
     * Get icon for activity type
     */
    private function getActivityIcon($activityType)
    {
        $icons = [
            'created' => 'add',
            'updated' => 'edit',
            'deleted' => 'delete',
            'assigned' => 'person_add',
            'removed' => 'person_remove',
            'default' => 'notifications'
        ];

        foreach ($icons as $key => $icon) {
            if (stripos($activityType, $key) !== false) {
                return $icon;
            }
        }

        return $icons['default'];
    }

    /**
     * Get color for activity type
     */
    private function getActivityColor($activityType)
    {
        $colors = [
            'created' => 'bg-green-500',
            'updated' => 'bg-blue-500',
            'deleted' => 'bg-red-500',
            'assigned' => 'bg-purple-500',
            'removed' => 'bg-orange-500',
            'default' => 'bg-gray-500'
        ];

        foreach ($colors as $key => $color) {
            if (stripos($activityType, $key) !== false) {
                return $color;
            }
        }

        return $colors['default'];
    }


    public function create()
    {
        // Debug: Get first user and see available columns
        $firstUser = User::first();
        if ($firstUser) {
            \Log::info('User attributes:', $firstUser->getAttributes());
            \Log::info('User columns:', array_keys($firstUser->getAttributes()));
        }

        // For now, get all active users
        $teachers = Teacher::with('user')->get();
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
    public function edit(SchoolClass $class)
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
    public function update(Request $request, SchoolClass $class)
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

    public function getStudentsForAssignment(SchoolClass $class)
    {
        try {
            // Get all available students with user relationship
            $students = Student::with('user')
                ->where('status', 'active')
                ->orderByRaw('(SELECT name FROM users WHERE users.id = students.user_id)')
                ->get()
                ->map(function ($student) {
                    $user = $student->user;

                    // Split full name from users table into first and last
                    $fullName = $user->name ?? 'Unknown Student';
                    $nameParts = explode(' ', $fullName, 2);

                    return [
                        'id' => $student->id,
                        'first_name' => $nameParts[0] ?? '',
                        'last_name' => $nameParts[1] ?? '',
                        'email' => $student->email ?? $user->email ?? '',
                        'student_id' => $student->student_id ?? 'N/A',
                        'grade_level' => $student->grade_level ?? '',
                        'full_name' => $fullName,
                    ];
                });

            // Get currently assigned students
            $assignedStudents = $class->students()->pluck('students.id')->toArray();

            return response()->json([
                'success' => true,
                'students' => $students,
                'assignedStudents' => $assignedStudents,
                'capacity' => $class->capacity,
                'class_name' => $class->name,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'students' => [],
                'assignedStudents' => []
            ], 500);
        }
    }

    public function assignStudents(Request $request, SchoolClass $class)
    {
        $request->validate([
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:students,id'
        ]);

        try {
            DB::beginTransaction();

            Log::info('Assigning students to class', [
                'class_id' => $class->id,
                'class_name' => $class->name,
                'student_ids' => $request->student_ids,
                'student_count' => count($request->student_ids)
            ]);

            // For HasMany relationship, we need to update the class_id on each student
            // First, remove all students from this class (set class_id to null)
            Student::where('class_id', $class->id)->update(['class_id' => null]);

            // Then assign the new students to this class
            Student::whereIn('id', $request->student_ids)->update(['class_id' => $class->id]);

            // Update current strength
            $class->update([
                'current_strength' => count($request->student_ids)
            ]);

            DB::commit();

            Log::info('Successfully assigned students to class', [
                'class_id' => $class->id,
                'student_count' => count($request->student_ids)
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Students assigned successfully!',
                'should_reload' => true
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error assigning students: ' . $e->getMessage(), [
                'class_id' => $class->id,
                'student_ids' => $request->student_ids,
                'exception' => $e
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to assign students: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getTeachersForAssignment(SchoolClass $class)
    {
        try {
            // Get all available teachers
            $teachers = Teacher::with('user')
                ->where('status', 'active')
                ->select('id', 'user_id')
                ->orderBy('id')
                ->get()
                ->map(function ($teacher) {
                    return [
                        'id' => $teacher->id,
                        'name' => $teacher->user->name ?? $teacher->name,
                        'email' => $teacher->user->email ?? $teacher->email,
                        'subjects' => $teacher->subjects_taught ?? 'General',
                    ];
                });

            // Get current teacher for this class
            $currentTeacherId = null;
            if ($class->teacher_id) {
                $currentTeacherId = $class->teacher_id;
            } elseif ($class->teachers()->exists()) {
                $currentTeacherId = $class->teachers()->first()?->id;
            }

            return response()->json([
                'success' => true,
                'teachers' => $teachers,
                'currentTeacherId' => $currentTeacherId,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'teachers' => [],
                'currentTeacherId' => null
            ], 500);
        }
    }

    public function assignTeacher(Request $request, SchoolClass $class)
    {
        $request->validate([
            'teacher_id' => 'required|exists:teachers,id'
        ]);

        try {
            \DB::beginTransaction();

            // Assign teacher (adjust based on your relationship)
            if (Schema::hasColumn('school_classes', 'teacher_id')) {
                // If using teacher_id column
                $class->update(['teacher_id' => $request->teacher_id]);
            } else {
                // If using many-to-many relationship
                $class->teachers()->sync([$request->teacher_id]);
            }

            \DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Teacher assigned successfully!',
            ]);
        } catch (\Exception $e) {
            \DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to assign teacher: ' . $e->getMessage()
            ], 500);
        }
    }
    public function classExport()
    {
        //
    }
}
