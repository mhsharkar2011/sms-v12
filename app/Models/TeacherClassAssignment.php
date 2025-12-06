<?php
// app/Models/TeacherClassAssignment.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeacherClassAssignment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'teacher_id',
        'class_id',
        'role',
        'subjects',
        'start_date',
        'end_date',
        'is_active',
        'responsibilities',
    ];

    protected $casts = [
        'subjects' => 'array',
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];

    /**
     * Get the teacher.
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /**
     * Get the class.
     */
    public function class(): BelongsTo
    {
        return $this->belongsTo(StudentClass::class, 'class_id');
    }

    /**
     * Scope active assignments.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope class teachers.
     */
    public function scopeClassTeachers($query)
    {
        return $query->where('role', 'class_teacher');
    }

    /**
     * Get subjects as array.
     */
    public function getSubjectsArrayAttribute(): array
    {
        return $this->subjects ?? [];
    }
}
