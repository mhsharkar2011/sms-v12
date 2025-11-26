<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        // Get filter parameters
        $roleFilter = $request->get('role');
        $status = $request->get('status');
        $search = $request->get('search');

        // Build query with filters
        $users = User::query()
            ->when($roleFilter, function ($query, $roleFilter) {
                return $query->whereHas('roles', function ($q) use ($roleFilter) {
                    $q->where('name', $roleFilter);
                });
            })
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

        // Calculate statistics using Spatie roles
        $stats = [
            'totalUsers' => User::count(),
            'activeUsers' => User::where('status', 'active')->count(),
            'adminUsers' => User::role('admin')->count(),
            'teacherUsers' => User::role('teacher')->count(),
            'studentUsers' => User::role('student')->count(),
            'parentUsers' => User::role('parent')->count(),
            'pendingUsers' => User::where('status', 'pending')->count(),
            'inactiveUsers' => User::where('status', 'inactive')->count(),
        ];

        // Get available roles for filter
        $roles = Role::all();

        return view('admin.users', compact('users', 'stats', 'roles'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|exists:roles,name',
            'status' => 'required|in:active,inactive,pending'
        ]);

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'status' => $validated['status'],
            ]);

            // Assign role using Spatie
            $user->assignRole($validated['role']);
        });

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
            'role' => 'required|exists:roles,name',
            'status' => 'required|in:active,inactive,pending',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // 5MB max, added webp
            'phone' => 'nullable|string|max:20|regex:/^[\+]?[0-9\s\-\(\)]+$/',
            'address' => 'nullable|string|max:500'
        ], [
            'avatar.image' => 'The avatar must be a valid image file.',
            'avatar.mimes' => 'The avatar must be a JPEG, PNG, JPG, GIF, or WEBP file.',
            'avatar.max' => 'The avatar may not be greater than 5MB.',
            'phone.regex' => 'Please enter a valid phone number.',
        ]);

        try {
            DB::transaction(function () use ($validated, $user, $request) {
                $updateData = [
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'status' => $validated['status'],
                    'phone' => $validated['phone'] ?? null,
                    'address' => $validated['address'] ?? null,
                ];

                // Handle password update
                if ($request->filled('password')) {
                    $updateData['password'] = Hash::make($validated['password']);
                }

                // Handle avatar upload
                if ($request->hasFile('avatar')) {
                    // Delete old avatar if exists
                    if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                        Storage::disk('public')->delete($user->avatar);
                    }

                    // Store new avatar with unique filename
                    $avatarFile = $request->file('avatar');
                    $filename = 'avatar_' . $user->id . '_' . time() . '.' . $avatarFile->getClientOriginalExtension();
                    $avatarPath = $avatarFile->storeAs('avatars', $filename, 'public');
                    $updateData['avatar'] = $avatarPath;
                }

                // Update user data
                $user->update($updateData);

                // Sync roles using Spatie
                $user->syncRoles([$validated['role']]);
            });

            return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
        } catch (\Exception $e) {
            // Log the error
            \Log::error('User update failed: ' . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update user. Please try again.');
        }
    }

    public function destroy(User $user)
    {
        // Prevent deletion of last admin
        if ($user->hasRole('admin') && User::role('admin')->count() <= 1) {
            return redirect()->back()->with('error', 'Cannot delete the last admin user.');
        }

        // Prevent users from deleting themselves
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}
