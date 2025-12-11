<?php
// app/Models/ExamResult.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

class ExamResult extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'student_id',
        'exam_id',
        'subject_id',
        'class_id',  // Changed from class_section_id
        'section_id',       // Added
        'marks_obtained',
        'total_marks',
        'grade',
        'grade_point',
        'status',
        'result_status',
        'rank',
        'remarks',
        'is_absent',
        'is_exempted',
        'exemption_reason',
        'grace_marks',
        'graded_by',
        'graded_at',
        'published_by',
        'published_at',
        'meta'
    ];

    protected $casts = [
        'marks_obtained' => 'decimal:2',
        'total_marks' => 'decimal:2',
        'grade_point' => 'decimal:2',
        'grace_marks' => 'decimal:2',
        'is_absent' => 'boolean',
        'is_exempted' => 'boolean',
        'graded_at' => 'datetime',
        'published_at' => 'datetime',
        'meta' => 'array'
    ];

    protected $appends = [
        'percentage',
        'is_passed',
        'formatted_marks',
        'formatted_total_marks'
    ];

    /**
     * Relationship with Student
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    /**
     * Relationship with Exam
     */
    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class, 'exam_id');
    }

    /**
     * Relationship with Subject
     */
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    /**
     * Relationship with SchoolClass
     */
    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    /**
     * Relationship with Section
     */
    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    /**
     * Relationship with User who graded
     */
    public function grader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'graded_by');
    }

    /**
     * Relationship with User who published
     */
    public function publisher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'published_by');
    }

    // ... [rest of the model methods remain the same]

    /**
     * Scope for specific class and section
     */
    public function scopeForClassAndSection($query, $classId, $sectionId)
    {
        return $query->where('class_id', $classId)
                     ->where('section_id', $sectionId);
    }
}
