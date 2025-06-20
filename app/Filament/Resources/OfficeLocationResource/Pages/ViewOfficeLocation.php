<?php

namespace App\Filament\Resources\OfficeLocationResource\Pages;

use App\Filament\Resources\OfficeLocationResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Illuminate\Support\Facades\Storage;

class ViewOfficeLocation extends ViewRecord
{
    protected static string $resource = OfficeLocationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Basic Information')
                    ->schema([
                        Infolists\Components\TextEntry::make('name')
                            ->size('lg')
                            ->weight('bold'),
                        Infolists\Components\TextEntry::make('city')
                            ->badge()
                            ->color('primary'),
                        Infolists\Components\TextEntry::make('small_description'),
                    ])
                    ->columns(2),

                Infolists\Components\Section::make('Contact Information')
                    ->schema([
                        Infolists\Components\TextEntry::make('address')
                            ->columnSpanFull(),
                        Infolists\Components\TextEntry::make('phone')
                            ->copyable()
                            ->icon('heroicon-o-phone'),
                        Infolists\Components\TextEntry::make('email')
                            ->copyable()
                            ->icon('heroicon-o-envelope'),
                        Infolists\Components\TextEntry::make('open_time')
                            ->icon('heroicon-o-clock'),
                    ])
                    ->columns(3),

                Infolists\Components\Section::make('Description')
                    ->schema([
                        Infolists\Components\TextEntry::make('full_description')
                            ->html()
                            ->columnSpanFull(),
                    ]),

                Infolists\Components\Section::make('Image Gallery')
                    ->schema([
                        Infolists\Components\ImageEntry::make('image_gallery')
                            ->disk('spaces')
                            ->visibility('public')
                            ->size(150)
                            ->square()
                            ->columnSpanFull(),
                    ])
                    ->visible(fn ($record) => $record->image_gallery && count($record->image_gallery) > 0),

                Infolists\Components\Section::make('Google Maps')
                    ->schema([
                        Infolists\Components\TextEntry::make('google_map_iframe')
                            ->html()
                            ->columnSpanFull(),
                    ])
                    ->visible(fn ($record) => $record->google_map_iframe),

                Infolists\Components\Section::make('Settings')
                    ->schema([
                        Infolists\Components\IconEntry::make('is_active')
                            ->boolean()
                            ->label('Active'),
                        Infolists\Components\TextEntry::make('sort_order')
                            ->label('Display Order'),
                        Infolists\Components\TextEntry::make('created_at')
                            ->dateTime(),
                        Infolists\Components\TextEntry::make('updated_at')
                            ->dateTime(),
                    ])
                    ->columns(2),
            ]);
    }
}