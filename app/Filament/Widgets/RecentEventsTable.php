<?php

namespace App\Filament\Widgets;

use App\Models\Event;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentEventsTable extends BaseWidget
{
    protected static ?string $heading = 'Recent Events';
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Event::query()
                    ->with(['eventType'])
                    ->latest()
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\ImageColumn::make('featured_image')
                    ->label('Image')
                    ->size(40)
                    ->square()
                    ->defaultImageUrl(url('/images/no-image.png')),

                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(50)
                    ->weight('medium'),

                Tables\Columns\TextColumn::make('eventType.name')
                    ->label('Type')
                    ->badge()
                    ->color('primary'),

                Tables\Columns\IconColumn::make('has_video')
                    ->label('Video')
                    ->boolean()
                    ->getStateUsing(fn($record) => !empty($record->video))
                    ->trueIcon('heroicon-o-play-circle')
                    ->falseIcon('heroicon-o-minus-circle')
                    ->trueColor('success')
                    ->falseColor('gray'),

                Tables\Columns\IconColumn::make('has_gallery')
                    ->label('Gallery')
                    ->boolean()
                    ->getStateUsing(fn($record) => !empty($record->image_gallery))
                    ->trueIcon('heroicon-o-photo')
                    ->falseIcon('heroicon-o-minus-circle')
                    ->trueColor('success')
                    ->falseColor('gray'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M j, Y')
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->url(fn ($record) => "/admin/events/{$record->id}")
                    ->icon('heroicon-o-eye'),
                Tables\Actions\Action::make('edit')
                    ->url(fn ($record) => "/admin/events/{$record->id}/edit")
                    ->icon('heroicon-o-pencil'),
            ]);
    }
}