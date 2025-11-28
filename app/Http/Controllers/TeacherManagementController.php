<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\Subject;
use Illuminate\Http\Request;

class TeacherManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = Teacher::with('classes')->latest();

        // Search filter
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('teacher_id', 'like', '%' . $request->search . '%');
            });
        }

        // Subject filter
        if ($request->has('subject') && $request->subject != '') {
            $query->where('subject', $request->subject);
        }

        // Status filter
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $teachers = $query->paginate(10);

        // Stats for the dashboard
        $stats = [
            'total_teachers' => Teacher::count(),
            'active_today' => Teacher::where('status', 'active')->count(),
            'on_leave' => Teacher::where('status', 'on_leave')->count(),
            'subjects_covered' => Teacher::distinct('subject')->count('subject'),
        ];

        // Get unique subjects for filter dropdown
        $subjects = Teacher::distinct()->whereNotNull('subject')->pluck('subject');

        return view('admin.teachers.index', compact('teachers', 'stats', 'subjects'));
    }

    public function create()
    {
        return view('admin.teachers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:teachers,email',
            'teacher_id' => 'required|unique:teachers,teacher_id',
            'subject' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'status' => 'required|in:active,on_leave,inactive',
            'avatar' => 'nullable|image|max:2048',
        ]);

        try {
            if ($request->hasFile('avatar')) {
                $validated['avatar'] = $request->file('avatar')->store('teachers/avatars', 'public');
            }

            Teacher::create($validated);

            return redirect()->route('admin.teachers.index')
                ->with('success', 'Teacher created successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to create teacher: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(Teacher $teacher)
    {
        return view('admin.teachers.show', compact('teacher'));
    }

    public function edit(Teacher $teacher)
    {
        return view('admin.teachers.edit', compact('teacher'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:teachers,email,' . $teacher->id,
            'teacher_id' => 'required|unique:teachers,teacher_id,' . $teacher->id,
            'subject' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'status' => 'required|in:active,on_leave,inactive',
            'avatar' => 'nullable|image|max:2048',
        ]);

        try {
            if ($request->hasFile('avatar')) {
                // Delete old avatar if exists
                if ($teacher->avatar) {
                    Storage::disk('public')->delete($teacher->avatar);
                }
                $validated['avatar'] = $request->file('avatar')->store('teachers/avatars', 'public');
            }

            $teacher->update($validated);

            return redirect()->route('admin.teachers.index')
                ->with('success', 'Teacher updated successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update teacher: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(Teacher $teacher)
    {
        try {
            // Delete avatar if exists
            if ($teacher->avatar) {
                Storage::disk('public')->delete($teacher->avatar);
            }

            $teacher->delete();

            return redirect()->route('admin.teachers.index')
                ->with('success', 'Teacher deleted successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to delete teacher: ' . $e->getMessage());
        }
    }
}
