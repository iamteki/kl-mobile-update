<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'user_id',
        'category_id',
        'reading_time',
        'status',
        'published_at',
        'views',
        'order',
        'is_featured',
        'meta_description',
        'meta_keywords',
        'meta_title',
        'tags',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_featured' => 'boolean',
        'views' => 'integer',
        'order' => 'integer',
        'reading_time' => 'integer',
        'tags' => 'array',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    // Accessors - Use created_at as published_at if published_at doesn't exist
    public function getPublishedAtAttribute($value)
    {
        if ($value) {
            return Carbon::parse($value);
        }
        
        // If no published_at and status is published, use created_at
        if ($this->status === 'published') {
            return $this->created_at;
        }
        
        return null;
    }

    // Boot method for auto-generation
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($blog) {
            if (empty($blog->slug)) {
                $blog->slug = static::generateUniqueSlug($blog->title);
            }
            
            if (empty($blog->reading_time)) {
                $blog->reading_time = static::calculateReadingTime($blog->content);
            }

            if (empty($blog->excerpt)) {
                $blog->excerpt = Str::limit(strip_tags($blog->content), 160);
            }
        });

        static::updating(function ($blog) {
            if ($blog->isDirty('title') && empty($blog->getOriginal('slug'))) {
                $blog->slug = static::generateUniqueSlug($blog->title);
            }

            if ($blog->isDirty('content')) {
                $blog->reading_time = static::calculateReadingTime($blog->content);
            }

            // Set published_at when status changes to published
            if ($blog->isDirty('status') && $blog->status === 'published' && !$blog->published_at) {
                $blog->published_at = now();
            }
        });
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

    // Calculate reading time
    private static function calculateReadingTime($content)
    {
        $wordCount = str_word_count(strip_tags($content));
        $wordsPerMinute = 200;
        return max(1, ceil($wordCount / $wordsPerMinute));
    }

    // Get featured image URL
    public function getFeaturedImageUrlAttribute()
    {
        if ($this->featured_image) {
            if (filter_var($this->featured_image, FILTER_VALIDATE_URL)) {
                return $this->featured_image;
            }
            return Storage::url($this->featured_image);
        }
        return null;
    }

    // Get meta title or fallback to title
    public function getMetaTitleAttribute($value)
    {
        return $value ?: $this->title;
    }

    // Get meta description or generate from excerpt/content
    public function getMetaDescriptionAttribute($value)
    {
        if ($value) {
            return $value;
        }

        if ($this->excerpt) {
            return Str::limit($this->excerpt, 160);
        }

        return Str::limit(strip_tags($this->content), 160);
    }
}