<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Container\Attributes\Storage;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\Types\Nullable;

class TeacherManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teachers = Teacher::with('department')->paginate(10);

        $totalTeachers = Teacher::count();
        $activeTeachers = Teacher::where('status', 'active')->count();
        $pendingTeachers = Teacher::where('status', 'pending')->count();
        $inactiveTeachers = Teacher::where('status', 'inactive')->count();

        $stats = [
            'total_teachers' => $totalTeachers,
            'activeTeachers' => $activeTeachers,
            'pendingTeachers' => $pendingTeachers,
            'inactiveTeachers' => $inactiveTeachers,
            'activePercentage' => $totalTeachers > 0 ? round(($activeTeachers / $totalTeachers) * 100, 1) : 0,
            'pendingPercentage' => $totalTeachers > 0 ? round(($pendingTeachers / $totalTeachers) * 100, 1) : 0,
            'inactivePercentage' => $totalTeachers > 0 ? round(($inactiveTeachers / $totalTeachers) * 100, 1) : 0,
        ];

        $departments = [];

        return view('admin.teachers.index', compact('teachers', 'stats', 'departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        $departments = Department::all();
        return view('admin.teachers.create', compact('roles', 'departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            // User fields
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,on_leave,inactive',

            // Teacher fields
            'teacher_id' => 'required|string|unique:teachers,teacher_id',
            'department_id' => 'required|exists:departments,id',
            'date_of_birth' => 'nullable|date',
            'subject' => 'required|string|max:255',
            'qualification' => 'nullable|string|max:255',
            'date_of_joining' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'salary' => 'nullable|numeric|min:0',
            'address' => 'nullable|string',
            'bio' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            // Handle avatar upload
            $avatarPath = null;
            if ($request->hasFile('avatar')) {
                $avatarName = 'teacher_' . time() . '.' . $request->file('avatar')->getClientOriginalExtension();
                $avatarPath = $request->file('avatar')->storeAs('avatars/teachers', $avatarName, 'public');
            }

            // Create User account
            $user = User::create([
                'name' => $validated['first_name'] . ' ' . $validated['last_name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'phone' => $validated['phone'] ?? null,
                'avatar' => $avatarPath,
                'status' => $validated['status'], // or use a default like 'active'
                'address' => $validated['address'] ?? null,
            ]);

            // Assign teacher role
            $user->assignRole('teacher');

            // Prepare teacher data (exclude user-specific fields)
            $teacherData = [
                'user_id' => $user->id,
                'teacher_id' => $validated['teacher_id'],
                'department_id' => $validated['department_id'],
                'subject' => $validated['subject'],
                'qualification' => $validated['qualification'] ?? null,
                'date_of_birth' => $validated['date_of_birth'] ?? null,
                'date_of_joining' => $validated['date_of_joining'] ?? null,
                'gender' => $validated['gender'] ?? null,
                'salary' => $validated['salary'] ?? null,
                'bio' => $validated['bio'] ?? null,
                'status' => $validated['status'],
            ];

            // Create the teacher
            $teacher = Teacher::create($teacherData);

            DB::commit();

            // Log success
            Log::info('Teacher created successfully', [
                'teacher_id' => $teacher->teacher_id,
                'user_id' => $user->id,
                'email' => $user->email
            ]);

            return redirect()->route('admin.teachers.index')
                ->with('success', 'Teacher added successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error creating teacher: ' . $e->getMessage(), [
                'request' => $request->except(['password', 'password_confirmation']),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'Error creating teacher: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Teacher $teacher)
    {
        $departments = Department::all();
        $subjects = Subject::all();
        return view('admin.teachers.show', compact('teacher', 'departments', 'subjects'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $departments = Department::all();
        $subjects = Subject::all();
        $teacher = Teacher::with('user')->findOrFail($id);
        return view('admin.teachers.edit', compact('teacher', 'departments', 'subjects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $teacher = Teacher::findOrFail($id); // Teacher extends User

        $validated = $request->validate([
            // User fields
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $teacher->id,
            'phone' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,on_leave,inactive',
            'password' => 'nullable|string|min:8|confirmed',

            // Teacher-specific fields
            'department_id' => 'required|exists:departments,id',
            'teacher_id' => 'required|string|max:50|unique:teachers,teacher_id,' . $teacher->id,
            'date_of_birth' => 'nullable|date',
            'subject' => 'required|string|max:255',
            'qualification' => 'nullable|string|max:255',
            'date_of_joining' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'salary' => 'nullable|numeric|min:0',
            'address' => 'nullable|string',
            'bio' => 'nullable|string',
            'remove_avatar' => 'nullable|boolean',
        ]);

        try {
            // Handle avatar removal
            if ($request->has('remove_avatar') && $teacher->avatar) {
                Storage::disk('public')->delete($teacher->avatar);
                $teacher->avatar = null;
            }

            // Handle avatar upload
            if ($request->hasFile('avatar')) {
                if ($teacher->avatar) {
                    Storage::disk('public')->delete($teacher->avatar);
                }

                $avatarName = 'teacher_' . time() . '.' . $request->file('avatar')->getClientOriginalExtension();
                $avatarPath = $request->file('avatar')->storeAs('avatars/teachers', $avatarName, 'public');
                $teacher->avatar = $avatarPath;
            }

            // Prepare update data
            $updateData = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
                'department_id' => $validated['department_id'],
                'teacher_id' => $validated['teacher_id'],
                'date_of_birth' => $validated['date_of_birth'] ?? null,
                'subject' => $validated['subject'],
                'qualification' => $validated['qualification'] ?? null,
                'date_of_joining' => $validated['date_of_joining'] ?? null,
                'gender' => $validated['gender'] ?? null,
                'salary' => $validated['salary'] ?? null,
                'address' => $validated['address'] ?? null,
                'bio' => $validated['bio'] ?? null,
                'status' => $validated['status'],
                'type' => 'teacher',
            ];

            // Update password if provided
            if ($request->filled('password')) {
                $updateData['password'] = bcrypt($validated['password']);
            }

            $teacher->update($updateData);

            return redirect()->route('admin.teachers.index')
                ->with('success', 'Teacher updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update teacher: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $teacher = User::role('teacher')->findOrFail($id);
        $teacher->delete();

        return redirect()->route('admin.teachers.index')
            ->with('success', 'Teacher deleted successfully');
    }
}
