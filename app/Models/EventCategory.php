<?php
// app/Models/EventCategory.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class EventCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description', 'color', 'is_active'];

    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'event_event_category');
    }
}
