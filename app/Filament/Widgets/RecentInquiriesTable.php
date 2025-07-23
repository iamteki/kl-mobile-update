<?php

namespace App\Filament\Widgets;

use App\Models\ContactInquiry;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentInquiriesTable extends BaseWidget
{
    protected static ?string $heading = 'Recent Contact Inquiries';
    protected static ?int $sort = 6;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                ContactInquiry::query()
                    ->with(['eventType'])
                    ->latest()
                    ->limit(8)
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->weight('medium')
                    ->limit(25),

                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Email copied!')
                    ->limit(30),

                Tables\Columns\TextColumn::make('service_name')
                    ->label('Service')
                    ->badge()
                    ->color('primary')
                    ->limit(20),

                Tables\Columns\TextColumn::make('message')
                    ->limit(50)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        return strlen($state) > 50 ? $state : null;
                    }),

                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'danger' => 'new',
                        'warning' => 'read',
                        'success' => 'replied',
                        'secondary' => 'archived',
                    ])
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Received')
                    ->dateTime('M j, Y')
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->url(fn ($record) => "/admin/contact-inquiries/{$record->id}")
                    ->icon('heroicon-o-eye'),
                Tables\Actions\Action::make('mark_read')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->action(function ($record) {
                        if ($record->status === 'new') {
                            $record->markAsRead();
                        }
                    })
                    ->visible(fn ($record) => $record->status === 'new'),
            ])
            ->defaultSort('created_at', 'desc');
    }
}