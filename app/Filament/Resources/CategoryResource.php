<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon  = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Контент';
    protected static ?string $navigationLabel = 'Категории';
    protected static ?string $slug            = 'categories';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Grid::make()->columns(12)->schema([
                // Основные поля
                Forms\Components\Section::make('Категория')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('slug')
                            ->label('Slug')
                            ->maxLength(255)
                            ->unique('categories', 'slug', ignoreRecord: true)
                            ->helperText('Оставь пустым — сгенерируется из «Название 1».')
                            ->suffixAction(
                                Action::make('regen')
                                    ->icon('heroicon-o-bolt')
                                    ->tooltip('Пересоздать из «Название 1»')
                                    ->action(function (Set $set, Get $get) {
                                        $name = $get('description.name_1');
                                        if ($name) {
                                            $set('slug', Str::slug($name));
                                        }
                                    })
                            ),

                        // Родитель: пусто = корень (0), выбранное значение = ID категории
                        Forms\Components\Select::make('parent_id')
                            ->label('Родитель')
                            ->placeholder('— корень —')
                            ->options(function (?Category $record) {
                                return Category::with('description')
                                    ->orderBy('sort_order')
                                    ->when(
                                        $record,
                                        fn ($q) => $q->where('category_id', '!=', $record->category_id) // исключаем саму себя
                                    )
                                    ->get()
                                    ->mapWithKeys(fn (Category $c) => [$c->category_id => $c->display_name])
                                    ->all();
                            })
                            ->searchable()
                            ->preload()
                            ->nullable()
                            ->default(null)
                            ->dehydrateStateUsing(fn ($state) => (int) ($state ?? 0)) // в БД 0, если пусто
                            // защита: не равен своему ID
                            ->rule(fn (?Category $record) => $record
                                ? Rule::notIn([$record->category_id])
                                : null
                            )
                            ->hint('Оставьте пустым, чтобы сделать корневой категорией.'),

                        Forms\Components\TextInput::make('sort_order')
                            ->numeric()
                            ->default(0)
                            ->label('Сортировка'),

                        Forms\Components\Toggle::make('status')
                            ->label('Включено')
                            ->default(true),
                    ])
                    ->columnSpan(8),

                // Изображения
                Forms\Components\Section::make('Изображения')
                    ->schema([
                        Forms\Components\FileUpload::make('image_1')
                            ->label('Изображение 1')
                            ->image()
                            ->directory('categories'),
                        Forms\Components\FileUpload::make('image_2')
                            ->label('Изображение 2')
                            ->image()
                            ->directory('categories'),
                    ])
                    ->columnSpan(4),

                // Описание (hasOne)
                Forms\Components\Section::make('Описание')
                    ->relationship('description')
                    ->schema([
                        Forms\Components\Tabs::make('descTabs')->tabs([
                            Forms\Components\Tabs\Tab::make('1')->schema([
                                Forms\Components\TextInput::make('name_1')
                                    ->label('Название 1')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (?string $state, Set $set) {
                                        if ($state) {
                                            $set('slug', Str::slug($state));
                                        }
                                    }),
                                Forms\Components\TextInput::make('meta_title_1')->label('Meta title 1'),
                                Forms\Components\TextInput::make('meta_description_1')->label('Meta description 1'),
                                Forms\Components\RichEditor::make('description_1')
                                    ->label('Описание 1')
                                    ->columnSpanFull(),
                            ]),
                            Forms\Components\Tabs\Tab::make('2')->schema([
                                Forms\Components\TextInput::make('name_2')->label('Название 2'),
                                Forms\Components\TextInput::make('meta_title_2')->label('Meta title 2'),
                                Forms\Components\TextInput::make('meta_description_2')->label('Meta description 2'),
                                Forms\Components\RichEditor::make('description_2')
                                    ->label('Описание 2')
                                    ->columnSpanFull(),
                            ]),
                        ])->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('description.name_1')
                    ->label('Название')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('parent.description.name_1')
                    ->label('Родитель')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Сорт.')
                    ->sortable(),
                Tables\Columns\IconColumn::make('status')
                    ->boolean()
                    ->label('Статус'),
                Tables\Columns\TextColumn::make('date_modified')
                    ->dateTime()
                    ->since()
                    ->label('Обновлено'),
            ])
            ->defaultSort('sort_order')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit'   => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
