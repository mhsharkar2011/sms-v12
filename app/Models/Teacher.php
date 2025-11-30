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
        'department_id',
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
        'last_login_at',
        'subjects_taught',

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
