<?php

namespace App\Models;

use App\Traits\HasAvatarUrl;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class Student extends Model
{
    use HasFactory, SoftDeletes, HasAvatarUrl;

    protected $fillable = [
        'user_id', // Add this
        'first_name',
        'last_name',
        'student_id',
        'class_id',
        'admission_number',
        'email',
        'phone',
        'date_of_birth',
        'gender',
        'blood_group',
        'nationality',
        'religion',
        'caste',
        'address',
        'city',
        'state',
        'postal_code',
        'country',
        'emergency_contact_name',
        'emergency_contact_phone',
        'emergency_contact_relation',
        'admission_date',
        'grade_level',
        'roll_number',
        'section',
        'academic_year',
        'avatar',
        'medical_info',
        'medical_notes',
        'allergies',
        'medications',
        'transport_route',
        'hostel_info',
        'special_instructions',
        'status',
        'last_attendance_date',
        'last_login_at',
        'is_boarder',
        'uses_transport',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'admission_date' => 'date',
        'last_attendance_date' => 'date',
        'last_login_at' => 'datetime',
        'medical_info' => 'array',
        'allergies' => 'array',
        'medications' => 'array',
        'hostel_info' => 'array',
        'is_boarder' => 'boolean',
        'uses_transport' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get full name of the student.
     */
    public function getFullNameAttribute(): string
    {
        return $this->user->name ?? '';
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // public function getAvatarUrlAttribute()
    // {
    //     // FIRST: Check if TEACHER has a custom avatar (highest priority)
    //     if ($this->avatar) {
    //         // If it's a storage path (uploaded avatar)
    //         if (Storage::disk('public')->exists($this->avatar)) {
    //             return asset('storage/' . $this->avatar);
    //         }
    //         // If it's the default avatar string
    //         elseif ($this->avatar === 'default-avatar.png') {
    //             return asset('images/default-avatar.png');
    //         }
    //         // If it's a relative path without storage prefix
    //         elseif (str_starts_with($this->avatar, 'avatars/')) {
    //             return asset('storage/' . $this->avatar);
    //         }
    //     }

    //     // SECOND: Check if USER has an avatar (second priority)
    //     if ($this->user && $this->user->avatar) {
    //         // If user has uploaded avatar
    //         if (Storage::disk('public')->exists($this->user->avatar)) {
    //             return asset('storage/' . $this->user->avatar);
    //         }
    //         // If user has default avatar string
    //         elseif ($this->user->avatar === 'default-avatar.png') {
    //             return asset('images/default-avatar.png');
    //         }
    //         // If it's a relative path
    //         elseif (str_starts_with($this->user->avatar, 'avatars/')) {
    //             return asset('storage/' . $this->user->avatar);
    //         }
    //     }

    //     // FINAL: Default fallback
    //     return asset('images/default-avatar.png');
    // }


    /**
     * Get the school class that the student belongs to.
     */
    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    /**
     * Get the addresses for the student.
     */
    public function addresses(): HasMany
    {
        return $this->hasMany(StudentAddress::class);
    }

    /**
     * Get the primary address for the student.
     */
    public function primaryAddress(): HasOne
    {
        return $this->hasOne(StudentAddress::class)->where('is_primary', true);
    }
    /**
     * Get age of the student.
     */
    public function getAgeAttribute(): int
    {
        return $this->date_of_birth->age;
    }

    /**
     * Generate next student ID.
     */
    public static function generateStudentId(): string
    {
        $lastStudent = static::withTrashed()->orderBy('id', 'desc')->first();
        $number = $lastStudent ? (int) substr($lastStudent->student_id, 1) + 1 : 1;
        return 'S' . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Generate next admission number.
     */
    public static function generateAdmissionNumber(): string
    {
        $year = date('Y');
        $lastStudent = static::withTrashed()->where('admission_number', 'like', 'ADM' . $year . '%')->orderBy('id', 'desc')->first();

        if ($lastStudent) {
            $number = (int) substr($lastStudent->admission_number, -4) + 1;
        } else {
            $number = 1;
        }

        return 'ADM' . $year . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Scope active students.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
