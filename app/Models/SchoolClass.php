<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SchoolClass extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'slug',
        'grade_level',
        'section',
        'subject',
        'room_number',
        'academic_year',
        'capacity',
        'description',
        'start_time',
        'end_time',
        'meeting_days',
        'status',
        'teacher_id'
    ];

    protected $attributes = [
        'status' => 'active',
        'capacity' => 40,
        'current_strength' => 0,
    ];

    protected $casts = [
        'capacity' => 'integer',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
    ];

    /**
     * Get the teacher assigned to this class.
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    /**
     * Get all teachers assigned to this class (for multiple subjects)
     */
    public function teachers(): BelongsToMany
    {
        return $this->belongsToMany(Teacher::class, 'teacher_class')
            ->withPivot('subject')
            ->withTimestamps();
    }

    /**
     * Get the students enrolled in this class.
     */
    public function students(): HasMany
    {
        return $this->hasMany(Student::class, 'class_id')
            ->where('role', 'student')
            ->orderBy('name');
    }

    /**
     * Get the enrollments for this class.
     */
    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class, 'class_id');
    }

    /**
     * Get the number of enrolled students.
     */
    public function getEnrolledCountAttribute(): int
    {
        return $this->students()->count();
    }

    /**
     * Check if class has available seats.
     */
    public function hasAvailableSeats(): bool
    {
        return $this->enrolled_count < $this->capacity;
    }

    /**
     * Get available seats count.
     */
    public function getAvailableSeatsAttribute(): int
    {
        return max(0, $this->capacity - $this->enrolled_count);
    }

    /**
     * Scope active classes.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope by academic year.
     */
    public function scopeAcademicYear($query, $year)
    {
        return $query->where('academic_year', $year);
    }

    /**
     * Scope by grade level.
     */
    public function scopeGradeLevel($query, $gradeLevel)
    {
        return $query->where('grade_level', $gradeLevel);
    }

    /**
     * Get meeting days as array.
     */
    public function getMeetingDaysArrayAttribute(): array
    {
        if (!$this->meeting_days) {
            return [];
        }

        return explode(',', $this->meeting_days);
    }


    /**
     * Get subjects taught in this class
     */
    public function subjects()
    {
        // This can return unique subjects from teacher_class pivot or a separate subjects table
        return $this->teachers()->distinct()->pluck('subject');
    }

    /**
     * Get attendance records for this class
     */
    public function attendanceRecords(): HasMany
    {
        return $this->hasMany(Attendance::class, 'class_id');
    }

    /**
     * Get timetable entries for this class
     */
    public function timetableEntries(): HasMany
    {
        return $this->hasMany(Timetable::class, 'class_id');
    }

    /**
     * Accessor for full class name
     */
    public function getFullNameAttribute(): string
    {
        return "Grade {$this->grade_level} - Section {$this->section} ({$this->name})";
    }

    /**
     * Accessor for display name
     */
    public function getDisplayNameAttribute(): string
    {
        return "{$this->grade_level}-{$this->section}";
    }


    /**
     * Accessor for is_full status
     */
    public function getIsFullAttribute(): bool
    {
        return $this->current_strength >= $this->capacity;
    }


    /**
     * Scope by grade level
     */
    public function scopeByGradeLevel($query, $gradeLevel)
    {
        return $query->where('grade_level', $gradeLevel);
    }

    /**
     * Scope by academic year
     */
    // public function scopeByAcademicYear($query, $academicYear)
    // {
    //     return $query->where('academic_year', $academicYear);
    // }

    /**
     * Scope classes with available seats
     */
    public function scopeWithAvailableSeats($query)
    {
        return $query->whereRaw('current_strength < capacity');
    }

    /**
     * Get primary teacher (class teacher) name
     */
    public function getClassTeacherNameAttribute(): ?string
    {
        return $this->classTeacher?->name ?? 'Not Assigned';
    }

    /**
     * Update current strength based on student count
     */
    public function updateCurrentStrength(): void
    {
        $this->update([
            'current_strength' => $this->students()->count()
        ]);
    }

    /**
     * Check if a teacher is assigned to this class
     */
    public function hasTeacher($teacherId): bool
    {
        return $this->teachers()->where('teacher_id', $teacherId)->exists();
    }

    /**
     * Get class statistics
     */
    public function getStatsAttribute(): array
    {
        $totalStudents = $this->current_strength;
        $maleStudents = $this->students()->where('gender', 'male')->count();
        $femaleStudents = $this->students()->where('gender', 'female')->count();

        return [
            'total_students' => $totalStudents,
            'male_students' => $maleStudents,
            'female_students' => $femaleStudents,
            'available_seats' => $this->available_seats,
            'occupancy_rate' => $totalStudents > 0 ? round(($totalStudents / $this->capacity) * 100, 2) : 0,
        ];
    }

    /**
     * Boot method for model events
     */
    protected static function boot()
    {
        parent::boot();

        // Generate class name if not provided
        static::creating(function ($schoolClass) {
            if (empty($schoolClass->name)) {
                $schoolClass->name = "Grade {$schoolClass->grade_level} - Section {$schoolClass->section}";
            }
        });

        // Update current strength when students are added/removed
        static::updated(function ($schoolClass) {
            // This could be handled by Student model events instead
        });
    }
}
