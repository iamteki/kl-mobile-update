<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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
    ];

    protected $casts = [
        'image_gallery' => 'array', // This ensures JSON is cast to array
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($event) {
            if (empty($event->slug)) {
                $event->slug = Str::slug($event->title);
            }
        });

        static::updating(function ($event) {
            if ($event->isDirty('title') && empty($event->slug)) {
                $event->slug = Str::slug($event->title);
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    // Relationships
    public function eventType()
    {
        return $this->belongsTo(EventType::class);
    }
}