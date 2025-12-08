<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AttributeGroupResource\Pages;
use App\Models\AttributeGroup;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AttributeGroupResource extends Resource
{
    protected static ?string $model = AttributeGroup::class;

    protected static ?string $navigationGroup = 'Каталог';
    protected static ?string $navigationIcon  = 'heroicon-o-folder';
    protected static ?string $navigationLabel = 'Группы атрибутов';
    protected static ?string $slug            = 'attribute-groups';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Группа')
                ->schema([
                    Forms\Components\TextInput::make('sort_order')
                        ->numeric()
                        ->required()
                        ->default(0)
                        ->label('Сортировка'),
                ]),
            Forms\Components\Section::make('Название')
                ->relationship('description')
                ->schema([
                    Forms\Components\TextInput::make('name_1')
                        ->label('Название 1')
                        ->required()
                        ->maxLength(64),
                    Forms\Components\TextInput::make('name_2')
                        ->label('Название 2')
                        ->maxLength(64),
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
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Сорт.')
                    ->sortable(),
            ])
            ->defaultSort('sort_order')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListAttributeGroups::route('/'),
            'create' => Pages\CreateAttributeGroup::route('/create'),
            'edit'   => Pages\EditAttributeGroup::route('/{record}/edit'),
        ];
    }
}
