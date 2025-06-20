<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'position',
        'image',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    // Relationships
    public function officeLocations()
    {
        return $this->belongsToMany(OfficeLocation::class, 'team_office_locations');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    // Accessors
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            // If it's already a full URL (from external source)
            if (filter_var($this->image, FILTER_VALIDATE_URL)) {
                return $this->image;
            }
            
            // Check if using S3/Spaces storage
            if (config('filesystems.default') === 'spaces') {
                return Storage::disk('spaces')->url($this->image);
            }
            
            // Default to public storage
            return Storage::url($this->image);
        }
        
        // Return a placeholder if no image
        return asset('images/placeholder-avatar.png');
    }

    public function getOfficeNamesAttribute()
    {
        return $this->officeLocations->pluck('name')->implode(', ');
    }

    public function getOfficeCitiesAttribute()
    {
        return $this->officeLocations->pluck('city')->unique()->implode(', ');
    }
}