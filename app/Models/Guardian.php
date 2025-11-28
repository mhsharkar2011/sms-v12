<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Guardian extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'guardians';

    protected $fillable = [
        'user_id',
        'guardian_id',
        'relationship',
        'occupation',
        'employer',
        'work_phone',
        'work_email',
        'emergency_contact_name',
        'emergency_contact_phone',
        'emergency_contact_relationship',
        'medical_notes',
        'notes',
        'is_primary',
        'can_pickup',
        'receive_sms_alerts',
        'receive_email_alerts',
        'is_active',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
        'can_pickup' => 'boolean',
        'receive_sms_alerts' => 'boolean',
        'receive_email_alerts' => 'boolean',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the user associated with the guardian.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the students associated with the guardian.
     */
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'guardian_student')
                    ->withPivot([
                        'relationship_type',
                        'is_primary_contact',
                        'can_pickup',
                        'receive_reports',
                        'receive_notifications',
                        'emergency_contact_priority',
                        'special_instructions'
                    ])
                    ->withTimestamps();
    }

    /**
     * Get the addresses for the guardian.
     */
    public function addresses(): HasMany
    {
        return $this->hasMany(GuardianAddress::class);
    }

    /**
     * Get the primary address for the guardian.
     */
    public function primaryAddress()
    {
        return $this->hasOne(GuardianAddress::class)->where('is_primary', true);
    }

    /**
     * Get the home address for the guardian.
     */
    public function homeAddress()
    {
        return $this->hasOne(GuardianAddress::class)->where('address_type', 'home');
    }

    /**
     * Scope active guardians
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope primary guardians
     */
    public function scopePrimary($query)
    {
        return $query->where('is_primary', true);
    }

    /**
     * Scope guardians who can pickup
     */
    public function scopeCanPickup($query)
    {
        return $query->where('can_pickup', true);
    }

    /**
     * Get full name from user relationship
     */
    public function getFullNameAttribute()
    {
        return $this->user->name ?? '';
    }

    /**
     * Get email from user relationship
     */
    public function getEmailAttribute()
    {
        return $this->user->email ?? '';
    }

    /**
     * Get phone from user relationship
     */
    public function getPhoneAttribute()
    {
        return $this->user->phone ?? '';
    }

    /**
     * Generate next guardian ID
     */
    public static function generateGuardianId()
    {
        $lastGuardian = static::withTrashed()->orderBy('id', 'desc')->first();
        $number = $lastGuardian ? (int) substr($lastGuardian->guardian_id, 1) + 1 : 1;
        return 'G' . str_pad($number, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Check if guardian is emergency contact for any student
     */
    public function isEmergencyContact()
    {
        return $this->students()
            ->wherePivot('emergency_contact_priority', '!=', null)
            ->exists();
    }

    /**
     * Get students where guardian is primary contact
     */
    public function primaryContactStudents()
    {
        return $this->students()->wherePivot('is_primary_contact', true);
    }

    /**
     * Get students count
     */
    public function getStudentsCountAttribute()
    {
        return $this->students()->count();
    }
}
