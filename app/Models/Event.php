<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_type_id',
        'title',
        'excerpt',
        'slug',
        'featured_image',
        'video',
        'image_gallery',
        'video_title',
        'description',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'image_gallery' => 'array', // This ensures JSON is cast to array
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($event) {
            if (empty($event->slug)) {
                $event->slug = self::generateUniqueSlug($event->title);
            }
        });

        static::updating(function ($event) {
            if ($event->isDirty('title')) {
                $event->slug = self::generateUniqueSlug($event->title, $event->id);
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    // Generate unique slug
    private static function generateUniqueSlug($title, $id = null)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;

        while (static::where('slug', $slug)->when($id, function ($query) use ($id) {
            return $query->where('id', '!=', $id);
        })->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    // Get meta title or fallback to title
    public function getMetaTitleAttribute($value)
    {
        return $value ?: $this->title;
    }

    // Get meta description or generate from excerpt/description
    public function getMetaDescriptionAttribute($value)
    {
        if ($value) {
            return $value;
        }

        if ($this->excerpt) {
            return Str::limit(strip_tags($this->excerpt), 160);
        }

        if ($this->description) {
            return Str::limit(strip_tags($this->description), 160);
        }

        return "Learn more about {$this->title} event details.";
    }

    // Get featured image URL
    public function getFeaturedImageUrlAttribute()
    {
        if ($this->featured_image) {
            // If it's a full URL (external image), return as is
            if (filter_var($this->featured_image, FILTER_VALIDATE_URL)) {
                return $this->featured_image;
            }
            // If it's a local file, return the storage URL
            return Storage::url($this->featured_image);
        }

        return null;
    }

    // Get keywords as array
    public function getKeywordsArrayAttribute()
    {
        if ($this->meta_keywords) {
            return array_map('trim', explode(',', $this->meta_keywords));
        }

        return [];
    }

    // Relationships
    public function eventType()
    {
        return $this->belongsTo(EventType::class);
    }

    // Scopes
    public function scopeByEventType($query, $eventTypeSlug)
    {
        return $query->whereHas('eventType', function ($q) use ($eventTypeSlug) {
            $q->where('slug', $eventTypeSlug);
        });
    }
}