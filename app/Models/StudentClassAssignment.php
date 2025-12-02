<?php
// app/Models/StudentClassAssignment.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentClassAssignment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'student_id',
        'class_id',
        'roll_number',
        'status',
        'enrollment_date',
        'completion_date',
        'notes',
    ];

    protected $casts = [
        'enrollment_date' => 'date',
        'completion_date' => 'date',
    ];

    /**
     * Get the student.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
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
        return $query->where('status', 'active');
    }

    /**
     * Check if assignment is active.
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }
}
