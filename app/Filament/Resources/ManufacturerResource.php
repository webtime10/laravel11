<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ManufacturerResource\Pages;
use App\Models\Manufacturer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ManufacturerResource extends Resource
{
    protected static ?string $model = Manufacturer::class;

    protected static ?string $navigationGroup = 'Каталог';
    protected static ?string $navigationIcon  = 'heroicon-o-building-storefront';
    protected static ?string $navigationLabel = 'Производители';
    protected static ?string $slug            = 'manufacturers';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Grid::make()->columns(12)->schema([
                Forms\Components\Section::make('Производитель')
                    ->columns(2)
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->label('Логотип')
                            ->image()
                            ->directory('manufacturers'),

                        Forms\Components\TextInput::make('sort_order')
                            ->numeric()->default(0)->label('Сортировка'),

                        Forms\Components\Toggle::make('status')
                            ->label('Включено')->default(true),

                        Forms\Components\Toggle::make('noindex')
                            ->label('Noindex')->default(false),
                    ])
                    ->columnSpan(4),

                Forms\Components\Section::make('Название и SEO')
                    ->relationship('description') // hasOne ManufacturerDescription
                    ->schema([
                        Forms\Components\Tabs::make('names')->tabs([
                            Forms\Components\Tabs\Tab::make('1')->schema([
                                Forms\Components\TextInput::make('name_1')
                                    ->label('Название 1')->required()->maxLength(255),
                                Forms\Components\TextInput::make('meta_title_1')->label('Meta title 1'),
                                Forms\Components\TextInput::make('meta_description_1')->label('Meta description 1'),
                                Forms\Components\TextInput::make('meta_keyword_1')->label('Meta keywords 1'),
                                Forms\Components\TextInput::make('meta_h1_1')->label('H1 1'),
                                Forms\Components\RichEditor::make('description_1')
                                    ->label('Описание 1')->columnSpanFull(),
                            ]),
                            Forms\Components\Tabs\Tab::make('2')->schema([
                                Forms\Components\TextInput::make('name_2')->label('Название 2'),
                                Forms\Components\TextInput::make('meta_title_2')->label('Meta title 2'),
                                Forms\Components\TextInput::make('meta_description_2')->label('Meta description 2'),
                                Forms\Components\TextInput::make('meta_keyword_2')->label('Meta keywords 2'),
                                Forms\Components\TextInput::make('meta_h1_2')->label('H1 2'),
                                Forms\Components\RichEditor::make('description_2')
                                    ->label('Описание 2')->columnSpanFull(),
                            ]),
                        ])->columnSpanFull(),
                    ])
                    ->columnSpan(8),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')->label('Лого')->square(),
                Tables\Columns\TextColumn::make('description.name_1')
                    ->label('Название')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('sort_order')->label('Сорт.')->sortable(),
                Tables\Columns\IconColumn::make('status')->boolean()->label('Статус'),
                Tables\Columns\IconColumn::make('noindex')->boolean()->label('Noindex'),
                Tables\Columns\TextColumn::make('date_modified')->since()->label('Обновлено')->toggleable(),
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
            'index'  => Pages\ListManufacturers::route('/'),
            'create' => Pages\CreateManufacturer::route('/create'),
            'edit'   => Pages\EditManufacturer::route('/{record}/edit'),
        ];
    }
}
