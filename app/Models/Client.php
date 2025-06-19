<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'order',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    /**
     * Get the image URL attribute
     */
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            // If it's already a full URL (from external source)
            if (filter_var($this->image, FILTER_VALIDATE_URL)) {
                return $this->image;
            }
            
            // If it's a local asset path
            return asset($this->image);
        }
        
        // Return a placeholder if no image
        return asset('images/placeholder-logo.png');
    }

    /**
     * Scope to get active clients ordered by order field
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    /**
     * Scope to get clients with odd order numbers
     */
    public function scopeOddOrder($query)
    {
        return $query->whereRaw('`order` % 2 = 1');
    }

    /**
     * Scope to get clients with even order numbers
     */
    public function scopeEvenOrder($query)
    {
        return $query->whereRaw('`order` % 2 = 0');
    }
}