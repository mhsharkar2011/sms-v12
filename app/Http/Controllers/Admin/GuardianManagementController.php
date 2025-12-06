<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Guardian;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class GuardianManagementController extends Controller
{
    public function index()
    {
        $guardians = Guardian::with(['user', 'students'])
            ->withCount('students')
            ->latest()
            ->paginate(10);


        return view('admin.guardians.index', compact('guardians'));
    }

    public function create()
    {
        $students = Student::active()->get();
        return view('admin.guardians.create', compact('students'));
    }

    public function store(Request $request)
    {
        // Debug first
        Log::info('Creating guardian - Step 1: Validation started');
        Log::info('Request method: ' . $request->method());
        Log::info('Is ajax: ' . $request->ajax());
        Log::info('Has file avatar: ' . ($request->hasFile('avatar') ? 'Yes' : 'No'));

        if ($request->hasFile('avatar')) {
            Log::info('Avatar file details:', [
                'name' => $request->file('avatar')->getClientOriginalName(),
                'size' => $request->file('avatar')->getSize(),
                'mime' => $request->file('avatar')->getMimeType(),
            ]);
        }

        // Validate ALL fields before processing
        $validatedData = $request->validate([
            // User fields
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'status' => 'required|in:active,on_leave,inactive,pending',

            // Guardian fields
            'guardian_id' => 'required|string|unique:guardians,guardian_id',
            'relationship' => 'required|string|max:100',
            'occupation' => 'nullable|string|max:255',
            'employer' => 'nullable|string|max:255',
            'work_phone' => 'nullable|string|max:20',
            'work_email' => 'nullable|email|max:255',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'emergency_contact_relationship' => 'nullable|string|max:100',
            'medical_notes' => 'nullable|string',
            'notes' => 'nullable|string',
            'is_primary' => 'boolean',
            'can_pickup' => 'boolean',
            'receive_sms_alerts' => 'boolean',
            'receive_email_alerts' => 'boolean',
            'is_active' => 'boolean',

            // Avatar file validation
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

            // Student relationships
            'student_ids' => 'nullable|array',
            'student_ids.*' => 'exists:students,id',
        ]);

        Log::info('Step 2: Validation passed');

        try {
            DB::beginTransaction();
            Log::info('Step 3: Transaction started');

            // Handle avatar upload
            $userAvatarPath = null;
            $guardianAvatarPath = null;

            if ($request->hasFile('avatar')) {
                Log::info('Step 4: Processing avatar upload');

                // Store avatar once and use same file for both user and guardian
                $avatarFile = $request->file('avatar');
                $avatarName = 'avatar_' . time() . '_' . uniqid() . '.' . $avatarFile->getClientOriginalExtension();

                // Store in avatars directory (not in subdirectories for simplicity)
                $avatarPath = $avatarFile->storeAs('avatars', $avatarName, 'public');

                // Use same path for both user and guardian
                $userAvatarPath = $avatarPath;
                $guardianAvatarPath = $avatarPath;

                Log::info('Avatar saved: ' . $avatarPath);
            } else {
                Log::info('Step 4: No avatar uploaded, using defaults');
                $userAvatarPath = null; // Will use default from avatar_url accessor
                $guardianAvatarPath = null; // Will use default from avatar_url accessor
            }

            Log::info('Step 5: Creating user');

            // Create User with avatar
            $user = User::create([
                'first_name' => $validatedData['first_name'],
                'last_name' => $validatedData['last_name'],
                'name' => $validatedData['first_name'] . ' ' . $validatedData['last_name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'phone' => $validatedData['phone'] ?? null,
                'status' => $validatedData['status'],
                'avatar' => $userAvatarPath,
            ]);

            Log::info('User created with ID: ' . $user->id);

            // Assign guardian role
            $user->assignRole('guardian');
            Log::info('Role assigned: guardian');

            Log::info('Step 6: Creating guardian');

            // Create Guardian with avatar
            $guardian = Guardian::create([
                'user_id' => $user->id, // Make sure to set user_id
                'guardian_id' => $validatedData['guardian_id'],
                'relationship' => $validatedData['relationship'],
                'occupation' => $validatedData['occupation'] ?? null,
                'employer' => $validatedData['employer'] ?? null,
                'work_phone' => $validatedData['work_phone'] ?? null,
                'work_email' => $validatedData['work_email'] ?? null,
                'emergency_contact_name' => $validatedData['emergency_contact_name'] ?? null,
                'emergency_contact_phone' => $validatedData['emergency_contact_phone'] ?? null,
                'emergency_contact_relationship' => $validatedData['emergency_contact_relationship'] ?? null,
                'medical_notes' => $validatedData['medical_notes'] ?? null,
                'notes' => $validatedData['notes'] ?? null,
                'is_primary' => $validatedData['is_primary'] ?? false,
                'can_pickup' => $validatedData['can_pickup'] ?? false,
                'receive_sms_alerts' => $validatedData['receive_sms_alerts'] ?? true,
                'receive_email_alerts' => $validatedData['receive_email_alerts'] ?? true,
                'is_active' => $validatedData['is_active'] ?? true,
                'avatar' => $guardianAvatarPath,
            ]);

            Log::info('Guardian created with ID: ' . $guardian->id);

            // Attach students if provided
            if (!empty($validatedData['student_ids'])) {
                Log::info('Step 7: Attaching students to guardian');
                $guardian->students()->attach($validatedData['student_ids']);
                Log::info('Attached ' . count($validatedData['student_ids']) . ' students');
            }

            DB::commit();
            Log::info('Step 8: Transaction committed');

            return redirect()->route('admin.guardians.index')
                ->with('success', 'Guardian created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in guardian creation: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return redirect()->back()
                ->with('error', 'Error creating guardian: ' . $e->getMessage())
                ->withInput();
        }
    }


    public function show(Guardian $guardian)
    {
        $guardian->load(['user', 'students', 'addresses']);
        return view('admin.guardians.show', compact('guardian'));
    }

    public function edit(Guardian $guardian)
    {
        $guardian->load('user');
        return view('admin.guardians.edit', compact('guardian'));
    }

    public function update(Request $request, Guardian $guardian)
    {
        //
    }

    public function destroy(Guardian $guardian)
    {
        $guardian->delete();
        return redirect()->route('admin.guardians.index')
            ->with('success', 'Guardian deleted successfully.');
    }
}
