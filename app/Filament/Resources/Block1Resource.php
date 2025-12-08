<?php

namespace App\Filament\Resources;

use App\Filament\Resources\Block1Resource\Pages;
use App\Models\Block1;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class Block1Resource extends Resource
{
    protected static ?string $model = Block1::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo'; // иконка меню
    protected static ?string $navigationLabel = 'Block1';
    protected static ?string $pluralLabel = 'Block1 записи';
    protected static ?string $modelLabel = 'Block1 запись';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name1')
                    ->label('Имя 1')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('name2')
                    ->label('Имя 2')
                    ->maxLength(255),

                Forms\Components\RichEditor::make('content')
                ->label('Контент')
                ->toolbarButtons([
                    'bold', 'italic', 'underline', 'strike',
                    'link', 'blockquote', 'codeBlock',
                    'h2', 'h3',
                    'orderedList', 'bulletList',
                    'undo', 'redo',
                ])
                // ↓ если хочешь загружать картинки прямо в текст редактора:
                ->fileAttachmentsDisk('public')
                ->fileAttachmentsDirectory('block1/inline')
                ->columnSpanFull(),

                Forms\Components\FileUpload::make('image1')
                    ->label('Картинка 1')
                    ->image()
                    ->disk('public')
                    ->directory('block1')
                    ->required(false),

                Forms\Components\FileUpload::make('image2')
                    ->label('Картинка 2')
                    ->image()
                    ->disk('public')
                    ->directory('block1')
                    ->required(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable()->label('ID'),
                Tables\Columns\TextColumn::make('name1')->label('Имя 1')->searchable(),
                Tables\Columns\TextColumn::make('name2')->label('Имя 2')->searchable(),
                Tables\Columns\ImageColumn::make('image1')
                    ->label('Картинка 1')
                    ->disk('public')
                    ->height(50),
                Tables\Columns\ImageColumn::make('image2')
                    ->label('Картинка 2')
                    ->disk('public')
                    ->height(50),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListBlock1s::route('/'),
            'create' => Pages\CreateBlock1::route('/create'),
            'edit'   => Pages\EditBlock1::route('/{record}/edit'),
        ];
    }
}
