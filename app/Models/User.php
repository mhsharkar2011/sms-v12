<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
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

    public function teachers()
    {
        return $this->hasMany(Teacher::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function guardians()
    {
        return $this->hasMany(Guardian::class);
    }
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

    public function guardianProfile()
    {
        return $this->hasOne(Guardian::class);
    }
    public function isGuardian()
    {
        return $this->guardianProfile()->exists();
    }

    public function children()
    {
        return $this->hasManyThrough(
            Student::class,
            Guardian::class,
            'user_id', // Foreign key on guardians table
            'id', // Foreign key on students table
            'id', // Local key on users table
            'id' // Local key on guardians table
        )->via('guardianProfile');
    }

    public function guardianWithStudents()
    {
        return $this->guardianProfile()->with('students');
    }

    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }
        return asset('storage/default-avatar.png');
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isInactive(): bool
    {
        return $this->status === 'inactive';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }
    public function isSuspended(): bool
    {
        return $this->status === 'suspended';
    }
    public function isSuperAdmin(): bool
    {
        return $this->hasPermissionTo('super-admin');
    }
    public function isAdmin(): bool
    {
        return $this->hasPermissionTo('admin');
    }
    public function isTeacher(): bool
    {
        return $this->hasPermissionTo('teacher');
    }
    public function isStudent(): bool
    {
        return $this->hasPermissionTo('student');
    }
    public function isGuardianRole(): bool
    {
        return $this->hasPermissionTo('guardian');
    }
    public function fullAddress(): string
    {
        return $this->address ?? 'Address not provided';
    }
    public function phoneNumber(): string
    {
        return $this->phone ?? 'Phone number not provided';
    }
    public function recentLogins($limit = 5)
    {
        return $this->logins()->latest()->take($limit)->get();
    }
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    /**
     * Get the user's latest post.
     */
    public function latestPost():HasOne
    {
        return $this->hasOne(Post::class)->latest();
    }
    public function getPostsCountAttribute(): int
    {
        return $this->posts()->count();
    }
    public function activePosts()
    {
        return $this->posts()->where('status', 'active');
    }

    /**
     * Get the comments for the user.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

     /**
     * Get the user's approved comments.
     */
    public function approvedComments(): HasMany
    {
        return $this->comments()->where('is_approved', true);
    }

    // Optional: Accessor for comments count
    public function getCommentsCountAttribute(): int
    {
        return $this->comments()->count();
    }
}
