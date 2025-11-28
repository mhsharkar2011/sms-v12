<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'credit_hours',
        'is_active'
    ];

    protected $attributes = [
        'is_active' => true,
        'credit_hours' => 1
    ];

    /**
     * Get timetable entries for this subject
     */
    public function timetableEntries(): HasMany
    {
        return $this->hasMany(Timetable::class);
    }

    /**
     * Get attendance records for this subject
     */
    public function attendanceRecords(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    /**
     * Scope active subjects
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
