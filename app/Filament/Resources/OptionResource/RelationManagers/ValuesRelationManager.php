<?php

namespace App\Filament\Resources\OptionResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ValuesRelationManager extends RelationManager
{
    protected static string $relationship = 'values'; // Option::values()

    protected static ?string $title = 'Значения опции';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Значение')
                ->columns(3)
                ->schema([
                    Forms\Components\FileUpload::make('image')
                        ->label('Изображение')
                        ->image()
                        ->directory('option-values'),

                    Forms\Components\TextInput::make('sort_order')
                        ->numeric()->default(0)->label('Сортировка'),
                ]),

            Forms\Components\Section::make('Название')
                ->relationship('description') // hasOne OptionValueDescription
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('name_1')
                        ->label('Название 1')->required()->maxLength(64),
                    Forms\Components\TextInput::make('name_2')
                        ->label('Название 2')->maxLength(64),
                ]),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('description.name_1')
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Картинка')
                    ->square()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('description.name_1')
                    ->label('Название')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Сорт.')->sortable(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
