<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Models\Event;
use App\Models\EventType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationGroup = 'Event Management';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Basic Information')
                    ->schema([
                        Forms\Components\Select::make('event_type_id')
                            ->relationship('eventType', 'name')
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn(string $context, $state, Forms\Set $set) => $context === 'create' ? $set('slug', Str::slug($state)) : null),

                                Forms\Components\TextInput::make('slug')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(EventType::class, 'slug')
                                    ->rules(['regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/']),

                                Forms\Components\Toggle::make('status')
                                    ->default(true),

                                Forms\Components\TextInput::make('order')
                                    ->numeric()
                                    ->default(0),

                                Forms\Components\Textarea::make('description')
                                    ->maxLength(1000),
                            ])
                            ->label('Event Type'),

                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $context, $state, callable $set, callable $get) {
                                if ($context === 'create') {
                                    $set('slug', Str::slug($state));
                                    
                                    // Auto-generate meta title if empty
                                    if (empty($get('meta_title'))) {
                                        $set('meta_title', $state);
                                    }
                                }
                            }),

                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(Event::class, 'slug', ignoreRecord: true)
                            ->rules(['regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/'])
                            ->helperText('Only lowercase letters, numbers, and hyphens allowed.'),

                        Forms\Components\Textarea::make('excerpt')
                            ->maxLength(500)
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Media')
                    ->schema([
                        Forms\Components\FileUpload::make('featured_image')
                            ->image()
                            ->disk('spaces')
                            ->directory('events/featured')
                            ->visibility('public')
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '16:9',
                                '4:3',
                                '1:1',
                            ])
                            ->maxSize(5120), // 5MB

                        Forms\Components\FileUpload::make('image_gallery')
                            ->image()
                            ->multiple()
                            ->disk('spaces')
                            ->directory('events/gallery')
                            ->visibility('public')
                            ->imageEditor()
                            ->reorderable()
                            ->maxFiles(10)
                            ->maxSize(5120) // 5MB per image
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Video Content')
                    ->schema([
                        Forms\Components\TextInput::make('video_title')
                            ->maxLength(255),

                        Forms\Components\FileUpload::make('video')
                            ->disk('spaces')
                            ->directory('events/videos')
                            ->visibility('public')
                            ->acceptedFileTypes(['video/mp4', 'video/avi', 'video/mov', 'video/wmv'])
                            ->maxSize(102400) // 100MB
                            ->helperText('Supported formats: MP4, AVI, MOV, WMV. Max size: 100MB')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Content')
                    ->schema([
                        Forms\Components\RichEditor::make('description')
                            ->toolbarButtons([
                                'attachFiles',
                                'blockquote',
                                'bold',
                                'bulletList',
                                'codeBlock',
                                'h2',
                                'h3',
                                'italic',
                                'link',
                                'orderedList',
                                'redo',
                                'strike',
                                'underline',
                                'undo',
                            ])
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('SEO Settings')
                    ->description('Configure SEO meta tags for better search engine visibility')
                    ->icon('heroicon-o-magnifying-glass')
                    ->schema([
                        Forms\Components\TextInput::make('meta_title')
                            ->label('Meta Title')
                            ->maxLength(60)
                            ->placeholder('Custom meta title (leave empty to use event title)')
                            ->helperText('Recommended: 50-60 characters. Will use event title if empty.')
                            ->live()
                            ->afterStateUpdated(function ($state, callable $set) {
                                $set('meta_title_length', strlen($state ?? ''));
                            }),

                        Forms\Components\Placeholder::make('meta_title_length')
                            ->label('Meta Title Length')
                            ->content(function (callable $get) {
                                $length = strlen($get('meta_title') ?? '');
                                $color = $length > 60 ? 'danger' : ($length > 50 ? 'warning' : 'success');
                                return new \Illuminate\Support\HtmlString(
                                    "<span class='text-{$color}-600 font-medium'>{$length}/60 characters</span>"
                                );
                            }),

                        Forms\Components\Textarea::make('meta_description')
                            ->label('Meta Description')
                            ->maxLength(160)
                            ->placeholder('Brief description for search engines')
                            ->helperText('Recommended: 150-160 characters. Will auto-generate from excerpt if empty.')
                            ->rows(3)
                            ->live()
                            ->afterStateUpdated(function ($state, callable $set) {
                                $set('meta_description_length', strlen($state ?? ''));
                            })
                            ->columnSpanFull(),

                        Forms\Components\Placeholder::make('meta_description_length')
                            ->label('Meta Description Length')
                            ->content(function (callable $get) {
                                $length = strlen($get('meta_description') ?? '');
                                $color = $length > 160 ? 'danger' : ($length > 150 ? 'warning' : 'success');
                                return new \Illuminate\Support\HtmlString(
                                    "<span class='text-{$color}-600 font-medium'>{$length}/160 characters</span>"
                                );
                            }),

                        Forms\Components\Textarea::make('meta_keywords')
                            ->label('Meta Keywords')
                            ->placeholder('Enter keywords separated by commas')
                            ->helperText('Add relevant keywords separated by commas (e.g., event name, location, type)')
                            ->rows(2)
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('featured_image')
                    ->disk('spaces')
                    ->size(60)
                    ->square(),

                Tables\Columns\TextColumn::make('eventType.name')
                    ->badge()
                    ->color('primary')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(50),

                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->sortable()
                    ->limit(30)
                    ->color('gray'),

                Tables\Columns\TextColumn::make('excerpt')
                    ->limit(60)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 60) {
                            return null;
                        }
                        return $state;
                    }),

                Tables\Columns\IconColumn::make('video')
                    ->boolean()
                    ->getStateUsing(function ($record) {
                        return !empty($record->video);
                    })
                    ->trueIcon('heroicon-o-play-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('gray')
                    ->label('Video')
                    ->tooltip(function ($record) {
                        return !empty($record->video)
                            ? 'Video: ' . basename($record->video)
                            : 'No video uploaded';
                    }),

                Tables\Columns\IconColumn::make('has_meta_description')
                    ->label('SEO')
                    ->boolean()
                    ->getStateUsing(fn($record) => !empty($record->meta_description))
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('gray')
                    ->tooltip(function ($record) {
                        return !empty($record->meta_description)
                            ? 'SEO configured'
                            : 'SEO not configured';
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('event_type_id')
                    ->relationship('eventType', 'name')
                    ->searchable()
                    ->preload()
                    ->label('Event Type'),

                Tables\Filters\Filter::make('has_video')
                    ->query(function ($query) {
                        return $query->whereNotNull('video');
                    })
                    ->label('Has Video'),

                Tables\Filters\Filter::make('has_gallery')
                    ->query(function ($query) {
                        return $query->whereNotNull('image_gallery');
                    })
                    ->label('Has Gallery'),

                Tables\Filters\Filter::make('has_images')
                    ->query(function ($query) {
                        return $query->where('image_gallery', '!=', '[]')
                            ->whereNotNull('image_gallery');
                    })
                    ->label('Has Images'),

                Tables\Filters\Filter::make('has_meta_description')
                    ->query(function ($query) {
                        return $query->whereNotNull('meta_description');
                    })
                    ->label('Has SEO'),

                Tables\Filters\Filter::make('missing_meta_description')
                    ->query(function ($query) {
                        return $query->whereNull('meta_description');
                    })
                    ->label('Missing SEO'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'view' => Pages\ViewEvent::route('/{record}'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }
}