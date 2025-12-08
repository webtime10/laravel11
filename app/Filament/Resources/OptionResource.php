<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OptionResource\Pages;
use App\Filament\Resources\OptionResource\RelationManagers\ValuesRelationManager;
use App\Models\Option;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class OptionResource extends Resource
{
    protected static ?string $model = Option::class;

    protected static ?string $navigationGroup = 'Каталог';
    protected static ?string $navigationIcon  = 'heroicon-o-adjustments-vertical';
    protected static ?string $navigationLabel = 'Опции';
    protected static ?string $slug            = 'options';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Опция')
                ->columns(3)
                ->schema([
                    Forms\Components\Select::make('type')
                        ->label('Тип')
                        ->required()
                        ->options([
                            'select'   => 'select',
                            'radio'    => 'radio',
                            'checkbox' => 'checkbox',
                            'text'     => 'text',
                            'textarea' => 'textarea',
                            'file'     => 'file',
                            'date'     => 'date',
                            'time'     => 'time',
                            'datetime' => 'datetime',
                        ]),
                    Forms\Components\TextInput::make('sort_order')
                        ->numeric()->default(0)->label('Сортировка'),
                    Forms\Components\Toggle::make('status')
                        ->label('Включено')->default(true),
                ]),

            Forms\Components\Section::make('Название')
                ->relationship('description') // hasOne OptionDescription
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('name_1')
                        ->label('Название 1')->required()->maxLength(64),
                    Forms\Components\TextInput::make('name_2')
                        ->label('Название 2')->maxLength(64),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('description.name_1')
                    ->label('Название')->searchable()->sortable(),
                Tables\Columns\BadgeColumn::make('type')
                    ->label('Тип')->colors(['primary'])->sortable()->toggleable(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Сорт.')->sortable(),
                Tables\Columns\IconColumn::make('status')
                    ->boolean()->label('Статус'),
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

    /** Relation managers на вкладке Edit */
    public static function getRelations(): array
    {
        return [
            ValuesRelationManager::class, // значения опции
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListOptions::route('/'),
            'create' => Pages\CreateOption::route('/create'),
            'edit'   => Pages\EditOption::route('/{record}/edit'),
        ];
    }
}
