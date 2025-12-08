<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use App\Models\Category;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EditCategory extends EditRecord
{
    protected static string $resource = CategoryResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // пустое значение = корень (0)
        $parentId = (int) ($data['parent_id'] ?? 0);

        // запрет «сам себе родитель»
        if ($parentId === (int) $this->record->category_id) {
            $parentId = 0;
        }

        // запрет цикла: нельзя выбрать потомка как родителя
        if ($parentId > 0) {
            $isDescendant = DB::table('category_paths')
                ->where('category_id', $parentId)                  // кандидат в родителя
                ->where('path_id', $this->record->category_id)     // текущая как предок
                ->exists();

            if ($isDescendant) {
                $parentId = 0;
            }
        }

        $data['parent_id'] = $parentId;

        // автослаг, если пуст
        $name = data_get($data, 'description.name_1');
        if (blank($data['slug']) && filled($name)) {
            $base = Str::slug($name);
            $slug = $base;
            $i = 2;
            $ignoreId = $this->record->category_id;
            while (
                Category::where('slug', $slug)
                    ->where('category_id', '!=', $ignoreId)
                    ->exists()
            ) {
                $slug = "{$base}-{$i}";
                $i++;
            }
            $data['slug'] = $slug;
        }

        return $data;
    }
}
