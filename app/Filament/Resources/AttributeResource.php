<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AttributeResource\Pages;
use App\Models\Attribute;
use App\Models\AttributeGroup;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AttributeResource extends Resource
{
    protected static ?string $model = Attribute::class;

    protected static ?string $navigationGroup = 'Каталог';
    protected static ?string $navigationIcon  = 'heroicon-o-tag';
    protected static ?string $navigationLabel = 'Атрибуты';
    protected static ?string $slug            = 'attributes';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Атрибут')
                ->columns(2)
                ->schema([
                    // выбор группы как в OpenCart
                    Forms\Components\Select::make('attribute_group_id')
                        ->label('Группа')
                        ->options(
                            AttributeGroup::with('description')
                                ->orderBy('sort_order')
                                ->get()
                                ->mapWithKeys(fn ($g) => [
                                    $g->attribute_group_id => ($g->description->name_1 ?? ('Группа #'.$g->attribute_group_id)),
                                ])->all()
                        )
                        ->required()
                        ->searchable()
                        ->preload(),

                    Forms\Components\TextInput::make('sort_order')
                        ->label('Сортировка')
                        ->numeric()
                        ->required()
                        ->default(0),
                ]),

            // hasOne attribute_descriptions
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

                Tables\Columns\TextColumn::make('group.description.name_1')
                    ->label('Группа')
                    ->searchable(),

                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Сорт.')
                    ->sortable(),
            ])
            ->defaultSort('sort_order')
            ->filters([
                Tables\Filters\SelectFilter::make('attribute_group_id')
                    ->label('Группа')
                    ->options(
                        AttributeGroup::with('description')->orderBy('sort_order')->get()
                            ->mapWithKeys(fn ($g) => [
                                $g->attribute_group_id => ($g->description->name_1 ?? ('Группа #'.$g->attribute_group_id)),
                            ])->all()
                    ),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListAttributes::route('/'),
            'create' => Pages\CreateAttribute::route('/create'),
            'edit'   => Pages\EditAttribute::route('/{record}/edit'),
        ];
    }
}
