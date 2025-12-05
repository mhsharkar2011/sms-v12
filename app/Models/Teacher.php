<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Teacher extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'teacher_id',
        'department_id',
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
        // 'last_login_at',
        // 'subjects_taught',

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

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
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

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    // Accessor for department name with fallback
    public function getDepartmentNameAttribute()
    {
        return $this->department ? $this->department->name : 'No Department';
    }

    // Accessor for avatar URL
    public function getAvatarUrlAttribute()
    {
        // FIRST: Check if TEACHER has a custom avatar (highest priority)
        if ($this->avatar) {
            // If it's a storage path (uploaded avatar)
            if (Storage::disk('public')->exists($this->avatar)) {
                return asset('storage/' . $this->avatar);
            }
            // If it's the default avatar string
            elseif ($this->avatar === 'default-avatar.png') {
                return asset('images/default-avatar.png');
            }
            // If it's a relative path without storage prefix
            elseif (str_starts_with($this->avatar, 'avatars/')) {
                return asset('storage/' . $this->avatar);
            }
        }

        // SECOND: Check if USER has an avatar (second priority)
        if ($this->user && $this->user->avatar) {
            // If user has uploaded avatar
            if (Storage::disk('public')->exists($this->user->avatar)) {
                return asset('storage/' . $this->user->avatar);
            }
            // If user has default avatar string
            elseif ($this->user->avatar === 'default-avatar.png') {
                return asset('images/default-avatar.png');
            }
            // If it's a relative path
            elseif (str_starts_with($this->user->avatar, 'avatars/')) {
                return asset('storage/' . $this->user->avatar);
            }
        }

        // FINAL: Default fallback
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

    public function teacherSubjects()
    {
        return $this->hasMany(TeacherSubject::class);
    }

    /**
     * Get the primary subject of the teacher
     */
    public function primarySubject()
    {
        return $this->hasOne(TeacherSubject::class)->where('is_primary', true);
    }

    // Check if teacher is active
    public function isActive()
    {
        return $this->status === 'active';
    }

    /**
     * Get active subjects the teacher can teach
     */
    public function activeSubjects()
    {
        return $this->teacherSubjects()->active();
    }

    /**
     * Accessor for all subject names as array
     */
    public function getSubjectNamesAttribute()
    {
        return $this->teacherSubjects->pluck('subject_name')->toArray();
    }

    /**
     * Accessor for primary subject name
     */
    public function getPrimarySubjectNameAttribute()
    {
        return $this->primarySubject?->subject_name ?? $this->subject;
    }

    /**
     * Check if teacher can teach a specific subject
     */
    public function canTeach($subjectName, $minProficiency = 'intermediate'): bool
    {
        return TeacherSubject::isQualified($this->id, $subjectName, $minProficiency);
    }

    /**
     * Get teacher's proficiency level for a subject
     */
    public function getProficiencyForSubject($subjectName)
    {
        $subject = $this->teacherSubjects()
            ->where('subject_name', $subjectName)
            ->active()
            ->first();

        return $subject?->proficiency_level;
    }
}
