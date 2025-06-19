<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactInquiryResource\Pages;
use App\Models\ContactInquiry;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Notifications\Notification;

class ContactInquiryResource extends Resource
{
    protected static ?string $model = ContactInquiry::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static ?string $navigationGroup = 'Inquiries';

    protected static ?string $navigationLabel = 'Contact Inquiries';

    protected static ?string $pluralModelLabel = 'Contact Inquiries';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Contact Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->disabled(),

                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->disabled(),

                        Forms\Components\TextInput::make('phone')
                            ->tel()
                            ->disabled(),

                        Forms\Components\TextInput::make('service_name')
                            ->label('Service/Event Type')
                            ->disabled(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Message')
                    ->schema([
                        Forms\Components\Textarea::make('message')
                            ->required()
                            ->disabled()
                            ->rows(5)
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Status & Notes')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->options([
                                'new' => 'New',
                                'read' => 'Read',
                                'replied' => 'Replied',
                                'archived' => 'Archived',
                            ])
                            ->required()
                            ->native(false),

                        Forms\Components\Textarea::make('admin_notes')
                            ->label('Internal Notes')
                            ->rows(3)
                            ->columnSpanFull()
                            ->placeholder('Add any internal notes about this inquiry...'),
                    ]),

                Forms\Components\Section::make('System Information')
                    ->schema([
                        Forms\Components\TextInput::make('ip_address')
                            ->label('IP Address')
                            ->disabled(),

                        Forms\Components\TextInput::make('user_agent')
                            ->label('User Agent')
                            ->disabled()
                            ->columnSpanFull(),

                        Forms\Components\Placeholder::make('created_at')
                            ->label('Submitted at')
                            ->content(fn ($record): string => $record?->created_at?->format('F j, Y - g:i A') ?? '-'),

                        Forms\Components\Placeholder::make('read_at')
                            ->label('Read at')
                            ->content(fn ($record): string => $record?->read_at?->format('F j, Y - g:i A') ?? 'Not read yet'),

                        Forms\Components\Placeholder::make('replied_at')
                            ->label('Replied at')
                            ->content(fn ($record): string => $record?->replied_at?->format('F j, Y - g:i A') ?? 'Not replied yet'),
                    ])
                    ->columns(3)
                    ->collapsed(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'danger' => 'new',
                        'warning' => 'read',
                        'success' => 'replied',
                        'gray' => 'archived',
                    ])
                    ->icons([
                        'heroicon-o-envelope' => 'new',
                        'heroicon-o-eye' => 'read',
                        'heroicon-o-check-circle' => 'replied',
                        'heroicon-o-archive-box' => 'archived',
                    ]),

                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('medium'),

                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Email copied!')
                    ->icon('heroicon-m-envelope'),

                Tables\Columns\TextColumn::make('phone')
                    ->searchable()
                    ->toggleable()
                    ->copyable()
                    ->placeholder('No phone'),

                Tables\Columns\TextColumn::make('service_name')
                    ->label('Service')
                    ->sortable()
                    ->toggleable()
                    ->wrap(),

                Tables\Columns\TextColumn::make('message')
                    ->limit(50)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        return strlen($state) > 50 ? $state : null;
                    })
                    ->wrap(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Submitted')
                    ->dateTime()
                    ->sortable()
                    ->since(),

                Tables\Columns\TextColumn::make('replied_at')
                    ->label('Replied')
                    ->dateTime()
                    ->sortable()
                    ->since()
                    ->placeholder('Not replied')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'new' => 'New',
                        'read' => 'Read',
                        'replied' => 'Replied',
                        'archived' => 'Archived',
                    ])
                    ->default('new'),

                Tables\Filters\Filter::make('not_archived')
                    ->label('Hide Archived')
                    ->query(fn (Builder $query): Builder => $query->where('status', '!=', 'archived'))
                    ->default(true),

                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label('From'),
                        Forms\Components\DatePicker::make('created_until')
                            ->label('Until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('mark_read')
                    ->label('Mark as Read')
                    ->icon('heroicon-o-eye')
                    ->color('warning')
                    ->visible(fn ($record) => $record->status === 'new')
                    ->action(function ($record) {
                        $record->markAsRead();
                        Notification::make()
                            ->title('Marked as read')
                            ->success()
                            ->send();
                    }),

                Tables\Actions\Action::make('mark_replied')
                    ->label('Mark as Replied')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn ($record) => in_array($record->status, ['new', 'read']))
                    ->action(function ($record) {
                        $record->markAsReplied();
                        Notification::make()
                            ->title('Marked as replied')
                            ->success()
                            ->send();
                    }),

                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('mark_read')
                        ->label('Mark as Read')
                        ->icon('heroicon-o-eye')
                        ->color('warning')
                        ->action(function ($records) {
                            $records->each->markAsRead();
                            Notification::make()
                                ->title('Inquiries marked as read')
                                ->success()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion(),
                    Tables\Actions\BulkAction::make('archive')
                        ->label('Archive')
                        ->icon('heroicon-o-archive-box')
                        ->color('gray')
                        ->action(function ($records) {
                            $records->each->archive();
                            Notification::make()
                                ->title('Inquiries archived')
                                ->success()
                                ->send();
                        })
                        ->requiresConfirmation()
                        ->deselectRecordsAfterCompletion(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->poll('60s');
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
            'index' => Pages\ListContactInquiries::route('/'),
            'create' => Pages\CreateContactInquiry::route('/create'),
            'view' => Pages\ViewContactInquiry::route('/{record}'),
            'edit' => Pages\EditContactInquiry::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'new')->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->latest();
    }
}