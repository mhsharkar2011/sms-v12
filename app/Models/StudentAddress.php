<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentAddress extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'student_addresses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'student_id',
        'address_type',
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'pincode',
        'country',
        'is_primary',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_primary' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the student that owns the address.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the full address as a formatted string.
     */
    public function getFullAddressAttribute(): string
    {
        $address = $this->address_line_1;

        if (!empty($this->address_line_2)) {
            $address .= ', ' . $this->address_line_2;
        }

        $address .= ', ' . $this->city . ', ' . $this->state . ' - ' . $this->pincode;

        if ($this->country !== 'India') {
            $address .= ', ' . $this->country;
        }

        return $address;
    }

    /**
     * Get the address type label.
     */
    public function getAddressTypeLabelAttribute(): string
    {
        return match($this->address_type) {
            'home' => 'Home Address',
            'permanent' => 'Permanent Address',
            'correspondence' => 'Correspondence Address',
            'guardian' => 'Guardian Address',
            'hostel' => 'Hostel Address',
            default => ucfirst($this->address_type) . ' Address'
        };
    }

    /**
     * Scope a query to only include primary addresses.
     */
    public function scopePrimary($query)
    {
        return $query->where('is_primary', true);
    }

    /**
     * Scope a query to only include addresses of a specific type.
     */
    public function scopeOfType($query, string $type)
    {
        return $query->where('address_type', $type);
    }

    /**
     * Scope a query to only include home addresses.
     */
    public function scopeHome($query)
    {
        return $query->where('address_type', 'home');
    }

    /**
     * Scope a query to only include permanent addresses.
     */
    public function scopePermanent($query)
    {
        return $query->where('address_type', 'permanent');
    }

    /**
     * Check if this is a home address.
     */
    public function isHomeAddress(): bool
    {
        return $this->address_type === 'home';
    }

    /**
     * Check if this is a permanent address.
     */
    public function isPermanentAddress(): bool
    {
        return $this->address_type === 'permanent';
    }

    /**
     * Set this address as primary and unset others.
     */
    public function setAsPrimary(): void
    {
        // Unset other primary addresses for this student
        StudentAddress::where('student_id', $this->student_id)
            ->where('id', '!=', $this->id)
            ->update(['is_primary' => false]);

        // Set this as primary
        $this->update(['is_primary' => true]);
    }

    /**
     * Get the short address (city, state only).
     */
    public function getShortAddressAttribute(): string
    {
        return $this->city . ', ' . $this->state;
    }

    /**
     * Get address for display in forms.
     */
    public function getFormattedAddressAttribute(): string
    {
        $parts = [
            $this->address_line_1,
            $this->address_line_2,
            $this->city,
            $this->state,
            $this->pincode,
            $this->country !== 'India' ? $this->country : null
        ];

        return implode(', ', array_filter($parts));
    }
}
