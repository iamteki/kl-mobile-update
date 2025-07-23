<?php

namespace App\Filament\Widgets;

use App\Models\Blog;
use Filament\Widgets\ChartWidget;

class BlogPerformanceChart extends ChartWidget
{
    protected static ?string $heading = 'Blog Performance (Views)';
    protected static ?int $sort = 5;
    protected int | string | array $columnSpan = 1;

    protected function getData(): array
    {
        $topBlogs = Blog::where('status', 'published')
            ->orderBy('views', 'desc')
            ->limit(5)
            ->get(['title', 'views']);

        return [
            'datasets' => [
                [
                    'label' => 'Views',
                    'data' => $topBlogs->pluck('views')->toArray(),
                    'backgroundColor' => [
                        '#3b82f6', // blue
                        '#10b981', // emerald
                        '#f59e0b', // amber
                        '#ef4444', // red
                        '#8b5cf6', // violet
                    ],
                    'borderWidth' => 2,
                    'borderColor' => '#ffffff',
                ],
            ],
            'labels' => $topBlogs->map(function ($blog) {
                return strlen($blog->title) > 20 
                    ? substr($blog->title, 0, 20) . '...' 
                    : $blog->title;
            })->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                ],
            ],
            'maintainAspectRatio' => false,
        ];
    }
}