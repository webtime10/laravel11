<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CategoryPath extends Model
{
    protected $table = 'category_paths';

    // В таблице композитный PK (category_id, path_id) — Eloquent его не умеет.
    // Используем модель для чтения/джойнов; вставки/обновления делаем через DB::table(...)
    public $timestamps  = false;
    public $incrementing = false;
    protected $guarded   = [];

    /** Текущая категория */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    /** Предок (включая саму категорию на level=0 в конце цепочки) */
    public function ancestor(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'path_id', 'category_id');
    }

    /** Удобные скоупы */
    public function scopeForCategory($q, int $categoryId)
    {
        return $q->where('category_id', $categoryId)->orderBy('level');
    }

    public function scopeForAncestor($q, int $ancestorId)
    {
        return $q->where('path_id', $ancestorId)->orderBy('level');
    }
}
