<?php

namespace App\Filament\Resources\TeamResource\Pages;

use App\Filament\Resources\TeamResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Illuminate\Support\Facades\Storage;

class ViewTeam extends ViewRecord
{
    protected static string $resource = TeamResource::class;

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
                Infolists\Components\Section::make('Team Member Information')
                    ->schema([
                        Infolists\Components\ImageEntry::make('image')
                            ->disk('spaces')
                            ->height(200)
                            ->width(200)
                            ->circular()
                            ->defaultImageUrl(asset('images/placeholder-avatar.png')),
                        
                        Infolists\Components\Group::make([
                            Infolists\Components\TextEntry::make('name')
                                ->size('xl')
                                ->weight('bold'),
                            Infolists\Components\TextEntry::make('position')
                                ->badge()
                                ->color('primary'),
                        ])->columnSpan(2),
                    ])
                    ->columns(3),



             

                Infolists\Components\Section::make('Office Locations')
                    ->schema([
                        Infolists\Components\RepeatableEntry::make('officeLocations')
                            ->schema([
                                Infolists\Components\TextEntry::make('name')
                                    ->weight('bold'),
                                Infolists\Components\TextEntry::make('city')
                                    ->badge()
                                    ->color('secondary'),
                                Infolists\Components\TextEntry::make('address')
                                    ->limit(50),
                                Infolists\Components\TextEntry::make('phone')
                                    ->icon('heroicon-o-phone')
                                    ->placeholder('No phone'),
                            ])
                            ->columns(2)
                            ->grid(2)
                            ->columnSpanFull(),
                    ])
                    ->visible(fn ($record) => $record->officeLocations->count() > 0),

                Infolists\Components\Section::make('Settings & Metadata')
                    ->schema([
                        Infolists\Components\IconEntry::make('is_active')
                            ->boolean()
                            ->label('Active Status'),
                        Infolists\Components\TextEntry::make('sort_order')
                            ->label('Display Order'),
                        Infolists\Components\TextEntry::make('created_at')
                            ->dateTime()
                            ->label('Created'),
                        Infolists\Components\TextEntry::make('updated_at')
                            ->dateTime()
                            ->label('Last Updated'),
                    ])
                    ->columns(2)
                    ->collapsible(),
            ]);
    }
}