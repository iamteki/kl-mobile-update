<?php

namespace App\Filament\Resources\EventResource\Pages;

use App\Filament\Resources\EventResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Illuminate\Support\Facades\Storage;

class ViewEvent extends ViewRecord
{
    protected static string $resource = EventResource::class;

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
                        Infolists\Components\TextEntry::make('eventType.name')
                            ->badge()
                            ->color('primary')
                            ->label('Event Type'),
                        
                        Infolists\Components\TextEntry::make('title')
                            ->weight('bold')
                            ->size('lg'),
                        
                        Infolists\Components\TextEntry::make('slug')
                            ->badge()
                            ->color('gray')
                            ->copyable(),
                        
                        Infolists\Components\TextEntry::make('excerpt')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Infolists\Components\Section::make('Media')
                    ->schema([
                        Infolists\Components\ImageEntry::make('featured_image')
                            ->disk('spaces')
                            ->height(300)
                            ->label('Featured Image'),
                        
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
                    ->columns(1),

                Infolists\Components\Section::make('Video Content')
                    ->schema([
                        Infolists\Components\TextEntry::make('video_title')
                            ->label('Video Title'),
                        
                        Infolists\Components\TextEntry::make('video')
                            ->formatStateUsing(function ($state, $record) {
                                if (!$state) return 'No video uploaded';
                                
                                $url = Storage::disk('spaces')->url($state);
                                return new \Illuminate\Support\HtmlString(
                                    '<video controls width="100%" style="max-width: 600px;">
                                        <source src="' . $url . '" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>'
                                );
                            })
                            ->label('Video')
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->visible(fn ($record) => $record->video || $record->video_title),

                Infolists\Components\Section::make('Content')
                    ->schema([
                        Infolists\Components\TextEntry::make('description')
                            ->html()
                            ->columnSpanFull()
                            ->label('Description'),
                    ])
                    ->visible(fn ($record) => !empty($record->description)),

                Infolists\Components\Section::make('Metadata')
                    ->schema([
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