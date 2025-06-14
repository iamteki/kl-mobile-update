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
        return $query->where('status', 'published')->whereNotNull('published_at');
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
        return $query->orderBy('published_at', 'desc');
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

            if (empty($blog->user_id)) {
                $blog->user_id = auth()->id();
            }
        });

        static::updating(function ($blog) {
            if ($blog->isDirty('title')) {
                $blog->slug = static::generateUniqueSlug($blog->title, $blog->id);
            }
            
            if ($blog->isDirty('content')) {
                $blog->reading_time = static::calculateReadingTime($blog->content);
            }

            // Auto-publish when status changes to published
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

    // Calculate reading time (average 200 words per minute)
    private static function calculateReadingTime($content)
    {
        $wordCount = str_word_count(strip_tags($content));
        return max(1, ceil($wordCount / 200)); // Minimum 1 minute
    }

    // Accessors
    public function getMetaTitleAttribute($value)
    {
        return $value ?: $this->title;
    }

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

    public function getAuthorNameAttribute()
    {
        return $this->user ? $this->user->name : 'Unknown Author';
    }

    public function getPublishedDateAttribute()
    {
        return $this->published_at ? $this->published_at->format('M d, Y') : null;
    }

    public function getReadingTimeTextAttribute()
    {
        return $this->reading_time . ' min read';
    }

    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'published' => 'success',
            'draft' => 'warning',
            'archived' => 'danger',
            default => 'secondary'
        };
    }

    // Helper methods
    public function incrementViews()
    {
        $this->increment('views');
    }

    public function isPublished()
    {
        return $this->status === 'published' && $this->published_at && $this->published_at <= now();
    }

    public function isDraft()
    {
        return $this->status === 'draft';
    }

    public function isArchived()
    {
        return $this->status === 'archived';
    }
}