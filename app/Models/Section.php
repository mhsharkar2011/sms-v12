<?php
// app/Models/Section.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'class_id',
        'teacher_id',
        'name',
        'code',
        'capacity',
        'room_number',
        'description',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'capacity' => 'integer'
    ];

    // Relationships
    public function class()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByClass($query, $classId)
    {
        return $query->where('class_id', $classId);
    }

    public function scopeAvailable($query)
    {
        return $query->whereRaw('capacity > (SELECT COUNT(*) FROM students WHERE students.section_id = sections.id)');
    }

    // Accessor for remaining seats
    public function getRemainingSeatsAttribute()
    {
        $currentStudents = $this->students()->count();
        return max(0, $this->capacity - $currentStudents);
    }

    public function getIsFullAttribute()
    {
        return $this->remaining_seats <= 0;
    }

    // Mutator for code (uppercase)
    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = strtoupper($value);
    }
}
