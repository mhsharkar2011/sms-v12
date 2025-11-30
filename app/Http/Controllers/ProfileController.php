<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;

class ProfileController
{
    /**
     * Display the user's profile.
     */
    public function show(User $user): View
    {
        $user->loadCount(['posts', 'comments']);
        $user->load(['posts' => function($query) {
            $query->latest()->take(5);
        }]);

        return view('profile.show', compact('user'));
    }

    /**
     * Show the form for editing the user's profile.
     */
    public function edit(Request $request, User $user): View
    {
        // Manual authorization using Gate
        if (Gate::denies('update', $user)) {
            abort(403);
        }

        return view('profile.edit', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        // Manual authorization using Gate
        if (Gate::denies('update', $user)) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'bio' => ['nullable', 'string', 'max:500'],
            'location' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
        ]);

        $user->update($validated);

        return redirect()->route('profile.show', $user)
            ->with('status', 'Profile updated successfully.');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request, User $user): RedirectResponse
    {
        // Manual authorization using Gate
        if (Gate::denies('delete', $user)) {
            abort(403);
        }

        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        auth()->logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('status', 'Your account has been deleted successfully.');
    }
}
