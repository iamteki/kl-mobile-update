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
                        
                        Infolists\Components\ImageEntry::make('video_thumbnail')
                            ->disk('spaces')
                            ->height(200)
                            ->label('Video Thumbnail')
                            ->placeholder('No video thumbnail uploaded'),
                        
                        Infolists\Components\TextEntry::make('video')
                            ->formatStateUsing(function ($state, $record) {
                                if (!$state) return 'No video uploaded';
                                
                                $url = Storage::disk('spaces')->url($state);
                                $posterUrl = $record->video_thumbnail ? Storage::disk('spaces')->url($record->video_thumbnail) : '';
                                $posterAttribute = $posterUrl ? 'poster="' . $posterUrl . '"' : '';
                                
                                return new \Illuminate\Support\HtmlString(
                                    '<video controls width="100%" style="max-width: 600px;" ' . $posterAttribute . '>
                                        <source src="' . $url . '" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>'
                                );
                            })
                            ->label('Video')
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->visible(fn ($record) => $record->video || $record->video_title || $record->video_thumbnail),

                Infolists\Components\Section::make('Content')
                    ->schema([
                        Infolists\Components\TextEntry::make('description')
                            ->html()
                            ->columnSpanFull()
                            ->label('Description'),
                    ])
                    ->visible(fn ($record) => !empty($record->description)),

                Infolists\Components\Section::make('SEO Information')
                    ->schema([
                        Infolists\Components\TextEntry::make('meta_title')
                            ->label('Meta Title')
                            ->placeholder('Using event title as meta title'),
                        
                        Infolists\Components\TextEntry::make('meta_description')
                            ->label('Meta Description')
                            ->placeholder('Auto-generated from excerpt')
                            ->columnSpanFull(),
                        
                        Infolists\Components\TextEntry::make('meta_keywords')
                            ->label('Meta Keywords')
                            ->placeholder('No keywords set')
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->collapsible()
                    ->collapsed()
                    ->visible(fn ($record) => $record->meta_title || $record->meta_description || $record->meta_keywords),

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