<?php

namespace App\Filament\Resources\Block1Resource\Pages;

use App\Filament\Resources\Block1Resource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBlock1s extends ListRecords
{
    protected static string $resource = Block1Resource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
