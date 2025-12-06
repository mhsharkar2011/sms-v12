<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Determine if the user can update the model.
     */
    public function update(User $currentUser, User $user): bool
    {
        return $currentUser->id === $user->id;
    }

    /**
     * Determine if the user can delete the model.
     */
    public function delete(User $currentUser, User $user): bool
    {
        return $currentUser->id === $user->id;
    }

    /**
     * Determine if the user can view the model.
     */
    public function view(User $currentUser, User $user): bool
    {
        return true; // Anyone can view profiles
    }
}
