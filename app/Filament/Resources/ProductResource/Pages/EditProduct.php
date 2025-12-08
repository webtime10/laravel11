<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Models\Product;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Enums\MaxWidth;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->color('danger')
                ->extraAttributes(['class' => 'ms-auto']),
        ];
    }

    public function getMaxContentWidth(): MaxWidth|string
    {
        return MaxWidth::Full;
    }

    /**
     * Подставляем главную категорию из pivot при открытии формы.
     */
    protected function mutateFormDataBeforeFill(array $data): array
    {
        /** @var Product $product */
        $product = $this->record;

        $mainId = $product->categories()
            ->wherePivot('main_category', 1)
            ->value('categories.category_id');

        if ($mainId) {
            $data['main_category_id'] = (int) $mainId;
        }

        return $data;
    }

    /**
     * После сохранения товара: выставляем флаг main_category в pivot.
     * На этом этапе Select::relationship('categories') уже синхронизировал связи.
     */
    protected function afterSave(): void
    {
        /** @var Product $product */
        $product = $this->record;

        // Категории, которые реально записаны в pivot
        $chosen = $product->categories()->pluck('categories.category_id')->all();

        // Главную берём из состояния формы (её мы не сохраняем в products)
        $state  = $this->form->getState();
        $mainId = (int) ($state['main_category_id'] ?? 0);

        // Если ничего не выбрано — просто очищаем pivot (на всякий случай)
        if (empty($chosen)) {
            $product->categories()->detach();
            return;
        }

        // Сбрасываем флаги у всех выбранных
        foreach ($chosen as $catId) {
            $product->categories()->updateExistingPivot($catId, ['main_category' => 0]);
        }

        // Ставим флаг главной, если она среди выбранных
        if ($mainId && in_array($mainId, $chosen, true)) {
            $product->categories()->updateExistingPivot($mainId, ['main_category' => 1]);
        }
    }
}
