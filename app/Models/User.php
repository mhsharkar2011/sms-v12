<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use  HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'date_of_birth',
        'address',
        'profile_photo'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'date_of_birth' => 'date',
    ];

    /**
     * The roles that belong to the user.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    /**
     * Check if user has a specific role
     */
    public function hasRole($roleSlug): bool
    {
        return $this->roles()->where('slug', $roleSlug)->exists();
    }

    /**
     * Check if user has any of the given roles
     */
    public function hasAnyRole(array $roleSlugs): bool
    {
        return $this->roles()->whereIn('slug', $roleSlugs)->exists();
    }

    /**
     * Check if user has a specific permission
     */
    public function hasPermission($permissionSlug): bool
    {
        return $this->roles()->whereHas('permissions', function ($query) use ($permissionSlug) {
            $query->where('slug', $permissionSlug);
        })->exists();
    }

    /**
     * Check if user has any of the given permissions
     */
    public function hasAnyPermission(array $permissionSlugs): bool
    {
        return $this->roles()->whereHas('permissions', function ($query) use ($permissionSlugs) {
            $query->whereIn('slug', $permissionSlugs);
        })->exists();
    }

    /**
     * Assign roles to user
     */
    public function assignRoles(array $roleSlugs): void
    {
        $roles = Role::whereIn('slug', $roleSlugs)->get();
        $this->roles()->syncWithoutDetaching($roles->pluck('id'));
    }

    /**
     * Remove roles from user
     */
    public function removeRoles(array $roleSlugs): void
    {
        $roles = Role::whereIn('slug', $roleSlugs)->get();
        $this->roles()->detach($roles->pluck('id'));
    }

    /**
     * Sync user roles (replace all existing roles)
     */
    public function syncRoles(array $roleSlugs): void
    {
        $roles = Role::whereIn('slug', $roleSlugs)->get();
        $this->roles()->sync($roles->pluck('id'));
    }

    // Convenience methods for common role checks
    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    public function isTeacher(): bool
    {
        return $this->hasRole('teacher');
    }

    public function isStudent(): bool
    {
        return $this->hasRole('student');
    }

    public function isParent(): bool
    {
        return $this->hasRole('parent');
    }

    /**
     * Get primary role (useful for dashboard redirection)
     */
    public function getPrimaryRoleAttribute(): ?Role
    {
        return $this->roles->first();
    }
}
