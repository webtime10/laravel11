<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Manufacturer;
use App\Models\Option;
use App\Models\OptionValue;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationGroup = 'Каталог';
    protected static ?string $navigationIcon  = 'heroicon-o-archive-box';
    protected static ?string $navigationLabel = 'Товары';
    protected static ?string $slug            = 'products';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Tabs::make('productTabs')->tabs([

                /* ========= ОПИСАНИЕ ========= */
                Forms\Components\Tabs\Tab::make('Описание')->schema([
                    Forms\Components\Section::make('Описание и SEO')
                        ->relationship('description')
                        ->columns(['default' => 1, 'lg' => 2])
                        ->schema([
                            Forms\Components\Tabs::make('descLangTabs')->tabs([
                                Forms\Components\Tabs\Tab::make('1')->schema([
                                    Forms\Components\TextInput::make('name_1')->label('Название 1')->required()->maxLength(255),
                                    Forms\Components\TextInput::make('meta_title_1')->label('Meta title 1'),
                                    Forms\Components\TextInput::make('meta_description_1')->label('Meta description 1'),
                                    Forms\Components\TextInput::make('meta_keyword_1')->label('Meta keywords 1'),
                                    Forms\Components\RichEditor::make('description_1')->label('Описание 1')->columnSpanFull(),
                                ]),
                                Forms\Components\Tabs\Tab::make('2')->schema([
                                    Forms\Components\TextInput::make('name_2')->label('Название 2'),
                                    Forms\Components\TextInput::make('meta_title_2')->label('Meta title 2'),
                                    Forms\Components\TextInput::make('meta_description_2')->label('Meta description 2'),
                                    Forms\Components\TextInput::make('meta_keyword_2')->label('Meta keywords 2'),
                                    Forms\Components\RichEditor::make('description_2')->label('Описание 2')->columnSpanFull(),
                                ]),
                            ])->columnSpanFull(),
                        ]),
                ]),

                /* ========= ОСНОВНОЕ ========= */
                Forms\Components\Tabs\Tab::make('Основное')->schema([
                    Forms\Components\Grid::make()->columns(['default' => 1, 'lg' => 1])->schema([
                        Forms\Components\TextInput::make('model')->label('Model')->maxLength(64),
                        Forms\Components\TextInput::make('sku')->label('SKU')->maxLength(222)->unique('products', 'sku', ignoreRecord: true),
                        Forms\Components\TextInput::make('upc')->label('UPC')->maxLength(12)->unique('products', 'upc', ignoreRecord: true),

                        Forms\Components\Select::make('manufacturer_id')
                            ->label('Производитель')
                            ->relationship('manufacturer', 'manufacturer_id')
                            ->getOptionLabelFromRecordUsing(
                                fn (Manufacturer $record) => $record->description?->name_1 ?? '—'
                            )
                            ->searchable()
                            ->preload()
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('price')->numeric()->label('Цена'),
                        Forms\Components\TextInput::make('quantity')->numeric()->default(0)->label('Кол-во'),
                        Forms\Components\TextInput::make('stock_status_id')->numeric()->label('ID статуса наличия'),

                        Forms\Components\Toggle::make('subtract')->label('Вычитать со склада')->default(true),
                        Forms\Components\TextInput::make('minimum')->numeric()->default(1)->label('Мин. заказ'),
                        Forms\Components\TextInput::make('sort_order')->numeric()->default(0)->label('Сортировка'),
                        Forms\Components\Toggle::make('noindex')->label('Noindex')->default(false),
                    ]),
                ]),

                /* ========= ИЗОБРАЖЕНИЯ ========= */
                Forms\Components\Tabs\Tab::make('Изображения')->schema([
                    Forms\Components\Section::make('Главные изображения')
                        ->columns(['default' => 1, 'lg' => 1])
                        ->schema([
                            Forms\Components\FileUpload::make('image')->label('Основное')->image()->directory('products'),
                            Forms\Components\TextInput::make('alt')->label('ALT'),
                            Forms\Components\FileUpload::make('image1')->label('Изображение 1')->image()->directory('products'),
                            Forms\Components\TextInput::make('alt1')->label('ALT 1'),
                            Forms\Components\FileUpload::make('image2')->label('Изображение 2')->image()->directory('products'),
                            Forms\Components\TextInput::make('alt2')->label('ALT 2'),
                            Forms\Components\FileUpload::make('image3')->label('Изображение 3')->image()->directory('products'),
                            Forms\Components\TextInput::make('alt3')->label('ALT 3'),
                        ]),

                    Forms\Components\Section::make('Галерея (много фото)')
                        ->description('Нажми «Добавить» чтобы прикрепить ещё изображения')
                        ->schema([
                            Forms\Components\Repeater::make('productImages')
                                ->relationship('productImages')
                                ->defaultItems(0)
                                ->reorderable(true)
                                ->collapsed()
                                ->schema([
                                    Forms\Components\FileUpload::make('image')
                                        ->label('Изображение')->image()->directory('products')->required(),
                                    Forms\Components\TextInput::make('sort_order')
                                        ->numeric()->default(0)->label('Сортировка'),
                                ])
                                ->createItemButtonLabel('Добавить изображение')
                                ->grid(1),
                        ]),
                ]),

                /* ========= АТРИБУТЫ ========= */
                Forms\Components\Tabs\Tab::make('Атрибуты')->schema([
                    Forms\Components\Repeater::make('productAttributes')
                        ->relationship('productAttributes')
                        ->defaultItems(0)
                        ->reorderable(false)
                        ->schema([
                            Forms\Components\Select::make('attribute_id')
                                ->label('Атрибут')
                                ->relationship('attribute', 'attribute_id')
                                ->getOptionLabelFromRecordUsing(
                                    fn (Attribute $record) => $record->description?->name_1 ?? ('#' . $record->attribute_id)
                                )
                                ->searchable()
                                ->preload()
                                ->required(),
                            Forms\Components\TextInput::make('text_1')->label('Значение 1'),
                            Forms\Components\TextInput::make('text_2')->label('Значение 2'),
                        ])
                        ->createItemButtonLabel('Добавить атрибут')
                        ->grid(1),
                ]),

                /* ========= ОПЦИИ ========= */
                Forms\Components\Tabs\Tab::make('Опции')->schema([
                    Forms\Components\Repeater::make('productOptions')
                        ->relationship('productOptions')
                        ->defaultItems(0)
                        ->reorderable(true)
                        ->schema([
                            Forms\Components\Hidden::make('product_option_id'),

                            Forms\Components\Grid::make()->columns(3)->schema([
                                Forms\Components\Select::make('option_id')
                                    ->label('Опция')
                                    ->relationship('option', 'option_id')
                                    ->getOptionLabelFromRecordUsing(
                                        fn (Option $record) => $record->description?->name_1 ?? ('#' . $record->option_id)
                                    )
                                    ->searchable()
                                    ->preload()
                                    ->reactive()
                                    ->required()
                                    ->afterStateUpdated(function ($state, Get $get, Set $set) {
                                        $currentId = $get('product_option_id');
                                        $rows = collect($get('../../productOptions') ?? []);
                                        $duplicate = $rows->first(function ($row) use ($state, $currentId) {
                                            $rowOption = $row['option_id'] ?? null;
                                            $rowId     = $row['product_option_id'] ?? null;
                                            return $rowOption == $state && $rowId !== $currentId;
                                        });

                                        if ($duplicate) {
                                            $set('option_id', null);
                                            Notification::make()
                                                ->title('Эта опция уже добавлена — добавляйте варианты в блоке «Значения» у той опции.')
                                                ->warning()
                                                ->send();
                                        }
                                    }),

                                Forms\Components\Toggle::make('required')->label('Обязательная')->default(false),

                                Forms\Components\TextInput::make('value')
                                    ->label('Значение')
                                    ->visible(function (Get $get) {
                                        $opt = $get('option_id') ? Option::find($get('option_id')) : null;
                                        return in_array($opt?->type, ['text','textarea','date','time','datetime']);
                                    })
                                    ->columnSpan(3),
                            ]),

                            Forms\Components\Repeater::make('values')
                                ->relationship('values')
                                ->visible(function (Get $get) {
                                    $opt = $get('option_id') ? Option::find($get('option_id')) : null;
                                    return in_array($opt?->type, ['select','radio','checkbox','image']);
                                })
                                ->defaultItems(0)
                                ->reorderable(true)
                                ->schema([
                                    Forms\Components\Grid::make()->columns(6)->schema([
                                        Forms\Components\Select::make('option_value_id')
                                            ->label('Значение опции')
                                            ->searchable()
                                            ->preload()
                                            ->options(function (Get $get) {
                                                $optionId = $get('../../option_id');
                                                if (!$optionId) return [];
                                                return OptionValue::query()
                                                    ->where('option_id', $optionId)
                                                    ->with('description')
                                                    ->get()
                                                    ->mapWithKeys(fn (OptionValue $ov) => [
                                                        $ov->option_value_id => ($ov->description?->name_1 ?? ('#' . $ov->option_value_id)),
                                                    ])->toArray();
                                            })
                                            ->required()
                                            ->columnSpan(3),

                                        Forms\Components\TextInput::make('price')->label('Цена')->numeric()->default(0)->columnSpan(3),
                                        Forms\Components\Select::make('price_prefix')->label('±')
                                            ->options(['+' => '+', '-' => '-'])->default('+')->columnSpan(3),

                                        Forms\Components\TextInput::make('quantity')->numeric()->default(0)->columnSpan(3)->label('Кол-во'),
                                        Forms\Components\Toggle::make('subtract')->label('Вычитать')->default(false),
                                    ]),
                                ])
                                ->createItemButtonLabel('Добавить значение'),
                        ])
                        ->createItemButtonLabel('Добавить опцию')
                        ->grid(1),
                ]),

                /* ========= КАТЕГОРИИ ========= */
                Forms\Components\Tabs\Tab::make('Категории')->schema([
                    Forms\Components\Select::make('categories')
                        ->label('Категории')
                        ->multiple()
                        ->native(false)
                        ->preload()
                        ->searchable()
                        ->dehydrated(true) // явно сохраняем связь
                        ->relationship('categories', 'category_id')
                        ->getOptionLabelFromRecordUsing(
                            fn (Category $c) => $c->description?->name_1 ?? ('#' . $c->category_id)
                        )
                        ->afterStateUpdated(function (Get $get, Set $set) {
                            // если главная категория не входит в выбранные — сбросим её
                            $chosen = $get('categories') ?? [];
                            $main   = $get('main_category_id');
                            if ($main && ! in_array($main, $chosen, true)) {
                                $set('main_category_id', null);
                            }
                        })
                        ->helperText('Выбери одну или несколько категорий.'),

                    Forms\Components\Select::make('main_category_id')
                        ->label('Главная категория')
                        ->native(false)
                        ->options(function (Get $get) {
                            $ids = $get('categories') ?? [];
                            if (empty($ids)) return [];
                            return Category::query()
                                ->with('description')
                                ->whereIn('category_id', $ids)
                                ->get()
                                ->mapWithKeys(fn (Category $c) => [
                                    $c->category_id => ($c->description?->name_1 ?? ('#' . $c->category_id)),
                                ])->toArray();
                        })
                        ->disabled(fn (Get $get) => empty($get('categories')))
                        ->dehydrated(false) // это не колонка products — не сохраняем напрямую
                        ->helperText('Опционально: выбери одну из отмеченных выше.'),
                ]),
            ])->persistTabInQueryString(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')->label('Фото')->square(),
                Tables\Columns\TextColumn::make('description.name_1')->label('Название')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('model')->label('Модель')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('sku')->label('SKU')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('price')->label('Цена')->sortable(),
                Tables\Columns\TextColumn::make('quantity')->label('Кол-во')->sortable(),
                Tables\Columns\TextColumn::make('manufacturer.description.name_1')->label('Производитель')->toggleable(),
                Tables\Columns\TextColumn::make('sort_order')->label('Сорт.')->sortable(),
                Tables\Columns\IconColumn::make('noindex')->boolean()->label('Noindex'),
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

    public static function getRelations(): array
    {
        return [
            // RelationManager для категорий можно добавить позже
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit'   => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
