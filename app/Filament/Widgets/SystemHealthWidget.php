<?php

namespace App\Filament\Widgets;

use App\Models\Event;
use App\Models\Blog;
use App\Models\EventType;
use App\Models\Category;
use App\Models\ContactInquiry;
use App\Models\Faq;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SystemHealthWidget extends BaseWidget
{
    protected static ?int $sort = 7;
    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        return [
            Stat::make('Content Health', $this->getContentHealthPercentage() . '%')
                ->description($this->getContentHealthDescription())
                ->descriptionIcon('heroicon-m-heart')
                ->color($this->getContentHealthColor()),

            Stat::make('SEO Coverage', $this->getSeoHealthPercentage() . '%')
                ->description($this->getSeoHealthDescription())
                ->descriptionIcon('heroicon-m-magnifying-glass')
                ->color($this->getSeoHealthColor()),

            Stat::make('Response Rate', $this->getResponseRate() . '%')
                ->description($this->getResponseDescription())
                ->descriptionIcon('heroicon-m-chat-bubble-left-right')
                ->color($this->getResponseColor()),

            Stat::make('Active Content', $this->getActiveContentCount())
                ->description('Live pages & posts')
                ->descriptionIcon('heroicon-m-globe-alt')
                ->color('success'),
        ];
    }

    private function getContentHealthPercentage(): int
    {
        $totalEvents = Event::count();
        $eventsWithImages = Event::whereNotNull('featured_image')->count();
        $eventsWithDescription = Event::whereNotNull('description')->count();
        
        if ($totalEvents === 0) return 100;
        
        $healthScore = (($eventsWithImages + $eventsWithDescription) / ($totalEvents * 2)) * 100;
        return round($healthScore);
    }

    private function getContentHealthDescription(): string
    {
        $percentage = $this->getContentHealthPercentage();
        if ($percentage >= 80) return 'Excellent content quality';
        if ($percentage >= 60) return 'Good content quality';
        if ($percentage >= 40) return 'Fair content quality';
        return 'Needs improvement';
    }

    private function getContentHealthColor(): string
    {
        $percentage = $this->getContentHealthPercentage();
        if ($percentage >= 80) return 'success';
        if ($percentage >= 60) return 'warning';
        return 'danger';
    }

    private function getSeoHealthPercentage(): int
    {
        $totalEvents = Event::count();
        $totalBlogs = Blog::where('status', 'published')->count();
        $totalContent = $totalEvents + $totalBlogs;
        
        if ($totalContent === 0) return 100;
        
        $eventsWithSeo = Event::whereNotNull('meta_description')->count();
        $blogsWithSeo = Blog::where('status', 'published')->whereNotNull('meta_description')->count();
        
        $seoScore = (($eventsWithSeo + $blogsWithSeo) / $totalContent) * 100;
        return round($seoScore);
    }

    private function getSeoHealthDescription(): string
    {
        $percentage = $this->getSeoHealthPercentage();
        if ($percentage >= 80) return 'SEO optimized';
        if ($percentage >= 60) return 'Good SEO coverage';
        if ($percentage >= 40) return 'Moderate SEO coverage';
        return 'Poor SEO coverage';
    }

    private function getSeoHealthColor(): string
    {
        $percentage = $this->getSeoHealthPercentage();
        if ($percentage >= 80) return 'success';
        if ($percentage >= 60) return 'warning';
        return 'danger';
    }

    private function getResponseRate(): int
    {
        $totalInquiries = ContactInquiry::where('created_at', '>=', now()->subMonth())->count();
        if ($totalInquiries === 0) return 100;
        
        $respondedInquiries = ContactInquiry::whereIn('status', ['replied'])
            ->where('created_at', '>=', now()->subMonth())
            ->count();
        
        return round(($respondedInquiries / $totalInquiries) * 100);
    }

    private function getResponseDescription(): string
    {
        $rate = $this->getResponseRate();
        if ($rate >= 80) return 'Excellent response rate';
        if ($rate >= 60) return 'Good response rate';
        if ($rate >= 40) return 'Fair response rate';
        return 'Poor response rate';
    }

    private function getResponseColor(): string
    {
        $rate = $this->getResponseRate();
        if ($rate >= 80) return 'success';
        if ($rate >= 60) return 'warning';
        return 'danger';
    }

    private function getActiveContentCount(): int
    {
        $activeEvents = Event::count();
        $activeBlogs = Blog::where('status', 'published')->count();
        $activeEventTypes = EventType::where('status', true)->count();
        $activeCategories = Category::where('status', true)->count();
        $activeFaqs = Faq::where('is_active', true)->count();
        
        return $activeEvents + $activeBlogs + $activeEventTypes + $activeCategories + $activeFaqs;
    }
}