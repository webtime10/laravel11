<?php
namespace App\Filament\Resources;

use App\Filament\Resources\LanguageResource\Pages;
use App\Models\Language;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;

class LanguageResource extends Resource
{
    protected static ?string $model = Language::class;

    protected static ?string $navigationIcon = 'heroicon-o-language';
    protected static ?string $navigationLabel = 'Languages';
    protected static ?string $pluralLabel = 'Languages';
    protected static ?string $navigationGroup = 'Settings'; // можно сгруппировать меню

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')->required()->maxLength(32),
            Forms\Components\TextInput::make('code')->required()->maxLength(5),
            Forms\Components\TextInput::make('locale')->required()->maxLength(255),
            Forms\Components\TextInput::make('extension')->maxLength(255),
            Forms\Components\TextInput::make('lang')->numeric(),
            Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
            Forms\Components\Toggle::make('status'),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('language_id')->sortable(),
            Tables\Columns\TextColumn::make('name')->searchable(),
            Tables\Columns\TextColumn::make('code'),
            Tables\Columns\TextColumn::make('locale'),
            Tables\Columns\TextColumn::make('extension'),
            Tables\Columns\TextColumn::make('lang'),
            Tables\Columns\TextColumn::make('sort_order'),
            Tables\Columns\IconColumn::make('status')->boolean(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLanguages::route('/'),
            'create' => Pages\CreateLanguage::route('/create'),
            'edit' => Pages\EditLanguage::route('/{record}/edit'),
        ];
    }
}
