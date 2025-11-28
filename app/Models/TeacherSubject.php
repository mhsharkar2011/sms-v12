<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeacherSubject extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'subject_name',
        'proficiency_level',
        'years_of_experience',
        'is_primary',
        'qualifications',
        'specializations',
        'hourly_rate',
        'max_classes_per_week',
        'is_active',
        'teaching_days',
        'notes'
    ];

    protected $casts = [
        'is_primary' => 'boolean',
        'is_active' => 'boolean',
        'hourly_rate' => 'decimal:2',
        'teaching_days' => 'array',
        'years_of_experience' => 'integer',
        'max_classes_per_week' => 'integer'
    ];

    protected $attributes = [
        'proficiency_level' => 'intermediate',
        'years_of_experience' => 0,
        'is_primary' => false,
        'is_active' => true,
        'max_classes_per_week' => 20
    ];

    /**
     * Get the teacher that owns the subject assignment
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * Accessor for formatted proficiency level
     */
    public function getFormattedProficiencyAttribute(): string
    {
        return ucfirst($this->proficiency_level);
    }

    /**
     * Accessor for proficiency level color
     */
    public function getProficiencyColorAttribute(): string
    {
        return match($this->proficiency_level) {
            'beginner' => 'blue',
            'intermediate' => 'green',
            'advanced' => 'orange',
            'expert' => 'red',
            default => 'gray'
        };
    }

    /**
     * Accessor for proficiency level badge class
     */
    public function getProficiencyBadgeClassAttribute(): string
    {
        return match($this->proficiency_level) {
            'beginner' => 'bg-blue-100 text-blue-800',
            'intermediate' => 'bg-green-100 text-green-800',
            'advanced' => 'bg-orange-100 text-orange-800',
            'expert' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    /**
     * Accessor for experience level
     */
    public function getExperienceLevelAttribute(): string
    {
        if ($this->years_of_experience <= 2) {
            return 'Novice';
        } elseif ($this->years_of_experience <= 5) {
            return 'Experienced';
        } elseif ($this->years_of_experience <= 10) {
            return 'Senior';
        } else {
            return 'Veteran';
        }
    }

    /**
     * Accessor for formatted hourly rate
     */
    public function getFormattedHourlyRateAttribute(): ?string
    {
        return $this->hourly_rate ? '₹' . number_format($this->hourly_rate, 2) : null;
    }

    /**
     * Accessor for teaching days as string
     */
    public function getTeachingDaysStringAttribute(): string
    {
        if (empty($this->teaching_days)) {
            return 'Not specified';
        }

        $days = [
            'monday' => 'Mon',
            'tuesday' => 'Tue',
            'wednesday' => 'Wed',
            'thursday' => 'Thu',
            'friday' => 'Fri',
            'saturday' => 'Sat',
            'sunday' => 'Sun'
        ];

        $selectedDays = array_map(function($day) use ($days) {
            return $days[$day] ?? $day;
        }, $this->teaching_days);

        return implode(', ', $selectedDays);
    }

    /**
     * Check if teacher can teach on a specific day
     */
    public function canTeachOn($day): bool
    {
        if (empty($this->teaching_days)) {
            return true; // If no preference, assume available all days
        }

        return in_array(strtolower($day), $this->teaching_days);
    }

    /**
     * Calculate total teaching load cost per week
     */
    public function getWeeklyCostAttribute(): ?float
    {
        if (!$this->hourly_rate) {
            return null;
        }

        // Assuming average class duration of 1 hour
        return $this->hourly_rate * $this->max_classes_per_week;
    }

    /**
     * Get formatted weekly cost
     */
    public function getFormattedWeeklyCostAttribute(): ?string
    {
        return $this->weekly_cost ? '₹' . number_format($this->weekly_cost, 2) : null;
    }

    /**
     * Scope primary subjects
     */
    public function scopePrimary($query)
    {
        return $query->where('is_primary', true);
    }

    /**
     * Scope active subjects
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope by proficiency level
     */
    public function scopeByProficiency($query, $level)
    {
        return $query->where('proficiency_level', $level);
    }

    /**
     * Scope by subject name
     */
    public function scopeBySubject($query, $subjectName)
    {
        return $query->where('subject_name', 'like', "%{$subjectName}%");
    }

    /**
     * Scope teachers who can teach a specific subject
     */
    public function scopeCanTeach($query, $subjectName)
    {
        return $query->where('subject_name', $subjectName)->active();
    }

    /**
     * Scope teachers with high proficiency (advanced or expert)
     */
    public function scopeHighProficiency($query)
    {
        return $query->whereIn('proficiency_level', ['advanced', 'expert']);
    }

    /**
     * Scope teachers with specific years of experience
     */
    public function scopeWithExperience($query, $minYears = 0, $maxYears = null)
    {
        $query->where('years_of_experience', '>=', $minYears);

        if ($maxYears !== null) {
            $query->where('years_of_experience', '<=', $maxYears);
        }

        return $query;
    }

    /**
     * Get available teachers for a subject
     */
    public static function getAvailableTeachers($subjectName, $day = null)
    {
        $query = self::with('teacher')
            ->where('subject_name', $subjectName)
            ->active();

        if ($day) {
            $query->where(function($q) use ($day) {
                $q->whereNull('teaching_days')
                  ->orWhereJsonContains('teaching_days', strtolower($day));
            });
        }

        return $query->get();
    }

    /**
     * Get teacher's primary subject
     */
    public static function getPrimarySubject($teacherId)
    {
        return self::where('teacher_id', $teacherId)
            ->primary()
            ->active()
            ->first();
    }

    /**
     * Get all subjects a teacher can teach
     */
    public static function getTeacherSubjects($teacherId)
    {
        return self::where('teacher_id', $teacherId)
            ->active()
            ->orderBy('is_primary', 'desc')
            ->orderBy('years_of_experience', 'desc')
            ->get();
    }

    /**
     * Check if teacher is qualified to teach a subject
     */
    public static function isQualified($teacherId, $subjectName, $minProficiency = 'intermediate'): bool
    {
        $proficiencyLevels = ['beginner' => 1, 'intermediate' => 2, 'advanced' => 3, 'expert' => 4];
        $minLevel = $proficiencyLevels[$minProficiency] ?? 2;

        $subject = self::where('teacher_id', $teacherId)
            ->where('subject_name', $subjectName)
            ->active()
            ->first();

        if (!$subject) {
            return false;
        }

        $teacherLevel = $proficiencyLevels[$subject->proficiency_level] ?? 1;
        return $teacherLevel >= $minLevel;
    }

    /**
     * Boot method for model events
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($teacherSubject) {
            // Ensure only one primary subject per teacher
            if ($teacherSubject->is_primary) {
                self::where('teacher_id', $teacherSubject->teacher_id)
                    ->where('id', '!=', $teacherSubject->id)
                    ->update(['is_primary' => false]);
            }

            // Validate teaching days
            if ($teacherSubject->teaching_days) {
                $validDays = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
                $invalidDays = array_diff($teacherSubject->teaching_days, $validDays);

                if (!empty($invalidDays)) {
                    throw new \Exception('Invalid teaching days: ' . implode(', ', $invalidDays));
                }
            }
        });

        static::created(function ($teacherSubject) {
            // If this is the first subject for the teacher, make it primary
            $subjectCount = self::where('teacher_id', $teacherSubject->teacher_id)->count();
            if ($subjectCount === 1) {
                $teacherSubject->update(['is_primary' => true]);
            }
        });
    }
}
