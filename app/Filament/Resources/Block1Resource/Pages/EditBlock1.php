<?php

namespace App\Filament\Resources\Block1Resource\Pages;

use App\Filament\Resources\Block1Resource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBlock1 extends EditRecord
{
    protected static string $resource = Block1Resource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
