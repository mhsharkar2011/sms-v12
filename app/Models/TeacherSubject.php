<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherSubject extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'subject_name',
        'proficiency_level',
        'years_of_experience',
        'is_primary'
    ];

    protected $attributes = [
        'proficiency_level' => 'intermediate',
        'years_of_experience' => 0,
        'is_primary' => false
    ];

    // Relationship with teacher
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    // Accessor for formatted proficiency level
    public function getFormattedProficiencyAttribute(): string
    {
        return ucfirst($this->proficiency_level);
    }
}
