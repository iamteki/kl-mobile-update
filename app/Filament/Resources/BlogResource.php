<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlogResource\Pages;
use App\Models\Blog;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\RichEditor;

class BlogResource extends Resource
{
    protected static ?string $model = Blog::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Blog Management';

    protected static ?string $navigationLabel = 'Blogs';

    protected static ?string $pluralModelLabel = 'Blog Posts';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Basic Information')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Enter blog post title')
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $context, $state, callable $set, callable $get) {
                                if ($context === 'create') {
                                    $set('slug', \Illuminate\Support\Str::slug($state));
                                    
                                    if (empty($get('meta_title'))) {
                                        $set('meta_title', $state);
                                    }
                                }
                            }),

                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->readOnly()
                            ->unique(ignoreRecord: true)
                            ->placeholder('Auto-generated from title')
                            ->helperText('Will be auto-generated from title if left empty')
                            ->rules(['regex:/^[a-z0-9-]+$/'])
                            ->validationMessages([
                                'regex' => 'The slug can only contain lowercase letters, numbers, and hyphens.',
                            ]),

                        Forms\Components\Textarea::make('excerpt')
                            ->placeholder('Brief description of the blog post (optional)')
                            ->rows(3)
                            ->helperText('This will be shown in blog listings and can be used for SEO')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Content')
                    ->schema([
                        RichEditor::make('content')
                            ->required()
                            ->placeholder('Write your blog post content here...')
                            ->toolbarButtons([
                                'blockquote',
                                'bold',
                                'bulletList',
                                'codeBlock',
                                'h2',
                                'h3',
                                'h4',
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

                Forms\Components\Section::make('Media & Author')
                    ->schema([
                        Forms\Components\FileUpload::make('featured_image')
                            ->label('Featured Image')
                            ->image()
                            ->directory('blog-images')
                            ->disk('public')
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '16:9',
                                '4:3',
                                '1:1',
                            ])
                            ->maxSize(5120) // 5MB max
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->helperText('Upload featured image for the blog post (max 5MB)'),

                        Forms\Components\Select::make('user_id')
                            ->label('Author')
                            ->options(User::pluck('name', 'id'))
                            ->default(auth()->id())
                            ->required()
                            ->searchable()
                            ->preload(),

                        Forms\Components\Select::make('category_id')
                            ->label('Category')
                            ->options(\App\Models\Category::where('status', true)->pluck('name', 'id'))
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\ColorPicker::make('color')
                                    ->default('#3B82F6'),
                            ])
                            ->createOptionUsing(function (array $data): int {
                                return \App\Models\Category::create([
                                    'name' => $data['name'],
                                    'slug' => \Illuminate\Support\Str::slug($data['name']),
                                    'color' => $data['color'] ?? '#3B82F6',
                                    'status' => true,
                                ])->getKey();
                            }),

                        Forms\Components\TextInput::make('reading_time')
                            ->label('Reading Time (minutes)')
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(60)
                            ->step(1)
                            ->placeholder('Auto-calculated from content')
                            ->helperText('Leave empty to auto-calculate from word count'),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('Publishing & Settings')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->options([
                                'draft' => 'Draft',
                                'published' => 'Published',
                                'archived' => 'Archived',
                            ])
                            ->default('draft')
                            ->required()
                            ->native(false),



                        Forms\Components\Toggle::make('is_featured')
                            ->label('Featured Post')
                            ->helperText('Featured posts appear prominently on the website'),

                        Forms\Components\TextInput::make('order')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->step(1)
                            ->helperText('Lower numbers appear first'),

                        Forms\Components\TagsInput::make('tags')
                            ->placeholder('Add tags and press Enter')
                            ->helperText('Add relevant tags for this blog post')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('SEO Settings')
                    ->description('Configure SEO meta tags for better search engine visibility')
                    ->icon('heroicon-o-magnifying-glass')
                    ->compact()
                    ->schema([
                        Forms\Components\TextInput::make('meta_title')
                            ->label('Meta Title')
                            ->maxLength(60)
                            ->placeholder('Custom meta title (leave empty to use blog title)')
                            ->helperText('Recommended: 50-60 characters')
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
                            ->helperText('Recommended: 150-160 characters. Will use excerpt if empty.')
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
                            ->helperText('Add relevant keywords separated by commas')
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
                    ->label('Image')
                    ->circular()
                    ->size(40)
                    ->defaultImageUrl('https://via.placeholder.com/40x40/E5E7EB/9CA3AF?text=No+Image'),

                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(50)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        return strlen($state) > 50 ? $state : null;
                    }),

                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->copyable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Author')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('category.name')
                    ->label('Category')
                    ->badge()
                    ->color(fn ($record) => $record->category?->color ?? 'gray')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\SelectColumn::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                        'archived' => 'Archived',
                    ])
                    ->selectablePlaceholder(false),

                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Featured')
                    ->boolean()
                    ->trueIcon('heroicon-o-star')
                    ->falseIcon('heroicon-o-star')
                    ->trueColor('warning')
                    ->falseColor('gray'),

                Tables\Columns\TextColumn::make('reading_time')
                    ->label('Read Time')
                    ->formatStateUsing(fn ($state) => $state . ' min')
                    ->alignCenter()
                    ->sortable(),

                Tables\Columns\TextColumn::make('views')
                    ->alignCenter()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('published_at')
                    ->label('Published')
                    ->dateTime('M d, Y')
                    ->sortable()
                    ->placeholder('Not published'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                        'archived' => 'Archived',
                    ]),

                Tables\Filters\Filter::make('featured')
                    ->label('Featured Posts')
                    ->query(fn (Builder $query): Builder => $query->where('is_featured', true)),

                Tables\Filters\SelectFilter::make('user_id')
                    ->label('Author')
                    ->options(User::pluck('name', 'id'))
                    ->searchable(),

                Tables\Filters\SelectFilter::make('category_id')
                    ->label('Category')
                    ->options(\App\Models\Category::where('status', true)->pluck('name', 'id'))
                    ->searchable(),

                Tables\Filters\Filter::make('published_this_month')
                    ->label('Published This Month')
                    ->query(fn (Builder $query): Builder => $query->whereMonth('published_at', now()->month)),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('publish')
                    ->icon('heroicon-o-eye')
                    ->color('success')
                    ->action(function (Blog $record) {
                        $record->update([
                            'status' => 'published',
                            'published_at' => $record->published_at ?? now(),
                        ]);
                    })
                    ->visible(fn (Blog $record) => $record->status !== 'published')
                    ->requiresConfirmation(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('publish')
                        ->label('Publish Selected')
                        ->icon('heroicon-o-eye')
                        ->color('success')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                $record->update([
                                    'status' => 'published',
                                    'published_at' => $record->published_at ?? now(),
                                ]);
                            });
                        })
                        ->requiresConfirmation()
                        ->deselectRecordsAfterCompletion(),
                    Tables\Actions\BulkAction::make('draft')
                        ->label('Move to Draft')
                        ->icon('heroicon-o-document')
                        ->color('warning')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                $record->update(['status' => 'draft']);
                            });
                        })
                        ->requiresConfirmation()
                        ->deselectRecordsAfterCompletion(),
                ]),
            ])
            ->reorderable('order')
            ->groups([
                Tables\Grouping\Group::make('status')
                    ->collapsible(),
                Tables\Grouping\Group::make('user.name')
                    ->label('Author')
                    ->collapsible(),
            ]);
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
            'index' => Pages\ListBlogs::route('/'),
            'create' => Pages\CreateBlog::route('/create'),
            'view' => Pages\ViewBlog::route('/{record}'),
            'edit' => Pages\EditBlog::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'published')->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'success';
    }
}