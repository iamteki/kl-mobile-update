<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventTypeResource\Pages;
use App\Models\EventType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class EventTypeResource extends Resource
{
    protected static ?string $model = EventType::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    
    protected static ?string $navigationGroup = 'Event Management';
    
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Event Type Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => 
                                $operation === 'create' ? $set('slug', Str::slug($state)) : null
                            ),
                        
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(EventType::class, 'slug', ignoreRecord: true)
                            ->helperText('URL-friendly version of the name'),
                        
                        Forms\Components\Textarea::make('description')
                            ->maxLength(65535)
                            ->columnSpanFull()
                            ->rows(3),
                        
                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true)
                            ->helperText('Only active event types will be displayed on the website'),
                    ])
                    ->columns(2),
                
                Forms\Components\Section::make('Image')
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->image()
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '1:1',  // Square ratio for your cards
                            ])
                            ->directory('event-types')
                            ->maxSize(2048)
                            ->helperText('Recommended size: 800x800px (Square). Max file size: 2MB')
                            ->columnSpanFull(),
                        
                        Forms\Components\TextInput::make('image_alt')
                            ->label('Image Alt Text')
                            ->maxLength(255)
                            ->helperText('Alternative text for the image (for SEO and accessibility)')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->square()
                    ->size(60)
                    ->defaultImageUrl(fn ($record) => 
                        'https://via.placeholder.com/60x60/1a1a1a/666666?text=' . urlencode(substr($record->name, 0, 1))
                    ),
                
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Slug copied!')
                    ->color('gray'),
                
                Tables\Columns\TextColumn::make('events_count')
                    ->counts('events')
                    ->label('Events')
                    ->sortable(),
                
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active'),
                
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
                Tables\Filters\SelectFilter::make('is_active')
                    ->options([
                        '1' => 'Active',
                        '0' => 'Inactive',
                    ])
                    ->label('Status'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation()
                    ->before(function (EventType $record) {
                        if ($record->events()->exists()) {
                            throw new \Exception('Cannot delete event type with associated events.');
                        }
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('name', 'asc');
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
            'edit' => Pages\EditEventType::route('/{record}/edit'),
        ];
    }
}