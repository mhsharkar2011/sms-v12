<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'attendance_date',
        'student_id',
        'class_id',
        'subject_id',
        'status',
        'remark',
        'check_in',
        'check_out',
        'working_hours',
        'recorded_by',
        'academic_year'
    ];

    protected $casts = [
        'attendance_date' => 'date',
        'check_in' => 'datetime',
        'check_out' => 'datetime',
        'working_hours' => 'decimal:2',
    ];

    protected $attributes = [
        'status' => 'present',
        'academic_year' => '2024-2025'
    ];

    /**
     * Get the student associated with the attendance
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the class associated with the attendance
     */
    public function class(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    /**
     * Get the subject associated with the attendance
     */
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Get the teacher who recorded the attendance
     */
    public function recordedBy(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'recorded_by');
    }

    /**
     * Accessor for formatted attendance date
     */
    public function getFormattedDateAttribute(): string
    {
        return $this->attendance_date->format('D, M j, Y');
    }

    /**
     * Accessor for day name
     */
    public function getDayNameAttribute(): string
    {
        return $this->attendance_date->format('l');
    }

    /**
     * Accessor for status with color
     */
    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'present' => 'success',
            'absent' => 'danger',
            'late' => 'warning',
            'half_day' => 'info',
            'holiday' => 'secondary',
            default => 'secondary'
        };
    }

    /**
     * Accessor for status icon
     */
    public function getStatusIconAttribute(): string
    {
        return match ($this->status) {
            'present' => 'fa-check-circle',
            'absent' => 'fa-times-circle',
            'late' => 'fa-clock',
            'half_day' => 'fa-user-clock',
            'holiday' => 'fa-umbrella-beach',
            default => 'fa-question-circle'
        };
    }

    /**
     * Check if attendance is for today
     */
    public function getIsTodayAttribute(): bool
    {
        return $this->attendance_date->isToday();
    }

    /**
     * Calculate working hours automatically
     */
    public function calculateWorkingHours(): void
    {
        if ($this->check_in && $this->check_out) {
            $start = \Carbon\Carbon::parse($this->check_in);
            $end = \Carbon\Carbon::parse($this->check_out);
            $this->working_hours = $start->diffInHours($end);
        }
    }

    /**
     * Scope for today's attendance
     */
    public function scopeToday($query)
    {
        return $query->whereDate('attendance_date', today());
    }

    /**
     * Scope for this week's attendance
     */
    public function scopeThisWeek($query)
    {
        return $query->whereBetween('attendance_date', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ]);
    }

    /**
     * Scope for this month's attendance
     */
    public function scopeThisMonth($query)
    {
        return $query->whereBetween('attendance_date', [
            now()->startOfMonth(),
            now()->endOfMonth()
        ]);
    }

    /**
     * Scope by student
     */
    public function scopeByStudent($query, $studentId)
    {
        return $query->where('student_id', $studentId);
    }

    /**
     * Scope by class
     */
    public function scopeByClass($query, $classId)
    {
        return $query->where('class_id', $classId);
    }

    /**
     * Scope by date range
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('attendance_date', [$startDate, $endDate]);
    }

    /**
     * Get attendance statistics for a student
     */
    public static function getStudentStats($studentId, $startDate = null, $endDate = null)
    {
        $query = self::where('student_id', $studentId);

        if ($startDate && $endDate) {
            $query->dateRange($startDate, $endDate);
        }

        $total = $query->count();
        $present = $query->where('status', 'present')->count();
        $absent = $query->where('status', 'absent')->count();
        $late = $query->where('status', 'late')->count();

        return [
            'total_days' => $total,
            'present' => $present,
            'absent' => $absent,
            'late' => $late,
            'attendance_percentage' => $total > 0 ? round(($present / $total) * 100, 2) : 0,
        ];
    }

    /**
     * Boot method for model events
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($attendance) {
            // Auto-calculate working hours
            $attendance->calculateWorkingHours();
        });
    }
}
