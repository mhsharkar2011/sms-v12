<?php
// app/Models/Exam.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Exam extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'type',
        'academic_year',
        'term',
        'school_class_id',  // Changed
        'section_id',       // Added
        'subject_id',
        'exam_date',
        'start_time',
        'end_time',
        'total_marks',
        'passing_percentage',
        'description',
        'status',
        'is_published',
        'published_at'
    ];

    protected $casts = [
        'exam_date' => 'date',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'is_published' => 'boolean',
        'published_at' => 'datetime'
    ];

    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'school_class_id');
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function results(): HasMany
    {
        return $this->hasMany(ExamResult::class);
    }
}
