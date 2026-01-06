<?php
// app/Models/Event.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'excerpt',
        'featured_image',
        'event_date',
        'end_date',
        'location',
        'address',
        'event_type',
        'status',
        'max_attendees',
        'current_attendees',
        'registration_deadline',
        'is_featured',
        'is_public',
        'requires_registration',
        'registration_fee',
        'meta_title',
        'meta_description',
        'user_id',
        'contact_person',
        'contact_email',
        'contact_phone',
        'organizer',
        'target_audience',
        'tags',
    ];

    protected $casts = [
        'event_date' => 'datetime',
        'end_date' => 'datetime',
        'registration_deadline' => 'datetime',
        'is_featured' => 'boolean',
        'is_public' => 'boolean',
        'requires_registration' => 'boolean',
        'registration_fee' => 'decimal:2',
        'max_attendees' => 'integer',
        'current_attendees' => 'integer',
        'tags' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($event) {
            if (empty($event->slug)) {
                $event->slug = Str::slug($event->title);
            }

            if (empty($event->excerpt)) {
                $event->excerpt = Str::limit(strip_tags($event->description), 150);
            }

            if ($event->status === 'published' && empty($event->published_at)) {
                $event->published_at = now();
            }

            // Set default values
            if (empty($event->current_attendees)) {
                $event->current_attendees = 0;
            }

            if (empty($event->event_type)) {
                $event->event_type = 'general';
            }

            if (empty($event->status)) {
                $event->status = 'draft';
            }
        });

        static::updating(function ($event) {
            // Ensure slug uniqueness
            $originalSlug = $event->slug;
            $count = 1;

            while (static::where('slug', $event->slug)
                ->where('id', '!=', $event->id)
                ->exists()
            ) {
                $event->slug = $originalSlug . '-' . $count++;
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function attendees(): HasMany
    {
        return $this->hasMany(EventAttendee::class);
    }

    // Add these relationships:
    public function studentAttendees(): HasMany
    {
        return $this->hasMany(EventAttendee::class)->where('attendee_type', 'student');
    }

    public function teacherAttendees(): HasMany
    {
        return $this->hasMany(EventAttendee::class)->where('attendee_type', 'teacher');
    }

    public function parentAttendees(): HasMany
    {
        return $this->hasMany(EventAttendee::class)->where('attendee_type', 'parent');
    }

    public function confirmedAttendees(): HasMany
    {
        return $this->hasMany(EventAttendee::class)->where('status', 'confirmed');
    }

    public function attendedAttendees(): HasMany
    {
        return $this->hasMany(EventAttendee::class)->where('status', 'attended');
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(EventRegistration::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(EventCategory::class, 'event_event_category');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(EventComment::class)->whereNull('parent_id');
    }

    public function allComments(): HasMany
    {
        return $this->hasMany(EventComment::class);
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('event_date', '>=', now());
    }

    public function scopePast($query)
    {
        return $query->where('event_date', '<', now());
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('event_type', $type);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeWithAvailableSeats($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('max_attendees')
                ->orWhereColumn('current_attendees', '<', 'max_attendees');
        });
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%")
                ->orWhere('location', 'like', "%{$search}%")
                ->orWhere('organizer', 'like', "%{$search}%");
        });
    }

    // Helpers
    public function isUpcoming(): bool
    {
        return $this->event_date >= now();
    }

    public function isPast(): bool
    {
        return $this->event_date < now();
    }

    public function isFull(): bool
    {
        return $this->max_attendees && $this->current_attendees >= $this->max_attendees;
    }

    public function isRegistrationOpen(): bool
    {
        if (!$this->requires_registration) {
            return false;
        }

        if ($this->registration_deadline) {
            return now() <= $this->registration_deadline;
        }

        return $this->isUpcoming() && !$this->isFull();
    }

    public function getAvailableSeats(): ?int
    {
        if (!$this->max_attendees) {
            return null;
        }

        return max(0, $this->max_attendees - $this->current_attendees);
    }

    public function getEventDuration(): string
    {
        if (!$this->end_date) {
            return $this->event_date->format('h:i A');
        }

        if ($this->event_date->isSameDay($this->end_date)) {
            return $this->event_date->format('h:i A') . ' - ' . $this->end_date->format('h:i A');
        }

        return $this->event_date->format('M d, h:i A') . ' - ' . $this->end_date->format('M d, h:i A');
    }

    public function getFeaturedImageUrl(): ?string
    {
        if (!$this->featured_image) {
            return null;
        }

        if (Str::startsWith($this->featured_image, ['http://', 'https://'])) {
            return $this->featured_image;
        }

        return asset('storage/' . $this->featured_image);
    }

    public function getFormattedDate(): string
    {
        return $this->event_date->format('F d, Y');
    }

    public function getFormattedTime(): string
    {
        return $this->event_date->format('h:i A');
    }

    public function incrementAttendees(int $count = 1): void
    {
        $this->increment('current_attendees', $count);
    }

    public function decrementAttendees(int $count = 1): void
    {
        $this->decrement('current_attendees', $count);
    }

    public function hasTag(string $tag): bool
    {
        $tags = $this->tags ?? [];
        return in_array($tag, $tags);
    }

    public function addTag(string $tag): void
    {
        $tags = $this->tags ?? [];
        if (!in_array($tag, $tags)) {
            $tags[] = $tag;
            $this->tags = $tags;
            $this->save();
        }
    }

    public function removeTag(string $tag): void
    {
        $tags = $this->tags ?? [];
        $index = array_search($tag, $tags);
        if ($index !== false) {
            unset($tags[$index]);
            $this->tags = array_values($tags);
            $this->save();
        }
    }

    // Status helpers
    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    public function isPublished(): bool
    {
        return $this->status === 'published';
    }

    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }
}
