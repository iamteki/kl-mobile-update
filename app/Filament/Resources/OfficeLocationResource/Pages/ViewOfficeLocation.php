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
                        Infolists\Components\ImageEntry::make('icon')
                            ->label('Location Icon')
                            ->disk('public')
                            ->height(80)
                            ->width(80)
                            ->defaultImageUrl(asset('images/default-location-icon.svg')),
                        
                        Infolists\Components\TextEntry::make('name')
                            ->size('lg')
                            ->weight('bold'),
                        
                        
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
                        Infolists\Components\TextEntry::make('image_gallery')
                            ->label('Image Gallery')
                            ->formatStateUsing(function ($state, $record) {
                                // Refresh the model to get properly cast data
                                $record->refresh();
                                $gallery = $record->image_gallery;
                                
                                if (empty($gallery) || !is_array($gallery)) {
                                    return 'No images in gallery';
                                }
                                
                                $images = '';
                                foreach ($gallery as $imagePath) {
                                    $url = Storage::disk('spaces')->url($imagePath);
                                    $images .= '<img src="' . $url . '" style="width: 200px; height: 200px; object-fit: cover; margin: 5px; border-radius: 8px; border: 1px solid #e5e7eb;" />';
                                }
                                
                                return new \Illuminate\Support\HtmlString(
                                    '<div style="display: flex; flex-wrap: wrap; gap: 10px;">' . $images . '</div>'
                                );
                            })
                            ->columnSpanFull()
                            ->visible(fn ($record) => !empty($record->image_gallery)),
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