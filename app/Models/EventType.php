<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class EventType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'meta_description',
        'meta_keywords',
        'meta_title',
        'description',
        'image',
        'image_alt',
        'status',
        'order',
    ];

    protected $casts = [
        'status' => 'boolean',
        'order' => 'integer',
    ];

    public function events()
    {
        return $this->hasMany(Event::class);
    }

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

        // Delete old image when updating
        static::updating(function ($eventType) {
            if ($eventType->isDirty('image')) {
                $oldImage = $eventType->getOriginal('image');
                if ($oldImage && Storage::disk('public')->exists($oldImage)) {
                    Storage::disk('public')->delete($oldImage);
                }
            }
        });

        // Delete image when deleting record
        static::deleting(function ($eventType) {
            if ($eventType->image && Storage::disk('public')->exists($eventType->image)) {
                Storage::disk('public')->delete($eventType->image);
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

    // Get meta title or fallback to name
    public function getMetaTitleAttribute($value)
    {
        return $value ?: $this->name;
    }

    // Get meta description or generate from description
    public function getMetaDescriptionAttribute($value)
    {
        if ($value) {
            return $value;
        }

        if ($this->description) {
            return Str::limit(strip_tags($this->description), 160);
        }

        return "Learn more about {$this->name} events and their details.";
    }

    // Get image URL - Updated version
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            // If it's a full URL (external image), return as is
            if (filter_var($this->image, FILTER_VALIDATE_URL)) {
                return $this->image;
            }
            // If it's a local file, return the storage URL
            return Storage::url($this->image);
        }

        return null;
    }

    // Get display image with fallback placeholder
    public function getDisplayImageAttribute()
    {
        if ($this->image) {
            // If it's a full URL (external image), return as is
            if (filter_var($this->image, FILTER_VALIDATE_URL)) {
                return $this->image;
            }
            // If it's a local file, return the storage URL
            return asset('storage/' . $this->image);
        }
        
        // Return a placeholder image with purple theme
        return 'https://via.placeholder.com/800x800/9333EA/FFFFFF?text=' . urlencode($this->name);
    }

    // Get image alt text with fallback
    public function getImageAltTextAttribute()
    {
        return $this->image_alt ?: $this->name . ' Event Category';
    }

    // Get keywords as array
    public function getKeywordsArrayAttribute()
    {
        if ($this->meta_keywords) {
            return array_map('trim', explode(',', $this->meta_keywords));
        }

        return [];
    }

    // Check if has image
    public function hasImage()
    {
        return !empty($this->image);
    }
}