<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use App\Models\Category;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateCategory extends CreateRecord
{
    protected static string $resource = CategoryResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // пустое значение = корень (0)
        $data['parent_id'] = (int) ($data['parent_id'] ?? 0);

        // автослаг, если пуст
        $name = data_get($data, 'description.name_1');
        if (blank($data['slug']) && filled($name)) {
            $base = Str::slug($name);
            $slug = $base;
            $i = 2;
            while (Category::where('slug', $slug)->exists()) {
                $slug = "{$base}-{$i}";
                $i++;
            }
            $data['slug'] = $slug;
        }

        return $data;
    }
}
