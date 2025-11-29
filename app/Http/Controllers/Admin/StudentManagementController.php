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
        $roleFilter = $request->get('role');
        $status = $request->get('status');
        $search = $request->get('search');

        // Build query with filters - only get students
        $students = User::role('student')
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->with('roles')
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.students.index', compact('students'));
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
        // Validate the request
        $validated = $request->validate([
            // User fields
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,inactive,pending',

            // Student fields
            'student_id' => 'nullable|string|unique:students,student_id',
            'admission_number' => 'nullable|string|unique:students,admission_number',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'blood_group' => 'nullable|string|max:10',
            'nationality' => 'nullable|string|max:100',
            'religion' => 'nullable|string|max:100',
            'caste' => 'nullable|string|max:100',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'pincode' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'emergency_contact_relation' => 'nullable|string|max:100',
            'admission_date' => 'required|date',
            'class_id' => 'nullable|exists:school_classes,id',
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
        ]);

        try {
            DB::beginTransaction();

            // Handle avatar upload
            $avatarPath = null;
            if ($request->hasFile('avatar')) {
                $avatarPath = $request->file('avatar')->store('avatars', 'public');
            }

            // Create User account
            $user = User::create([
                'name' => $validated['first_name'] . ' ' . $validated['last_name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'phone' => $validated['phone'] ?? null,
                'avatar' => $avatarPath,
                'status' => $validated['status'],
                'address' => $validated['address'] ?? null,
            ]);

            // Assign student role
            $user->assignRole('student');

            // Process array fields for allergies and medications
            $allergies = !empty($validated['allergies']) ?
                array_map('trim', explode(',', $validated['allergies'])) : [];
            $medications = !empty($validated['medications']) ?
                array_map('trim', explode(',', $validated['medications'])) : [];

            // Create Student record
            $studentData = [
                'user_id' => $user->id,
                'student_id' => $validated['student_id'] ?? Student::generateStudentId(),
                'admission_number' => $validated['admission_number'] ?? Student::generateAdmissionNumber(),
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
                'date_of_birth' => $validated['date_of_birth'],
                'gender' => $validated['gender'],
                'blood_group' => $validated['blood_group'] ?? null,
                'nationality' => $validated['nationality'] ?? null,
                'religion' => $validated['religion'] ?? null,
                'caste' => $validated['caste'] ?? null,
                'address' => $validated['address'] ?? null,
                'city' => $validated['city'] ?? null,
                'state' => $validated['state'] ?? null,
                'pincode' => $validated['pincode'] ?? null,
                'country' => $validated['country'] ?? null,
                'emergency_contact_name' => $validated['emergency_contact_name'] ?? null,
                'emergency_contact_phone' => $validated['emergency_contact_phone'] ?? null,
                'emergency_contact_relation' => $validated['emergency_contact_relation'] ?? null,
                'admission_date' => $validated['admission_date'],
                'class_id' => $validated['class_id'] ?? null,
                'grade_level' => $validated['grade_level'],
                'roll_number' => $validated['roll_number'] ?? null,
                'section' => $validated['section'] ?? null,
                'academic_year' => $validated['academic_year'],
                'avatar' => $avatarPath,
                'medical_notes' => $validated['medical_notes'] ?? null,
                'allergies' => $allergies,
                'medications' => $medications,
                'transport_route' => $validated['transport_route'] ?? null,
                'special_instructions' => $validated['special_instructions'] ?? null,
                'status' => $validated['status'],
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
    public function show(string $id)
    {
        $student = User::role('student')->findOrFail($id);
        return view('admin.students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $student)
    {

        $student = Student::where('user_id', $student->id)->firstOrFail();
       
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
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
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
