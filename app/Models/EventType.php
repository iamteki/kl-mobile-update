<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class EventType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'status',
        'order',
    ];

    protected $casts = [
        'status' => 'boolean',
        'order' => 'integer',
    ];

    // Scope for active event types
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    // Scope for ordered event types
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    // Boot method to auto-generate slug
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($eventType) {
            if (empty($eventType->slug)) {
                $eventType->slug = static::generateUniqueSlug($eventType->name);
            }
        });

        static::updating(function ($eventType) {
            if ($eventType->isDirty('name')) {
                $eventType->slug = static::generateUniqueSlug($eventType->name, $eventType->id);
            }
        });
    }

    // Generate unique slug
    private static function generateUniqueSlug($name, $id = null)
    {
        $slug = Str::slug($name);
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
}