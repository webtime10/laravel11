<?php

namespace App\Filament\Pages;

use App\Models\Home;
use Filament\Pages\Page;
use Filament\Forms\Form;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
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

    public ?array $data = [];

    public function mount(): void
    {
        // гарантируем, что запись существует
        $record = Home::first() ?? Home::create();
        $record->load('description');

        // Заполняем форму данными из description
        if ($record->description) {
            $this->form->fill($record->description->only([
                'title_1', 'title_2',
                'meta_description_1', 'meta_description_2',
                'block_1_1', 'block_1_2',
                'block_2_1', 'block_2_2',
            ]));
        }
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Описание')
                    ->schema([
                        Tabs::make('descTabs')->tabs([
                            Tabs\Tab::make('1')->schema([
                                TextInput::make('title_1')
                                    ->label('Название 1')
                                    ->required()
                                    ->maxLength(255),

                                TextInput::make('meta_description_1')
                                    ->label('Meta description 1')
                                    ->maxLength(255),

                                RichEditor::make('block_1_1')
                                    ->label('Блок 1')
                                    ->toolbarButtons([
                                        'bold', 'italic', 'strike',
                                        'link', 'orderedList', 'bulletList',
                                        'blockquote', 'codeBlock',
                                        'h2', 'h3', 'hr', 'undo', 'redo',
                                    ])
                                    ->columnSpanFull(),

                                RichEditor::make('block_2_1')
                                    ->label('Блок 2')
                                    ->toolbarButtons([
                                        'bold', 'italic', 'strike',
                                        'link', 'orderedList', 'bulletList',
                                        'blockquote', 'codeBlock',
                                        'h2', 'h3', 'hr', 'undo', 'redo',
                                    ])
                                    ->columnSpanFull(),
                            ]),
                            Tabs\Tab::make('2')->schema([
                                TextInput::make('title_2')
                                    ->label('Название 2')
                                    ->maxLength(255),

                                TextInput::make('meta_description_2')
                                    ->label('Meta description 2')
                                    ->maxLength(255),

                                RichEditor::make('block_1_2')
                                    ->label('Блок 1')
                                    ->toolbarButtons([
                                        'bold', 'italic', 'strike',
                                        'link', 'orderedList', 'bulletList',
                                        'blockquote', 'codeBlock',
                                        'h2', 'h3', 'hr', 'undo', 'redo',
                                    ])
                                    ->columnSpanFull(),

                                RichEditor::make('block_2_2')
                                    ->label('Блок 2')
                                    ->toolbarButtons([
                                        'bold', 'italic', 'strike',
                                        'link', 'orderedList', 'bulletList',
                                        'blockquote', 'codeBlock',
                                        'h2', 'h3', 'hr', 'undo', 'redo',
                                    ])
                                    ->columnSpanFull(),
                            ]),
                        ])->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $record = Home::first() ?? new Home();
        $record->save();

        // Получаем данные формы
        $data = $this->form->getState();
        
        // Сохраняем description
        $record->description()->updateOrCreate(
            ['home_id' => $record->id],
            $data
        );

        Notification::make()
            ->title('Сохранено')
            ->success()
            ->send();
    }
}
