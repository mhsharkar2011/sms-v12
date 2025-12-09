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
        'student_id',
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
        return $this->hasMany(Student::class, 'student_id');
    }

    /**
     * Generate next student ID.
     */
    public static function generateSectionCode(): string
    {
        // Get all existing section codes
        $existingCodes = static::pluck('code')->toArray();

        // Generate letters A-Z
        $letters = range('A', 'Z');

        // Find the first available letter
        foreach ($letters as $letter) {
            $code = 'SEC-' . $letter;
            if (!in_array($code, $existingCodes)) {
                return $code;
            }
        }

        // If all A-Z are used, start with numbers
        $lastNumber = 0;
        foreach ($existingCodes as $existingCode) {
            if (preg_match('/SEC-(\d+)$/', $existingCode, $matches)) {
                $lastNumber = max($lastNumber, (int)$matches[1]);
            }
        }

        return 'SEC-' . ($lastNumber + 1);
    }

    /**
     * Generate next admission number.
     */
    public static function generateRoomNumber($roomType = 'classroom'): string
    {
        // Room type prefixes
        $prefixes = [
            'classroom' => 'CR',
            'laboratory' => 'LAB',
            'library' => 'LIB',
            'auditorium' => 'AUD',
            'office' => 'OFF',
            'sports' => 'GYM',
            'computer' => 'COM',
        ];

        $prefix = $prefixes[$roomType] ?? 'RM';

        // Get last room number for this type
        $lastRoom = static::where('room_number', 'like', $prefix . '-%')
            ->withTrashed()
            ->orderBy('id', 'desc')
            ->first();

        if (!$lastRoom || !$lastRoom->room_number) {
            // Start with 101 for this type
            return $prefix . '-101';
        }

        // Extract number (e.g., "CR-101" -> 101)
        $lastRoomNumber = $lastRoom->room_number;
        if (preg_match('/' . $prefix . '-(\d+)/', $lastRoomNumber, $matches)) {
            $lastNumber = (int)$matches[1];
            $nextNumber = $lastNumber + 1;

            // Keep 3 digits for standard rooms
            return $prefix . '-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        }

        return $prefix . '-101';
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
