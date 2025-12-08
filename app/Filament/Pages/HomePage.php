<?php

namespace App\Filament\Pages;

use App\Models\Home;
use Filament\Pages\Page;
use Filament\Forms\Form;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor; // ← добавили
use Filament\Notifications\Notification;

class HomePage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon  = 'heroicon-o-home';
    protected static ?string $navigationGroup = 'Контент';
    protected static ?string $navigationLabel = 'Home';
    protected static ?string $title           = 'Home — редактирование';
    protected static ?string $slug            = 'home';

    protected static string $view = 'filament.pages.home-page';

    /** Состояние формы */
    public ?array $data = [];

    public function mount(): void
    {
        // гарантируем, что запись существует и заполняем форму её данными
        $record = Home::first() ?? Home::create([
            'title'            => '',
            'meta_description' => null,
            'block_1'          => null,
            'block_2'          => null,
        ]);

        $this->form->fill($record->only([
            'title',
            'meta_description',
            'block_1',
            'block_2',
        ]));
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label('Title')
                    ->required()
                    ->maxLength(255),

                TextInput::make('meta_description')
                    ->label('Meta description')
                    ->maxLength(255)
                    ->helperText('До ~160 символов.'),

                RichEditor::make('block_1')
                    ->label('Блок 1')
                    ->toolbarButtons([
                        'bold', 'italic', 'strike',
                        'link', 'orderedList', 'bulletList',
                        'blockquote', 'codeBlock',
                        'h2', 'h3', 'hr', 'undo', 'redo',
                    ])
                    ->columnSpanFull(),

                RichEditor::make('block_2')
                    ->label('Блок 2')
                    ->toolbarButtons([
                        'bold', 'italic', 'strike',
                        'link', 'orderedList', 'bulletList',
                        'blockquote', 'codeBlock',
                        'h2', 'h3', 'hr', 'undo', 'redo',
                    ])
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $record = Home::first() ?? new Home();
        $record->fill($this->form->getState());
        $record->save();

        Notification::make()
            ->title('Сохранено')
            ->success()
            ->send();
    }
}
