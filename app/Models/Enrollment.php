<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Enrollment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'student_id',
        'class_id',
        'enrollment_id',
        'enrollment_date',
        'start_date',
        'end_date',
        'status',
        'final_grade',
        'grade_letter',
        'gpa',
        'total_classes',
        'classes_attended',
        'classes_absent',
        'tuition_fee',
        'amount_paid',
        'balance',
        'withdrawal_date',
        'withdrawal_reason',
        'transferred_to_class_id',
        'notes',
        'custom_fields',
        'enrolled_by',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'enrollment_date' => 'date',
        'start_date' => 'date',
        'end_date' => 'date',
        'withdrawal_date' => 'date',
        'approved_at' => 'datetime',
        'final_grade' => 'decimal:2',
        'gpa' => 'decimal:2',
        'tuition_fee' => 'decimal:2',
        'amount_paid' => 'decimal:2',
        'balance' => 'decimal:2',
        'custom_fields' => 'array',
    ];

    /**
     * Status constants for easy reference
     */
    const STATUS_PENDING = 'pending';
    const STATUS_ENROLLED = 'enrolled';
    const STATUS_COMPLETED = 'completed';
    const STATUS_WITHDRAWN = 'withdrawn';
    const STATUS_TRANSFERRED = 'transferred';

    /**
     * Get the student associated with the enrollment.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the class associated with the enrollment.
     */
    public function class(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    /**
     * Get the class transferred to.
     */
    public function transferredToClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'transferred_to_class_id');
    }

    /**
     * Get the user who enrolled the student.
     */
    public function enrolledBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'enrolled_by');
    }

    /**
     * Get the user who approved the enrollment.
     */
    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Calculate attendance percentage.
     */
    public function getAttendancePercentageAttribute(): float
    {
        if ($this->total_classes === 0) {
            return 0;
        }

        return ($this->classes_attended / $this->total_classes) * 100;
    }

    /**
     * Calculate attendance status.
     */
    public function getAttendanceStatusAttribute(): string
    {
        $percentage = $this->attendance_percentage;

        if ($percentage >= 90) return 'Excellent';
        if ($percentage >= 75) return 'Good';
        if ($percentage >= 60) return 'Fair';
        return 'Poor';
    }

    /**
     * Check if enrollment is active.
     */
    public function isActive(): bool
    {
        return $this->status === self::STATUS_ENROLLED;
    }

    /**
     * Check if enrollment is completed.
     */
    public function isCompleted(): bool
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    /**
     * Check if enrollment is pending.
     */
    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    /**
     * Check if student has outstanding balance.
     */
    public function hasBalance(): bool
    {
        return $this->balance > 0;
    }

    /**
     * Calculate remaining balance.
     */
    public function calculateBalance(): float
    {
        return $this->tuition_fee - $this->amount_paid;
    }

    /**
     * Update balance based on payments.
     */
    public function updateBalance(): void
    {
        $this->balance = $this->calculateBalance();
        $this->save();
    }

    /**
     * Record a payment.
     */
    public function recordPayment(float $amount): void
    {
        $this->amount_paid += $amount;
        $this->updateBalance();
    }

    /**
     * Withdraw enrollment.
     */
    public function withdraw(string $reason = null, $date = null): bool
    {
        $this->status = self::STATUS_WITHDRAWN;
        $this->withdrawal_date = $date ?? now();
        $this->withdrawal_reason = $reason;
        $this->end_date = $this->withdrawal_date;

        return $this->save();
    }

    /**
     * Complete enrollment.
     */
    public function complete($date = null): bool
    {
        $this->status = self::STATUS_COMPLETED;
        $this->end_date = $date ?? now();

        return $this->save();
    }

    /**
     * Transfer enrollment to another class.
     */
    public function transferTo(SchoolClass $newClass, $transferDate = null): Enrollment
    {
        // Create new enrollment for the new class
        $newEnrollment = self::create([
            'student_id' => $this->student_id,
            'class_id' => $newClass->id,
            'enrollment_date' => $transferDate ?? now(),
            'start_date' => $transferDate ?? now(),
            'status' => self::STATUS_ENROLLED,
            'enrolled_by' => $this->enrolled_by,
        ]);

        // Update current enrollment status
        $this->status = self::STATUS_TRANSFERRED;
        $this->transferred_to_class_id = $newClass->id;
        $this->end_date = $transferDate ?? now();
        $this->save();

        return $newEnrollment;
    }

    /**
     * Generate enrollment ID.
     */
    public function generateEnrollmentId(): string
    {
        if (!$this->enrollment_id) {
            $this->enrollment_id = 'ENR-' . strtoupper(uniqid());
            $this->save();
        }

        return $this->enrollment_id;
    }

    /**
     * Scope active enrollments.
     */
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ENROLLED);
    }

    /**
     * Scope pending enrollments.
     */
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    /**
     * Scope by class.
     */
    public function scopeByClass($query, $classId)
    {
        return $query->where('class_id', $classId);
    }

    /**
     * Scope by student.
     */
    public function scopeByStudent($query, $studentId)
    {
        return $query->where('student_id', $studentId);
    }

    /**
     * Scope by academic year.
     */
    public function scopeAcademicYear($query, $academicYear)
    {
        return $query->whereHas('class', function ($q) use ($academicYear) {
            $q->where('academic_year', $academicYear);
        });
    }

    /**
     * Get status color for display.
     */
    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_ENROLLED => 'green',
            self::STATUS_PENDING => 'yellow',
            self::STATUS_COMPLETED => 'blue',
            self::STATUS_WITHDRAWN => 'red',
            self::STATUS_TRANSFERRED => 'purple',
            default => 'gray',
        };
    }

    /**
     * Get status badge HTML.
     */
    public function getStatusBadgeAttribute(): string
    {
        $colors = [
            self::STATUS_ENROLLED => 'bg-green-100 text-green-800',
            self::STATUS_PENDING => 'bg-yellow-100 text-yellow-800',
            self::STATUS_COMPLETED => 'bg-blue-100 text-blue-800',
            self::STATUS_WITHDRAWN => 'bg-red-100 text-red-800',
            self::STATUS_TRANSFERRED => 'bg-purple-100 text-purple-800',
        ];

        $colorClass = $colors[$this->status] ?? 'bg-gray-100 text-gray-800';

        return '<span class="px-2 py-1 text-xs font-medium rounded-full ' . $colorClass . '">'
            . ucfirst($this->status)
            . '</span>';
    }

    /**
     * Boot method for model events.
     */
    protected static function boot()
    {
        parent::boot();

        // Generate enrollment ID on creation
        static::creating(function ($enrollment) {
            if (!$enrollment->enrollment_id) {
                $enrollment->enrollment_id = 'ENR-' . strtoupper(uniqid());
            }

            if (!$enrollment->enrollment_date) {
                $enrollment->enrollment_date = now();
            }

            if (!$enrollment->start_date) {
                $enrollment->start_date = now();
            }

            // Calculate initial balance
            if ($enrollment->tuition_fee) {
                $enrollment->balance = $enrollment->calculateBalance();
            }
        });

        // Update balance when fee or payment changes
        static::saving(function ($enrollment) {
            if ($enrollment->isDirty(['tuition_fee', 'amount_paid'])) {
                $enrollment->balance = $enrollment->calculateBalance();
            }
        });
    }
}
