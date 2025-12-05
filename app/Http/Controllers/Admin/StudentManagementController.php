<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class StudentManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get filter parameters
        $status = $request->get('status');
        $search = $request->get('search');
        $classFilter = $request->get('class_id');

        // Build query with filters
        $students = Student::with(['user', 'user.roles', 'schoolClass'])
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($classFilter, function ($query, $classId) {
                return $query->where('class_id', $classId);
            })
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    // Search in student-specific fields
                    $q->where('student_id', 'like', "%{$search}%")
                        ->orWhere('admission_number', 'like', "%{$search}%")
                        ->orWhere('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        // Search in user email through relationship
                        ->orWhereHas('user', function ($userQuery) use ($search) {
                            $userQuery->where('email', 'like', "%{$search}%")
                                ->orWhere('phone', 'like', "%{$search}%");
                        });
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        // Get classes for filter dropdown
        $classes = SchoolClass::all();

        return view('admin.students.index', compact('students', 'classes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        $classes = SchoolClass::active()->get();
        return view('admin.students.create', compact('roles', 'classes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            Log::info('Avatar file details:', [
                'name' => $request->file('avatar')->getClientOriginalName(),
                'size' => $request->file('avatar')->getSize(),
                'mime' => $request->file('avatar')->getMimeType(),
            ]);
        }

        // Validate the request
        $userValidation = $request->validate([
            // User fields
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'address' => 'nullable|string|max:500',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,on_leave,inactive,pending',
        ]);
        $studentValidation = $request->validate([
            // Student fields
            'student_id' => 'nullable|string|unique:students,student_id',
            'class_id' => 'nullable|exists:school_classes,id',
            'admission_number' => 'nullable|string|unique:students,admission_number',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'blood_group' => 'nullable|string|max:10',
            'nationality' => 'nullable|string|max:100',
            'religion' => 'nullable|string|max:100',
            'caste' => 'nullable|string|max:100',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'emergency_contact_relation' => 'nullable|string|max:100',
            'admission_date' => 'required|date',
            'grade_level' => 'required|string|max:50',
            'roll_number' => 'nullable|string|max:50',
            'section' => 'nullable|string|max:50',
            'academic_year' => 'required|string|max:20',
            'medical_notes' => 'nullable|string',
            'allergies' => 'nullable|string',
            'medications' => 'nullable|string',
            'transport_route' => 'nullable|string|max:255',
            'special_instructions' => 'nullable|string',
            'is_boarder' => 'sometimes|boolean',
            'uses_transport' => 'sometimes|boolean',
            'status' => 'required|in:active,inactive,graduated,transferred,suspended',
        ]);

        try {
            DB::beginTransaction();

            Log::info('Step 3: Transaction started');

            // Handle avatar upload
            $userAvatarPath = null;
            $studentAvatarPath = null;

            if ($request->hasFile('avatar')) {
                Log::info('Step 4: Processing avatar upload');
                // For User
                $userAvatarName = 'user_' . time() . '_' . uniqid() . '.' . $request->file('avatar')->getClientOriginalExtension();
                $userAvatarPath = $request->file('avatar')->storeAs('avatars/users', $userAvatarName, 'public');
                Log::info('User avatar saved: ' . $userAvatarPath);

                // For Teacher (optional - can be same or different)
                $studentAvatarName = 'student_' . time() . '_' . uniqid() . '.' . $request->file('avatar')->getClientOriginalExtension();
                $studentAvatarPath = $request->file('avatar')->storeAs('avatars/students', $studentAvatarName, 'public');
                Log::info('Teacher avatar saved: ' . $studentAvatarPath);
            } else {
                Log::info('Step 4: No avatar uploaded, using defaults');
                $userAvatarPath = 'default-avatar.png'; // Store string for default
                $studentAvatarPath = null; // Teacher gets null
            }


            // Create User account
            $user = User::create([
                'name' => $userValidation['first_name'] . ' ' . $userValidation['last_name'],
                'email' => $userValidation['email'],
                'password' => Hash::make($userValidation['password']),
                'phone' => $userValidation['phone'] ?? null,
                'avatar' => $userAvatarPath,
                'address' => $userValidation['address'] ?? null,
                'status' => $userValidation['status'],
            ]);

            // Assign student role
            $user->assignRole('student');

            // Process array fields for allergies and medications
            $allergies = !empty($studentValidation['allergies']) ?
                array_map('trim', explode(',', $studentValidation['allergies'])) : [];
            $medications = !empty($studentValidation['medications']) ?
                array_map('trim', explode(',', $studentValidation['medications'])) : [];

            // Create Student record
            $studentData = [
                'user_id' => $user->id,
                'student_id' => $studentValidation['student_id'] ?? Student::generateStudentId(),
                'class_id' => $studentValidation['class_id'] ?? null,
                'admission_number' => $studentValidation['admission_number'] ?? Student::generateAdmissionNumber(),
                'date_of_birth' => $studentValidation['date_of_birth'],
                'gender' => $studentValidation['gender'],
                'blood_group' => $studentValidation['blood_group'] ?? null,
                'nationality' => $studentValidation['nationality'] ?? null,
                'religion' => $studentValidation['religion'] ?? null,
                'caste' => $studentValidation['caste'] ?? null,
                'address' => $studentValidation['address'] ?? null,
                'city' => $studentValidation['city'] ?? null,
                'state' => $studentValidation['state'] ?? null,
                'postal_code' => $studentValidation['postal_code'] ?? null,
                'country' => $studentValidation['country'] ?? null,
                'emergency_contact_name' => $studentValidation['emergency_contact_name'] ?? null,
                'emergency_contact_phone' => $studentValidation['emergency_contact_phone'] ?? null,
                'emergency_contact_relation' => $studentValidation['emergency_contact_relation'] ?? null,
                'admission_date' => $studentValidation['admission_date'],
                'grade_level' => $studentValidation['grade_level'],
                'roll_number' => $studentValidation['roll_number'] ?? null,
                'section' => $studentValidation['section'] ?? null,
                'academic_year' => $studentValidation['academic_year'],
                'avatar' => $studentAvatarPath,
                'medical_notes' => $studentValidation['medical_notes'] ?? null,
                'allergies' => $allergies,
                'medications' => $medications,
                'transport_route' => $studentValidation['transport_route'] ?? null,
                'special_instructions' => $studentValidation['special_instructions'] ?? null,
                'status' => $studentValidation['status'],
                'is_boarder' => $request->has('is_boarder') ? true : false,
                'uses_transport' => $request->has('uses_transport') ? true : false,
            ];

            $student = Student::create($studentData);

            DB::commit();

            // Log success
            Log::info('Student created successfully', [
                'student_id' => $student->student_id,
                'user_id' => $user->id,
                'email' => $user->email
            ]);

            return redirect()->route('admin.students.index')
                ->with('success', 'Student created successfully! Student ID: ' . $student->student_id);
        } catch (\Exception $e) {
            DB::rollBack();

            // Delete uploaded file if transaction fails
            if (isset($avatarPath)) {
                Storage::disk('public')->delete($avatarPath);
            }

            // Log the error
            Log::error('Error creating student: ' . $e->getMessage(), [
                'exception' => $e,
                'request_data' => $request->all()
            ]);

            return redirect()->back()
                ->with('error', 'Error creating student: ' . $e->getMessage())
                ->withInput();
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        $student = User::role('student')->findOrFail($student->user_id);
        return view('admin.students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $student = Student::with('user')->findOrFail($id);

        // Find student by ID and load relationships
        $student->load(['user.roles', 'schoolClass']);
        $user = $student->user;

        if (!$user) {
            abort(404, 'User not found for this student');
        }


        // Prepare roles for the edit form and currently assigned roles
        $roles = Role::all();

        // FIX: Get roles from the USER, not the student
        $assignedRoles = $user->roles->pluck('name')->toArray();

        $classes = SchoolClass::active()->get();

        // Pass both student and user to the view
        return view('admin.students.edit', compact('student', 'user', 'classes', 'roles', 'assignedRoles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);
        $user = $student->user;

        // Validation rules (similar to store but with unique email ignore)
        $validated = $request->validate([
            // User fields
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'nullable|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,inactive,pending',
            'remove_avatar' => 'sometimes|boolean',

            // Student fields (similar to store but with unique ignores)
            'student_id' => 'nullable|string|unique:students,student_id,' . $student->id,
            'admission_number' => 'nullable|string|unique:students,admission_number,' . $student->id,
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            // ... include all other validation rules from store method
        ]);

        try {
            DB::beginTransaction();

            // Handle avatar
            $avatarPath = $student->avatar;
            if ($request->hasFile('avatar')) {
                // Delete old avatar if exists
                if ($avatarPath) {
                    Storage::disk('public')->delete($avatarPath);
                }
                $avatarPath = $request->file('avatar')->store('avatars', 'public');
            } elseif ($request->has('remove_avatar')) {
                // Remove avatar if checkbox is checked
                if ($avatarPath) {
                    Storage::disk('public')->delete($avatarPath);
                }
                $avatarPath = null;
            }

            // Update User account
            $userData = [
                'name' => $validated['first_name'] . ' ' . $validated['last_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
                'avatar' => $avatarPath,
                'status' => $validated['status'],
                'address' => $validated['address'] ?? null,
            ];

            // Only update password if provided
            if (!empty($validated['password'])) {
                $userData['password'] = Hash::make($validated['password']);
            }

            $user->update($userData);

            // Update Student record (similar to store method but with update)
            $studentData = [
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
                'date_of_birth' => $validated['date_of_birth'],
                'gender' => $validated['gender'],
                // ... include all other student fields
                'avatar' => $avatarPath,
                'status' => $validated['status'],
            ];

            $student->update($studentData);

            DB::commit();

            return redirect()->route('admin.students.show', $student->id)
                ->with('success', 'Student updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error updating student: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Add your delete logic here
    }
}
