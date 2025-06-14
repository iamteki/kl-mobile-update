<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'position',
        'company',
        'testimonial',
        'rating',
        'status',
        'order',
    ];

    protected $casts = [
        'status' => 'boolean',
        'rating' => 'integer',
        'order' => 'integer',
    ];

    // Scope for active testimonials
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    // Scope for ordered testimonials
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    // Scope for rating
    public function scopeWithRating($query, $rating)
    {
        return $query->where('rating', $rating);
    }

    // Get testimonials by rating
    public function scopeHighRated($query)
    {
        return $query->where('rating', '>=', 4);
    }

    // Get star display
    public function getStarDisplayAttribute()
    {
        return str_repeat('★', $this->rating) . str_repeat('☆', 5 - $this->rating);
    }

    // Get full name with position
    public function getFullTitleAttribute()
    {
        $title = $this->name;
        if ($this->position) {
            $title .= ', ' . $this->position;
        }
        if ($this->company) {
            $title .= ' at ' . $this->company;
        }
        return $title;
    }
}