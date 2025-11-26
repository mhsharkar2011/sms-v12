<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Timetable extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_id',
        'subject_id',
        'teacher_id',
        'day_of_week',
        'start_time',
        'end_time',
        'room_number',
        'period_number',
        'academic_year',
        'is_active',
        'notes'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'is_active' => 'boolean',
    ];

    protected $attributes = [
        'academic_year' => '2024-2025',
        'is_active' => true
    ];

    /**
     * Get the class associated with the timetable entry
     */
    public function class(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    /**
     * Get the subject associated with the timetable entry
     */
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Get the teacher associated with the timetable entry
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * Accessor for formatted time slot
     */
    public function getTimeSlotAttribute(): string
    {
        $start = \Carbon\Carbon::parse($this->start_time)->format('g:i A');
        $end = \Carbon\Carbon::parse($this->end_time)->format('g:i A');
        return "{$start} - {$end}";
    }

    /**
     * Accessor for duration in minutes
     */
    public function getDurationAttribute(): int
    {
        $start = \Carbon\Carbon::parse($this->start_time);
        $end = \Carbon\Carbon::parse($this->end_time);
        return $start->diffInMinutes($end);
    }

    /**
     * Accessor for formatted day name
     */
    public function getFormattedDayAttribute(): string
    {
        return ucfirst($this->day_of_week);
    }

    /**
     * Accessor for current period status
     */
    public function getCurrentStatusAttribute(): string
    {
        $now = now();
        $currentTime = $now->format('H:i:s');
        $currentDay = strtolower($now->format('l'));

        if ($currentDay !== $this->day_of_week) {
            return 'not_today';
        }

        if ($currentTime < $this->start_time) {
            return 'upcoming';
        } elseif ($currentTime >= $this->start_time && $currentTime <= $this->end_time) {
            return 'ongoing';
        } else {
            return 'completed';
        }
    }

    /**
     * Accessor for status color
     */
    public function getStatusColorAttribute(): string
    {
        return match ($this->current_status) {
            'ongoing' => 'success',
            'upcoming' => 'info',
            'completed' => 'secondary',
            'not_today' => 'light',
            default => 'secondary'
        };
    }

    /**
     * Check if this is the current period
     */
    public function getIsCurrentPeriodAttribute(): bool
    {
        return $this->current_status === 'ongoing';
    }

    /**
     * Scope active timetable entries
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope by class
     */
    public function scopeByClass($query, $classId)
    {
        return $query->where('class_id', $classId);
    }

    /**
     * Scope by teacher
     */
    public function scopeByTeacher($query, $teacherId)
    {
        return $query->where('teacher_id', $teacherId);
    }

    /**
     * Scope by day of week
     */
    public function scopeByDay($query, $day)
    {
        return $query->where('day_of_week', strtolower($day));
    }

    /**
     * Scope by academic year
     */
    public function scopeByAcademicYear($query, $academicYear)
    {
        return $query->where('academic_year', $academicYear);
    }

    /**
     * Scope for today's timetable
     */
    public function scopeToday($query)
    {
        $today = strtolower(now()->format('l'));
        return $query->where('day_of_week', $today);
    }

    /**
     * Get timetable for a specific class and day
     */
    public static function getClassTimetable($classId, $day = null)
    {
        $query = self::with(['subject', 'teacher'])
            ->where('class_id', $classId)
            ->active()
            ->orderBy('start_time');

        if ($day) {
            $query->where('day_of_week', strtolower($day));
        }

        return $query->get();
    }

    /**
     * Get teacher's timetable
     */
    public static function getTeacherTimetable($teacherId, $day = null)
    {
        $query = self::with(['class', 'subject'])
            ->where('teacher_id', $teacherId)
            ->active()
            ->orderBy('start_time');

        if ($day) {
            $query->where('day_of_week', strtolower($day));
        }

        return $query->get();
    }

    /**
     * Check for schedule conflicts
     */
    public static function hasConflict($classId, $teacherId, $roomNumber, $day, $startTime, $endTime, $excludeId = null)
    {
        $query = self::where('day_of_week', $day)
            ->where('is_active', true)
            ->where(function ($q) use ($startTime, $endTime) {
                $q->whereBetween('start_time', [$startTime, $endTime])
                    ->orWhereBetween('end_time', [$startTime, $endTime])
                    ->orWhere(function ($q) use ($startTime, $endTime) {
                        $q->where('start_time', '<=', $startTime)
                            ->where('end_time', '>=', $endTime);
                    });
            });

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->where(function ($q) use ($classId, $teacherId, $roomNumber) {
            $q->where('class_id', $classId)
                ->orWhere('teacher_id', $teacherId)
                ->orWhere('room_number', $roomNumber);
        })->exists();
    }

    /**
     * Boot method for model events
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($timetable) {
            // Validate time order
            if ($timetable->start_time >= $timetable->end_time) {
                throw new \Exception('End time must be after start time.');
            }

            // Check for conflicts
            if (self::hasConflict(
                $timetable->class_id,
                $timetable->teacher_id,
                $timetable->room_number,
                $timetable->day_of_week,
                $timetable->start_time,
                $timetable->end_time,
                $timetable->id
            )) {
                throw new \Exception('Schedule conflict detected. Please choose a different time, room, or teacher.');
            }
        });
    }
}
