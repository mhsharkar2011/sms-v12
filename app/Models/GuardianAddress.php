<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuardianAddress extends Model
{
    use HasFactory;

    protected $table = 'guardian_addresses';

    protected $fillable = [
        'guardian_id',
        'address_type',
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'postal_code',
        'country',
        'is_primary',
        'notes',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    /**
     * Get the guardian that owns the address.
     */
    public function guardian()
    {
        return $this->belongsTo(Guardian::class);
    }

    /**
     * Get full address as string
     */
    public function getFullAddressAttribute()
    {
        $address = $this->address_line_1;

        if ($this->address_line_2) {
            $address .= ', ' . $this->address_line_2;
        }

        $address .= ', ' . $this->city . ', ' . $this->state . ' ' . $this->postal_code;

        if ($this->country !== 'US') {
            $address .= ', ' . $this->country;
        }

        return $address;
    }
}
