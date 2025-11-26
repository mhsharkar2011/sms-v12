<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'admission_number',
        'name',
        'email',
        'phone',
        'date_of_birth',
        'gender',
        'address',
        'father_name',
        'father_phone',
        'mother_name',
        'mother_phone',
        'admission_date',
        'class_id',
        'roll_number',
        'avatar',
        'status'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'admission_date' => 'date',
    ];

    protected $attributes = [
        'status' => 'active',
        'gender' => 'male'
    ];

    // Relationship with class
    public function class(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    // Accessor for age
    public function getAgeAttribute(): ?int
    {
        return $this->date_of_birth?->age;
    }

    // Accessor for avatar URL
    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }
        return asset('images/default-student-avatar.png');
    }

    // Accessor for class name
    public function getClassNameAttribute(): ?string
    {
        return $this->class?->display_name;
    }

    // Scope active students
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
