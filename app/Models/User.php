<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'avatar',
        'phone',
        'address',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'last_login_at' => 'datetime',
        'email_verified_at' => 'datetime',
        'date_of_birth' => 'date',
    ];

    /**
     * Safely get the primary role name
     */
    public function getPrimaryRoleNameAttribute(): string
    {
        $primaryRole = $this->roles->first();
        return $primaryRole ? $primaryRole->name : 'No Role';
    }

    /**
     * Check if user has any role assigned
     */
    public function hasAnyRoleAssigned(): bool
    {
        return $this->roles->count() > 0;
    }
}
