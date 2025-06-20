<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OfficeLocationResource\Pages;
use App\Models\OfficeLocation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class OfficeLocationResource extends Resource
{
    protected static ?string $model = OfficeLocation::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    protected static ?string $navigationGroup = 'Content Management';

    protected static ?int $navigationSort = 4;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Basic Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $context, $state, Forms\Set $set) {
                                if ($context === 'create') {
                                    $set('slug', Str::slug($state));
                                }
                            }),

                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->rules(['alpha_dash'])
                            ->helperText('URL-friendly version of the name'),

                        Forms\Components\TextInput::make('city')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('small_description')
                            ->required()
                            ->maxLength(255)
                            ->helperText('Brief description for listings'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Detailed Information')
                    ->schema([
                        Forms\Components\RichEditor::make('full_description')
                            ->required()
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'bulletList',
                                'orderedList',
                                'link',
                                'undo',
                                'redo',
                            ])
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('address')
                            ->required()
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Contact Information')
                    ->schema([
                        Forms\Components\TextInput::make('open_time')
                            ->required()
                            ->placeholder('e.g., Mon-Fri: 9:00 AM - 6:00 PM')
                            ->helperText('Business hours'),

                        Forms\Components\TextInput::make('phone')
                            ->tel()
                            ->placeholder('+1 (555) 123-4567'),

                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->placeholder('office@example.com'),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('Media & Location')
                    ->schema([
                        Forms\Components\FileUpload::make('image_gallery')
                            ->label('Photo Gallery')
                            ->image()
                            ->multiple()
                            ->disk('spaces')
                            ->directory('location/gallery')
                            ->visibility('public')
                            ->imageEditor()
                            ->reorderable()
                            ->maxFiles(10)
                            ->maxSize(5120)
                            ->imageEditorAspectRatios([
                                '16:9',
                                '4:3',
                                '1:1',
                            ])
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('google_map_iframe')
                            ->label('Google Maps Embed Code')
                            ->placeholder('<iframe src="https://www.google.com/maps/embed?pb=..." width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>')
                            ->helperText('Paste the Google Maps embed iframe code here')
                            ->rows(4)
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Settings')
                    ->schema([
                        Forms\Components\TextInput::make('sort_order')
                            ->numeric()
                            ->default(0)
                            ->helperText('Lower numbers appear first'),

                        Forms\Components\Toggle::make('is_active')
                            ->default(true)
                            ->helperText('Toggle to show/hide this location'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                

                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('medium'),

                Tables\Columns\TextColumn::make('city')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('primary'),

                Tables\Columns\TextColumn::make('small_description')
                    ->limit(40)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        return strlen($state) > 40 ? $state : null;
                    }),

                Tables\Columns\TextColumn::make('phone')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Phone number copied!')
                    ->icon('heroicon-o-phone'),

                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->sortable()
                    ->label('Active'),

                Tables\Columns\TextColumn::make('sort_order')
                    ->sortable()
                    ->label('Order'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('city')
                    ->options(function () {
                        return OfficeLocation::pluck('city', 'city')
                            ->unique()
                            ->sort();
                    }),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status')
                    ->placeholder('All Locations')
                    ->trueLabel('Active Locations')
                    ->falseLabel('Inactive Locations'),
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
                            $records->each->update(['is_active' => true]);
                        })
                        ->deselectRecordsAfterCompletion(),
                    Tables\Actions\BulkAction::make('deactivate')
                        ->label('Deactivate Selected')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->action(function ($records) {
                            $records->each->update(['is_active' => false]);
                        })
                        ->deselectRecordsAfterCompletion(),
                ]),
            ])
            ->defaultSort('sort_order', 'asc')
            ->reorderable('sort_order');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOfficeLocations::route('/'),
            'create' => Pages\CreateOfficeLocation::route('/create'),
            'view' => Pages\ViewOfficeLocation::route('/{record}'),
            'edit' => Pages\EditOfficeLocation::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'city', 'small_description'];
    }
}