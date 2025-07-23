<?php

namespace App\Filament\Widgets;

use App\Models\ContactInquiry;
use Filament\Widgets\ChartWidget;

class InquiriesStatusChart extends ChartWidget
{
    protected static ?string $heading = 'Inquiries by Status';
    protected static ?int $sort = 4;
    protected int | string | array $columnSpan = 1;

    protected function getData(): array
    {
        $statuses = ContactInquiry::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $statusLabels = [
            'new' => 'New',
            'read' => 'Read',
            'replied' => 'Replied',
            'archived' => 'Archived',
        ];

        $colors = [
            'new' => '#ef4444',      // red
            'read' => '#f59e0b',     // amber
            'replied' => '#10b981',  // emerald
            'archived' => '#6b7280', // gray
        ];

        $labels = [];
        $data = [];
        $backgroundColor = [];

        foreach ($statusLabels as $key => $label) {
            if (isset($statuses[$key]) && $statuses[$key] > 0) {
                $labels[] = $label . ' (' . $statuses[$key] . ')';
                $data[] = $statuses[$key];
                $backgroundColor[] = $colors[$key];
            }
        }

        return [
            'datasets' => [
                [
                    'data' => $data,
                    'backgroundColor' => $backgroundColor,
                    'borderWidth' => 2,
                    'borderColor' => '#ffffff',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'bottom',
                ],
            ],
            'maintainAspectRatio' => false,
        ];
    }
}