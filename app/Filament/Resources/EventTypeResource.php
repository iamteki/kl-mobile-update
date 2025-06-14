<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventTypeResource\Pages;
use App\Models\EventType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class EventTypeResource extends Resource
{
    protected static ?string $model = EventType::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationGroup = 'Event Management';

    protected static ?string $navigationLabel = 'Event Types';

    protected static ?string $pluralModelLabel = 'Event Types';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Basic Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->placeholder('Enter event type name')
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $context, $state, callable $set, callable $get) {
                                if ($context === 'create') {
                                    $set('slug', \Illuminate\Support\Str::slug($state));

                                    // Auto-generate meta title if empty
                                    if (empty($get('meta_title'))) {
                                        $set('meta_title', $state);
                                    }
                                }
                            }),

                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->readonly()
                            ->unique(ignoreRecord: true)
                            ->placeholder('Auto-generated from name')
                            ->helperText('Will be auto-generated from name if left empty')
                            ->rules(['regex:/^[a-z0-9-]+$/'])
                            ->validationMessages([
                                'regex' => 'The slug can only contain lowercase letters, numbers, and hyphens.',
                            ]),

                        Forms\Components\Textarea::make('description')
                            ->placeholder('Enter detailed description of this event type')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('SEO Settings')
                    ->schema([
                        Forms\Components\TextInput::make('meta_title')
                            ->label('Meta Title')
                            ->maxLength(60)
                            ->placeholder('Custom meta title (leave empty to use name)')
                            ->helperText('Recommended: 50-60 characters. Will use event type name if empty.')
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
                            ->helperText('Recommended: 150-160 characters. This appears in search results.')
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
                            ->helperText('Add relevant keywords separated by commas (e.g., conference, business, networking)')
                            ->rows(2)
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Forms\Components\Section::make('Settings')
                    ->schema([
                        Forms\Components\Toggle::make('status')
                            ->label('Active Status')
                            ->default(true)
                            ->helperText('Enable or disable this event type'),

                        Forms\Components\TextInput::make('order')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->step(1)
                            ->helperText('Lower numbers appear first'),
                    ])
                    ->columns(2),
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

                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('medium'),

                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->sortable()
                    ->color('gray')
                    ->copyable()
                    ->copyMessage('Slug copied!')
                    ->copyMessageDuration(1500),

                Tables\Columns\TextColumn::make('description')
                    ->limit(50)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        return strlen($state) > 50 ? $state : null;
                    })
                    ->toggleable(),

                Tables\Columns\TextColumn::make('meta_title')
                    ->label('Meta Title')
                    ->limit(30)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        return strlen($state) > 30 ? $state : null;
                    })
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('meta_description')
                    ->label('Meta Description')
                    ->limit(50)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        return strlen($state) > 50 ? $state : null;
                    })
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\IconColumn::make('status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->sortable(),

                Tables\Columns\TextColumn::make('order')
                    ->sortable()
                    ->alignCenter()
                    ->badge()
                    ->color('primary'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('order', 'asc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        true => 'Active',
                        false => 'Inactive',
                    ])
                    ->label('Status'),

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
                    Tables\Actions\BulkAction::make('activate')
                        ->label('Activate Selected')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                $record->update(['status' => true]);
                            });
                        })
                        ->requiresConfirmation()
                        ->deselectRecordsAfterCompletion(),
                    Tables\Actions\BulkAction::make('deactivate')
                        ->label('Deactivate Selected')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                $record->update(['status' => false]);
                            });
                        })
                        ->requiresConfirmation()
                        ->deselectRecordsAfterCompletion(),
                ]),
            ])
            ->reorderable('order')
            ->defaultSort('order');
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
            'index' => Pages\ListEventTypes::route('/'),
            'create' => Pages\CreateEventType::route('/create'),
            'view' => Pages\ViewEventType::route('/{record}'),
            'edit' => Pages\EditEventType::route('/{record}/edit'),
        ];
    }
}
