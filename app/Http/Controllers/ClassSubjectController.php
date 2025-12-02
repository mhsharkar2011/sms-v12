<?php
// app/Models/ClassSubject.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassSubject extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'class_id',
        'subject_name',
        'subject_code',
        'description',
        'credit_hours',
        'weekly_classes',
        'schedule',
        'textbook',
        'syllabus_file',
        'type',
        'is_active',
    ];

    protected $casts = [
        'schedule' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Get the class.
     */
    public function class(): BelongsTo
    {
        return $this->belongsTo(StudentClass::class, 'class_id');
    }

    /**
     * Get teacher assignments for this subject.
     */
    public function teacherAssignments(): HasMany
    {
        return $this->hasMany(TeacherSubjectAssignment::class, 'subject_id');
    }

    /**
     * Scope active subjects.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
