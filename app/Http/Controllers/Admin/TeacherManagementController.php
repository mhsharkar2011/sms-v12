<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Teacher;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
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
        $departments = Department::where('is_active', true)->get();
        return view('admin.teachers.create', compact('roles', 'departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'teacher_id' => 'required|string|unique:users,teacher_id',
            'department_id' => 'required|exists:departments,id', // Add this
            'subject' => 'required|string|max:255',
            'qualification' => 'nullable|string|max:255',
            'date_of_joining' => 'nullable|date',
            'status' => 'required|in:active,on_leave,inactive',
            'gender' => 'nullable|in:male,female,other',
            'salary' => 'nullable|numeric|min:0',
            'address' => 'nullable|string',
            'bio' => 'nullable|string',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            // Handle avatar upload
            if ($request->hasFile('avatar')) {
                $avatar = $request->file('avatar');
                $avatarName = 'teacher_' . time() . '_' . Str::random(10) . '.' . $avatar->getClientOriginalExtension();

                // Store avatar in storage/app/public/avatars
                $avatarPath = $avatar->storeAs('avatars/teachers', $avatarName, 'public');
                $validated['avatar'] = $avatarPath;
            }

            // Create the teacher
            $teacher = Teacher::create($validated);

            return redirect()->route('admin.teachers.index')
                ->with('success', 'Teacher added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error creating teacher: ' . $e->getMessage())
                ->withInput();
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $teacher = User::role('teacher')->findOrFail($id);
        return view('admin.teachers.show', compact('teacher'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $teacher = User::role('teacher')->findOrFail($id);
        $roles = Role::all();
        return view('admin.teachers.edit', compact('teacher', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Add validation and update logic here
        return redirect()->route('admin.teachers.index');
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
