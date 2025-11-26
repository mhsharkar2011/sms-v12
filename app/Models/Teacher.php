<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Teacher extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'teacher_id',
        'name',
        'email',
        'phone',
        'subject',
        'status',
        'avatar',
        'address',
        'date_of_birth',
        'date_of_joining',
        'qualification',
        'bio',
        'last_login_at'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'date_of_joining' => 'date',
        'last_login_at' => 'datetime',
        'subjects_taught' => 'array',
    ];

    protected $attributes = [
        'status' => 'active'
    ];

    // Relationship with classes
    public function classes()
    {
        return $this->belongsToMany(SchoolClass::class, 'teacher_class')
                    ->withTimestamps();
    }

    // Relationship with subjects (if using the teacher_subject table)
    public function subjects()
    {
        return $this->hasMany(TeacherSubject::class);
    }

    // Accessor for avatar URL
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }
        return asset('images/default-avatar.png');
    }

    // Accessor for age
    public function getAgeAttribute()
    {
        return $this->date_of_birth?->age;
    }

    // Scope for active teachers
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // Scope for teachers on leave
    public function scopeOnLeave($query)
    {
        return $query->where('status', 'on_leave');
    }
}
