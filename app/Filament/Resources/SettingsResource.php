<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingsResource\Pages;
use App\Models\Settings;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SettingsResource extends Resource
{
    protected static ?string $model = Settings::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationGroup = 'System';

    protected static ?string $navigationLabel = 'Settings';

    protected static ?string $pluralModelLabel = 'Settings';

    protected static ?int $navigationSort = 10;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Hero Section')
                    ->description('Manage hero video and featured image for the homepage')
                    ->schema([
                        Forms\Components\FileUpload::make('hero_featured_image')
                            ->label('Hero Featured Image')
                            ->image()
                            ->disk('spaces')
                            ->directory('settings/hero')
                            ->visibility('public')
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '16:9',
                                '21:9',
                                '4:3',
                            ])
                            ->maxSize(10240) // 10MB max
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->helperText('Upload hero image for homepage banner (max 10MB). Recommended: 1920x1080px or larger.')
                            ->columnSpanFull(),

                        Forms\Components\FileUpload::make('hero_video')
                            ->label('Hero Video')
                            ->disk('spaces')
                            ->directory('settings/hero')
                            ->visibility('public')
                            ->acceptedFileTypes(['video/mp4', 'video/avi', 'video/mov', 'video/wmv', 'video/webm'])
                            ->maxSize(204800) // 200MB max
                            ->helperText('Upload hero video for homepage banner (max 200MB). Supported formats: MP4, AVI, MOV, WMV, WebM.')
                            ->columnSpanFull(),
                    ])
                    ->columns(1),

                Forms\Components\Section::make('Company Profile')
                    ->description('Upload company profile document')
                    ->schema([
                        Forms\Components\FileUpload::make('company_profile_pdf')
                            ->label('Company Profile PDF')
                            ->disk('spaces')
                            ->directory('settings/documents')
                            ->visibility('public')
                            ->acceptedFileTypes(['application/pdf'])
                            ->maxSize(51200) // 50MB max
                            ->helperText('Upload company profile PDF document (max 50MB)')
                            ->downloadable()
                            ->previewable(false)
                            ->columnSpanFull(),
                    ])
                    ->columns(1),

                Forms\Components\Section::make('Social Media Links')
    ->description('Manage social media profile links (up to 6 platforms supported)')
    ->schema([
        Forms\Components\TextInput::make('facebook_url')
            ->label('Facebook URL')
            ->url()
            ->placeholder('https://facebook.com/yourpage')
            ->prefixIcon('heroicon-m-globe-alt'),

        Forms\Components\TextInput::make('twitter_url')
            ->label('Twitter URL')
            ->url()
            ->placeholder('https://twitter.com/youraccount')
            ->prefixIcon('heroicon-m-globe-alt'),

        Forms\Components\TextInput::make('instagram_url')
            ->label('Instagram URL')
            ->url()
            ->placeholder('https://instagram.com/youraccount')
            ->prefixIcon('heroicon-m-globe-alt'),

        Forms\Components\TextInput::make('linkedin_url')
            ->label('LinkedIn URL')
            ->url()
            ->placeholder('https://linkedin.com/company/yourcompany')
            ->prefixIcon('heroicon-m-globe-alt'),

        Forms\Components\TextInput::make('youtube_url')
            ->label('YouTube URL')
            ->url()
            ->placeholder('https://youtube.com/channel/yourchannel')
            ->prefixIcon('heroicon-m-globe-alt'),

        Forms\Components\TextInput::make('tiktok_url')
            ->label('TikTok URL')
            ->url()
            ->placeholder('https://tiktok.com/@youraccount')
            ->prefixIcon('heroicon-m-globe-alt'),
    ])
    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('Settings ID')
                    ->sortable(),

                Tables\Columns\IconColumn::make('hero_featured_image')
                    ->label('Hero Image')
                    ->boolean()
                    ->getStateUsing(fn ($record) => !empty($record->hero_featured_image))
                    ->trueIcon('heroicon-o-photo')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('gray'),

                Tables\Columns\IconColumn::make('hero_video')
                    ->label('Hero Video')
                    ->boolean()
                    ->getStateUsing(fn ($record) => !empty($record->hero_video))
                    ->trueIcon('heroicon-o-play-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('gray'),

                Tables\Columns\IconColumn::make('company_profile_pdf')
                    ->label('Company PDF')
                    ->boolean()
                    ->getStateUsing(fn ($record) => !empty($record->company_profile_pdf))
                    ->trueIcon('heroicon-o-document')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('gray'),

                Tables\Columns\TextColumn::make('social_links_count')
                    ->label('Social Links')
                    ->getStateUsing(fn ($record) => count($record->social_links))
                    ->badge()
                    ->color('primary'),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Edit Settings'),
                Tables\Actions\ViewAction::make()
                    ->label('View Settings'),
            ])
            ->bulkActions([
                // No bulk actions needed for singleton resource
            ])
            ->paginated(false); // Disable pagination since there's only one record
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSettings::route('/'),
            'edit' => Pages\EditSettings::route('/{record}/edit'),
            'view' => Pages\ViewSettings::route('/{record}'),
        ];
    }

    // Override to show current settings or create if none exist
    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        // Ensure settings record exists
        Settings::current();
        
        return parent::getEloquentQuery();
    }

    public static function canCreate(): bool
    {
        // Prevent creating new settings if one already exists
        return Settings::count() === 0;
    }

    public static function canDeleteAny(): bool
    {
        // Prevent deletion of settings
        return false;
    }

    public static function canDelete(\Illuminate\Database\Eloquent\Model $record): bool
    {
        // Prevent deletion of settings
        return false;
    }
}