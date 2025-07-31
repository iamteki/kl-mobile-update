<?php

namespace App\Filament\Resources\SettingsResource\Pages;

use App\Filament\Resources\SettingsResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class ViewSettings extends ViewRecord
{
    protected static string $resource = SettingsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->label('Edit Settings'),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Hero Section')
                    ->schema([
                        Infolists\Components\ImageEntry::make('hero_featured_image')
                            ->disk('spaces')
                            ->height(300)
                            ->label('Hero Featured Image')
                            ->placeholder('No hero image uploaded'),

                        Infolists\Components\TextEntry::make('hero_video')
                            ->label('Hero Video')
                            ->formatStateUsing(function ($state, $record) {
                                if (!$state) return 'No hero video uploaded';
                                
                                $url = $record->hero_video_url;
                                return new \Illuminate\Support\HtmlString(
                                    '<video controls width="100%" style="max-width: 600px; max-height: 300px;">
                                        <source src="' . $url . '" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>'
                                );
                            })
                            ->columnSpanFull(),
                    ])
                    ->columns(1),

                Infolists\Components\Section::make('Company Profile')
                    ->schema([
                        Infolists\Components\TextEntry::make('company_profile_pdf')
                            ->label('Company Profile PDF')
                            ->formatStateUsing(function ($state, $record) {
                                if (!$state) return 'No company profile uploaded';
                                
                                $url = $record->company_profile_pdf_url;
                                $filename = basename($state);
                                
                                return new \Illuminate\Support\HtmlString(
                                    '<a href="' . $url . '" target="_blank" class="inline-flex items-center gap-2 text-primary-600 hover:text-primary-700">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/>
                                        </svg>
                                        Download PDF: ' . $filename . '
                                    </a>'
                                );
                            })
                            ->columnSpanFull(),
                    ]),

               Infolists\Components\Section::make('Social Media Links')
    ->schema([
        Infolists\Components\TextEntry::make('facebook_url')
            ->label('Facebook')
            ->formatStateUsing(function ($state) {
                if (!$state) return 'Not set';
                return new \Illuminate\Support\HtmlString(
                    '<a href="' . $state . '" target="_blank" class="text-primary-600 hover:text-primary-700">' . $state . '</a>'
                );
            }),

        Infolists\Components\TextEntry::make('twitter_url')
            ->label('Twitter')
            ->formatStateUsing(function ($state) {
                if (!$state) return 'Not set';
                return new \Illuminate\Support\HtmlString(
                    '<a href="' . $state . '" target="_blank" class="text-primary-600 hover:text-primary-700">' . $state . '</a>'
                );
            }),

        Infolists\Components\TextEntry::make('instagram_url')
            ->label('Instagram')
            ->formatStateUsing(function ($state) {
                if (!$state) return 'Not set';
                return new \Illuminate\Support\HtmlString(
                    '<a href="' . $state . '" target="_blank" class="text-primary-600 hover:text-primary-700">' . $state . '</a>'
                );
            }),

        Infolists\Components\TextEntry::make('linkedin_url')
            ->label('LinkedIn')
            ->formatStateUsing(function ($state) {
                if (!$state) return 'Not set';
                return new \Illuminate\Support\HtmlString(
                    '<a href="' . $state . '" target="_blank" class="text-primary-600 hover:text-primary-700">' . $state . '</a>'
                );
            }),

        Infolists\Components\TextEntry::make('youtube_url')
            ->label('YouTube')
            ->formatStateUsing(function ($state) {
                if (!$state) return 'Not set';
                return new \Illuminate\Support\HtmlString(
                    '<a href="' . $state . '" target="_blank" class="text-primary-600 hover:text-primary-700">' . $state . '</a>'
                );
            }),

        Infolists\Components\TextEntry::make('tiktok_url')
            ->label('TikTok')
            ->formatStateUsing(function ($state) {
                if (!$state) return 'Not set';
                return new \Illuminate\Support\HtmlString(
                    '<a href="' . $state . '" target="_blank" class="text-primary-600 hover:text-primary-700">' . $state . '</a>'
                );
            }),
    ])
    ->columns(2),

                Infolists\Components\Section::make('System Information')
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