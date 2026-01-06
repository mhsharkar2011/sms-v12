<?php
// app/Models/EventAttendee.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventAttendee extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'event_id',
        'user_id',
        'attendee_type', // student, teacher, parent, staff, guest
        'name',
        'email',
        'phone',
        'roll_number', // For students
        'class_id', // For students
        'section', // For students
        'grade_level', // For students
        'designation', // For teachers/staff
        'department', // For teachers/staff
        'relationship', // For parents (mother, father, guardian)
        'student_id', // For parents (which student they're related to)
        'status', // registered, confirmed, attended, cancelled, no_show
        'check_in_time',
        'check_out_time',
        'attendance_notes',
        'registration_date',
        'additional_info',
        'registered_by', // Who registered this attendee (user_id)
        'is_volunteer',
        'volunteer_role',
        'dietary_preferences',
        'special_requirements',
        'emergency_contact_name',
        'emergency_contact_phone',
    ];

    protected $casts = [
        'check_in_time' => 'datetime',
        'check_out_time' => 'datetime',
        'registration_date' => 'datetime',
        'additional_info' => 'array',
        'is_volunteer' => 'boolean',
        'dietary_preferences' => 'array',
        'special_requirements' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($attendee) {
            if (empty($attendee->registration_date)) {
                $attendee->registration_date = now();
            }

            if (empty($attendee->status)) {
                $attendee->status = 'registered';
            }
        });
    }

    // Relationships
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function registeredBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'registered_by');
    }

    // Scopes
    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeAttended($query)
    {
        return $query->where('status', 'attended');
    }

    public function scopeStudents($query)
    {
        return $query->where('attendee_type', 'student');
    }

    public function scopeTeachers($query)
    {
        return $query->where('attendee_type', 'teacher');
    }

    public function scopeParents($query)
    {
        return $query->where('attendee_type', 'parent');
    }

    public function scopeStaff($query)
    {
        return $query->where('attendee_type', 'staff');
    }

    public function scopeGuests($query)
    {
        return $query->where('attendee_type', 'guest');
    }

    public function scopeCheckedIn($query)
    {
        return $query->whereNotNull('check_in_time');
    }

    public function scopeCheckedOut($query)
    {
        return $query->whereNotNull('check_out_time');
    }

    public function scopeCurrentlyPresent($query)
    {
        return $query->whereNotNull('check_in_time')
            ->whereNull('check_out_time');
    }

    public function scopeVolunteers($query)
    {
        return $query->where('is_volunteer', true);
    }

    public function scopeByClass($query, $classId)
    {
        return $query->where('class_id', $classId);
    }

    public function scopeByGradeLevel($query, $gradeLevel)
    {
        return $query->where('grade_level', $gradeLevel);
    }

    public function scopeBySection($query, $section)
    {
        return $query->where('section', $section);
    }

    // Helper Methods
    public function isCheckedIn(): bool
    {
        return !is_null($this->check_in_time);
    }

    public function isCheckedOut(): bool
    {
        return !is_null($this->check_out_time);
    }

    public function isCurrentlyPresent(): bool
    {
        return $this->isCheckedIn() && !$this->isCheckedOut();
    }

    public function checkIn(): bool
    {
        if ($this->isCheckedIn() && !$this->isCheckedOut()) {
            return false; // Already checked in
        }

        $this->update([
            'check_in_time' => now(),
            'status' => 'attended',
            'check_out_time' => null,
        ]);

        return true;
    }

    public function checkOut(): bool
    {
        if (!$this->isCheckedIn() || $this->isCheckedOut()) {
            return false; // Not checked in or already checked out
        }

        $this->update([
            'check_out_time' => now(),
        ]);

        return true;
    }

    public function getAttendanceDuration(): ?int
    {
        if (!$this->check_in_time || !$this->check_out_time) {
            return null;
        }

        return $this->check_in_time->diffInMinutes($this->check_out_time);
    }

    public function getFormattedAttendanceDuration(): ?string
    {
        $minutes = $this->getAttendanceDuration();

        if (is_null($minutes)) {
            return null;
        }

        if ($minutes < 60) {
            return "{$minutes} minutes";
        }

        $hours = floor($minutes / 60);
        $remainingMinutes = $minutes % 60;

        if ($remainingMinutes > 0) {
            return "{$hours}h {$remainingMinutes}m";
        }

        return "{$hours} hours";
    }

    public function confirmAttendance(): void
    {
        $this->update(['status' => 'confirmed']);
    }

    public function markAsNoShow(): void
    {
        $this->update(['status' => 'no_show']);
    }

    public function cancelRegistration(): void
    {
        $this->update(['status' => 'cancelled']);
    }

    public function getAttendeeTypeLabel(): string
    {
        return match ($this->attendee_type) {
            'student' => 'Student',
            'teacher' => 'Teacher',
            'parent' => 'Parent',
            'staff' => 'Staff',
            'guest' => 'Guest',
            default => ucfirst($this->attendee_type),
        };
    }

    public function getStatusBadgeColor(): string
    {
        return match ($this->status) {
            'registered' => 'blue',
            'confirmed' => 'green',
            'attended' => 'emerald',
            'cancelled' => 'red',
            'no_show' => 'orange',
            default => 'gray',
        };
    }

    public function getDisplayName(): string
    {
        if ($this->name) {
            return $this->name;
        }

        if ($this->user) {
            return $this->user->name;
        }

        return 'Unknown Attendee';
    }

    public function getStudentInfo(): ?string
    {
        if ($this->attendee_type !== 'student') {
            return null;
        }

        $info = [];

        if ($this->roll_number) {
            $info[] = "Roll: {$this->roll_number}";
        }

        if ($this->grade_level) {
            $info[] = "Grade: {$this->grade_level}";
        }

        if ($this->section) {
            $info[] = "Section: {$this->section}";
        }

        return !empty($info) ? implode(' | ', $info) : null;
    }

    public function getVolunteerInfo(): ?string
    {
        if (!$this->is_volunteer) {
            return null;
        }

        return $this->volunteer_role ? "Volunteer: {$this->volunteer_role}" : 'Volunteer';
    }
}
