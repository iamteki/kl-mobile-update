<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Settings extends Model
{
    use HasFactory;

    protected $fillable = [
        'hero_video',
        'hero_featured_image',
        'facebook_url',
        'twitter_url',
        'instagram_url',
        'linkedin_url',
        'youtube_url',
        'tiktok_url',
        'company_profile_pdf',
    ];

    // Singleton pattern - ensure only one settings record exists
    public static function current()
    {
        $settings = static::first();
        
        if (!$settings) {
            $settings = static::create([]);
        }
        
        return $settings;
    }

    // URL Accessors for media files
    public function getHeroVideoUrlAttribute()
    {
        return $this->hero_video ? Storage::disk('spaces')->url($this->hero_video) : null;
    }

    public function getHeroFeaturedImageUrlAttribute()
    {
        return $this->hero_featured_image ? Storage::disk('spaces')->url($this->hero_featured_image) : null;
    }

    public function getCompanyProfilePdfUrlAttribute()
    {
        return $this->company_profile_pdf ? Storage::disk('spaces')->url($this->company_profile_pdf) : null;
    }

    // Social Media Links as array (filtered to remove empty values)
    public function getSocialLinksAttribute()
    {
        return collect([
            'facebook' => $this->facebook_url,
            'twitter' => $this->twitter_url,
            'instagram' => $this->instagram_url,
            'linkedin' => $this->linkedin_url,
            'youtube' => $this->youtube_url,
            'tiktok' => $this->tiktok_url,
        ])->filter()->toArray();
    }

    // Get formatted social media links with icons and labels
    public function getFormattedSocialLinksAttribute()
    {
        $socialMediaIcons = [
            'facebook' => [
                'icon' => 'fab fa-facebook-f',
                'label' => 'Facebook',
                'url' => $this->facebook_url
            ],
            'twitter' => [
                'icon' => 'fab fa-twitter',
                'label' => 'Twitter',
                'url' => $this->twitter_url
            ],
            'instagram' => [
                'icon' => 'fab fa-instagram',
                'label' => 'Instagram',
                'url' => $this->instagram_url
            ],
            'linkedin' => [
                'icon' => 'fab fa-linkedin-in',
                'label' => 'LinkedIn',
                'url' => $this->linkedin_url
            ],
            'youtube' => [
                'icon' => 'fab fa-youtube',
                'label' => 'YouTube',
                'url' => $this->youtube_url
            ],
            'tiktok' => [
                'icon' => 'fab fa-tiktok',
                'label' => 'TikTok',
                'url' => $this->tiktok_url
            ]
        ];

        return collect($socialMediaIcons)
            ->filter(function ($social) {
                return !empty($social['url']);
            })
            ->toArray();
    }

    // Check if any social media link is set
    public function hasSocialMediaLinks()
    {
        return collect([
            $this->facebook_url,
            $this->twitter_url,
            $this->instagram_url,
            $this->linkedin_url,
            $this->youtube_url,
            $this->tiktok_url
        ])->filter()->isNotEmpty();
    }

    // Boot method to ensure singleton behavior
    protected static function boot()
    {
        parent::boot();

        // Prevent deletion if it's the only record
        static::deleting(function ($settings) {
            if (static::count() <= 1) {
                return false;
            }
        });

        // Prevent creating multiple records
        static::creating(function ($settings) {
            if (static::count() >= 1) {
                return false;
            }
        });
    }
}