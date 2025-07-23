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
use Illuminate\Database\Eloquent\Builder;

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
                            ->helperText('Will be auto-generated from title if left empty'),

                        Forms\Components\TextInput::make('video_title')
                            ->maxLength(255)
                            ->placeholder('Optional video title'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Content')
                    ->schema([
                        Forms\Components\Textarea::make('excerpt')
                            ->placeholder('Brief excerpt or summary of the event')
                            ->rows(3)
                            ->columnSpanFull(),

                        Forms\Components\RichEditor::make('description')
                            ->placeholder('Detailed description of the event')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Media')
                    ->schema([
                        Forms\Components\FileUpload::make('featured_image')
                            ->image()
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('16:9')
                            ->imageResizeTargetWidth('1920')
                            ->imageResizeTargetHeight('1080')
                            ->directory('events/featured')
                            ->visibility('public')
                            ->columnSpan(1),

                        Forms\Components\TextInput::make('video')
                            ->url()
                            ->placeholder('YouTube or Vimeo video URL')
                            ->columnSpan(1),

                        Forms\Components\FileUpload::make('image_gallery')
                            ->multiple()
                            ->image()
                            ->imageResizeMode('cover')
                            ->imageResizeTargetWidth('1200')
                            ->imageResizeTargetHeight('800')
                            ->directory('events/gallery')
                            ->visibility('public')
                            ->reorderable()
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

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
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\ImageColumn::make('featured_image')
                    ->label('Image')
                    ->size(40)
                    ->square(),

                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->weight('medium'),

                Tables\Columns\TextColumn::make('eventType.name')
                    ->label('Event Type')
                    ->badge()
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->color('gray')
                    ->copyable()
                    ->copyMessage('Slug copied!')
                    ->copyMessageDuration(1500),

                Tables\Columns\IconColumn::make('has_video')
                    ->label('Video')
                    ->boolean()
                    ->getStateUsing(fn($record) => !empty($record->video)),

                Tables\Columns\IconColumn::make('has_gallery')
                    ->label('Gallery')
                    ->boolean()
                    ->getStateUsing(fn($record) => !empty($record->image_gallery)),

                Tables\Columns\IconColumn::make('has_meta_description')
                    ->label('SEO')
                    ->boolean()
                    ->getStateUsing(fn($record) => !empty($record->meta_description)),

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
                    ->label('Event Type'),

                Tables\Filters\Filter::make('has_video')
                    ->label('Has Video')
                    ->query(fn(Builder $query): Builder => $query->whereNotNull('video')),

                Tables\Filters\Filter::make('has_gallery')
                    ->label('Has Gallery')
                    ->query(fn(Builder $query): Builder => $query->whereNotNull('image_gallery')),

                Tables\Filters\Filter::make('has_meta_description')
                    ->label('Has Meta Description')
                    ->query(fn(Builder $query): Builder => $query->whereNotNull('meta_description')),

                Tables\Filters\Filter::make('missing_meta_description')
                    ->label('Missing Meta Description')
                    ->query(fn(Builder $query): Builder => $query->whereNull('meta_description')),
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