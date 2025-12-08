<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Models\Product;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\MaxWidth;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    public function getMaxContentWidth(): MaxWidth|string
    {
        return MaxWidth::Full;
    }

    protected function afterSave(): void
    {
        /** @var \App\Models\Product $product */
        $product = $this->record;

        // категории уже синхронены самим Select::relationship()
        $chosen = $product->categories()->pluck('categories.category_id')->all();

        // из формы возьмём только выбранную «главную»
        $mainId = (int) ($this->form->getState()['main_category_id'] ?? 0);

        // сбросим флаги
        foreach ($chosen as $catId) {
            $product->categories()->updateExistingPivot($catId, ['main_category' => 0]);
        }

        // поставим флаг у главной, если она среди выбранных
        if ($mainId && in_array($mainId, $chosen, true)) {
            $product->categories()->updateExistingPivot($mainId, ['main_category' => 1]);
        }
    }

}
