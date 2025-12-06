<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Notifications\UserStatusChanged;
use App\Notifications\UserDeleted;
use Illuminate\Support\Facades\Log;

class UserManagementController extends Controller
{
    /**
     * Display a listing of the users.
     */
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

        // Calculate statistics
        $stats = [
            'totalUsers' => User::count(),
            'activeUsers' => User::where('status', 'active')->count(),
            'adminUsers' => User::role('admin')->count(),
            'teacherUsers' => User::role('teacher')->count(),
            'studentUsers' => User::role('student')->count(),
            'parentUsers' => User::role('guardian')->count(),
            'pendingUsers' => User::where('status', 'pending')->count(),
            'inactiveUsers' => User::where('status', 'inactive')->count(),
        ];

        // Get available roles for filter
        $roles = Role::all();

        return view('admin.users.index', compact('users', 'stats', 'roles'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|exists:roles,name',
            'status' => 'required|in:active,inactive,pending',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500'
        ]);

        try {
            DB::beginTransaction();

            // Handle avatar upload
            if ($request->hasFile('avatar')) {
                // $avatarName = 'User_'.time() . '_' . $request->file('avatar')->getClientOriginalName();
                $avatarName = 'user_' . time() . '_' . uniqid() . '.' . $request->file('avatar')->getClientOriginalExtension();
                $userAvatarPath = $request->file('avatar')->storeAs('avatars/users', $avatarName, 'public');
            }
            // Create user with hashed password
            $userData = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'status' => $validated['status'],
                'phone' => $validated['phone'] ?? null,
                'address' => $validated['address'] ?? null,
                'avatar' => $userAvatarPath ?? null,
            ];



            $user = User::create($userData);

            // Assign role
            $user->assignRole($validated['role']);

            DB::commit();

            return redirect()->route('admin.users.index')
                ->with('success', 'User created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            // Delete uploaded avatar if user creation failed
            if (isset($userData['avatar']) && Storage::disk('public')->exists($userData['avatar'])) {
                Storage::disk('public')->delete($userData['avatar']);
            }

            Log::error('User creation failed: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Failed to create user. Please try again.')
                ->withInput();
        }
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
            'role' => 'required|exists:roles,name',
            'status' => 'required|in:active,inactive,on_leave,pending',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500'
        ]);

        $oldStatus = $user->status;

        DB::transaction(function () use ($validated, $user, $request, $oldStatus) {

             if ($request->filled('password')) {
                $updatePassword = Hash::make($validated['password']);
            }

            if ($request->hasFile('avatar')) {
                if ($user->avatar) {
                    Storage::disk('public')->delete($user->avatar);
                }
                $avatarName = 'user_' . time() . '_' . uniqid() . '.' . $request->file('avatar')->getClientOriginalExtension();
                $userAvatarPath = $request->file('avatar')->storeAs('avatars/users', $avatarName, 'public');
            }

            $updateData = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $updatePassword ?? $user->password,
                'status' => $validated['status'],
                'phone' => $validated['phone'] ?? null,
                'address' => $validated['address'] ?? null,
                'avatar' => $userAvatarPath ?? $user->avatar,
            ];

            $user->update($updateData);
            $user->syncRoles([$validated['role']]);

            // Notify if status changed
            if ($oldStatus !== $validated['status']) {
                // Notify admins about status change
                $admins = User::role('admin')->where('id', '!=', auth()->id())->get();
                foreach ($admins as $admin) {
                    $admin->notify(new UserStatusChanged($user, $oldStatus, $validated['status']));
                }

                // Notify user about status change
                $user->notify(new UserStatusChanged($user, $oldStatus, $validated['status']));
            }
        });

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        // Prevent deletion of current user
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'You cannot delete your own account.');
        }

        // Prevent deletion of the last admin
        if ($user->hasRole('admin') && User::role('admin')->count() <= 1) {
            return redirect()->back()->with('error', 'Cannot delete the last admin user.');
        }

        // Notify admins about user deletion
        $admins = User::role('admin')->where('id', '!=', auth()->id())->get();
        foreach ($admins as $admin) {
            $admin->notify(new UserDeleted($user));
        }

        // Delete avatar if exists
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }

    /**
     * Update user status via AJAX.
     */
    public function updateStatus(Request $request, User $user)
    {
        $request->validate([
            'status' => 'required|in:active,inactive,pending'
        ]);

        $oldStatus = $user->status;
        $user->update(['status' => $request->status]);

        // Notify about status change
        if ($oldStatus !== $request->status) {
            $admins = User::role('admin')->where('id', '!=', auth()->id())->get();
            foreach ($admins as $admin) {
                $admin->notify(new UserStatusChanged($user, $oldStatus, $request->status));
            }
            $user->notify(new UserStatusChanged($user, $oldStatus, $request->status));
        }

        return response()->json(['message' => 'User status updated successfully.']);
    }

    /**
     * Remove user avatar.
     */
    public function removeAvatar(User $user)
    {
        try {
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);

                $user->update(['avatar' => null]);

                return redirect()->back()->with('success', 'Avatar removed successfully.');
            }

            return redirect()->back()->with('error', 'No avatar found to remove.');
        } catch (\Exception $e) {
            \Log::error('Avatar removal failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to remove avatar.');
        }
    }
}
