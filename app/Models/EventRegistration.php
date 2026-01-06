<?php
// app/Models/EventRegistration.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'user_id',
        'name',
        'email',
        'phone',
        'additional_info',
        'status',
        'payment_status',
        'payment_amount',
        'payment_method',
        'transaction_id',
        'attended',
    ];

    protected $casts = [
        'additional_info' => 'array',
        'attended' => 'boolean',
        'payment_amount' => 'decimal:2',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
