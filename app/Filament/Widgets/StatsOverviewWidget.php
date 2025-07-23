<?php

namespace App\Filament\Widgets;

use App\Models\Event;
use App\Models\EventType;
use App\Models\Blog;
use App\Models\ContactInquiry;
use App\Models\Client;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Events', Event::count())
                ->description('All events in portfolio')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('success')
                ->chart($this->getEventChart()),

            Stat::make('Event Types', EventType::where('status', true)->count())
                ->description('Active event categories')
                ->descriptionIcon('heroicon-m-tag')
                ->color('primary')
                ->url('/admin/event-types'),

            Stat::make('New Inquiries', ContactInquiry::where('status', 'new')->count())
                ->description('Unread contact inquiries')
                ->descriptionIcon('heroicon-m-envelope')
                ->color('warning')
                ->url('/admin/contact-inquiries'),

            Stat::make('Published Blogs', Blog::where('status', 'published')->count())
                ->description('Live blog posts')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('info')
                ->chart($this->getBlogChart()),
        ];
    }

    private function getEventChart(): array
    {
        // Get events created in the last 7 days
        $events = Event::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $chart = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $count = $events->where('date', $date)->first()->count ?? 0;
            $chart[] = $count;
        }

        return $chart;
    }

    private function getBlogChart(): array
    {
        // Get blogs published in the last 7 days
        $blogs = Blog::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(7))
            ->where('status', 'published')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $chart = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $count = $blogs->where('date', $date)->first()->count ?? 0;
            $chart[] = $count;
        }

        return $chart;
    }
}