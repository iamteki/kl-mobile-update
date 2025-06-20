<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class OfficeLocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'city',
        'small_description',
        'full_description',
        'open_time',
        'phone',
        'email',
        'address',
        'photo_gallery',
        'google_map_iframe',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'photo_gallery' => 'array',
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->name);
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty('name') && empty($model->getOriginal('slug'))) {
                $model->slug = Str::slug($model->name);
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getImageGalleryUrlsAttribute()
    {
        if (!$this->image_gallery || !is_array($this->image_gallery)) {
            return [];
        }

        return collect($this->image_gallery)->map(function ($image) {
            return Storage::disk('spaces')->url($image);
        })->toArray();
    }
}
