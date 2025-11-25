<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;

class RegisteredUserController extends Controller
{
    public function create()
    {
        try {
            $roles = Role::where('name', '!=', 'admin')->get(['name', 'id']);
            return view('auth.register', compact('roles'));
        } catch (\Exception $e) {
            // If roles don't exist yet, show a message
            $roles = collect();
            return view('auth.register', compact('roles'))->with('error', 'System setup in progress. Please try again later.');
        }
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'exists:roles,name'],
        ]);

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Assign role using Spatie
            $role = Role::where('name', $request->role)->first();

            if (!$role) {
                throw new \Exception('Selected role not found.');
            }

            $user->assignRole($role);

            event(new Registered($user));

            Auth::login($user);

            return redirect(route('dashboard'));
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Registration error: ' . $e->getMessage());

            return back()->withErrors([
                'email' => 'Registration failed. Please try again or contact support.',
            ])->withInput();
        }
    }
}
