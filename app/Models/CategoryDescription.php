<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CategoryDescription extends Model
{
    protected $table = 'category_descriptions';

    // PK = id (auto-increment), timestamps есть (created_at/updated_at)
    // ничего менять не нужно

    protected $fillable = [
        'category_id',
        'name_1', 'description_1', 'meta_title_1', 'meta_description_1',
        'name_2', 'description_2', 'meta_title_2', 'meta_description_2',
    ];

    /** Обратная связь к категории (PK у категории = category_id) */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    /* Удобные хелперы (по номеру варианта 1|2) */
    public function nameBy(int $v = 1): ?string          { return $this->{"name_{$v}"} ?? null; }
    public function descriptionBy(int $v = 1): ?string   { return $this->{"description_{$v}"} ?? null; }
    public function metaTitleBy(int $v = 1): ?string     { return $this->{"meta_title_{$v}"} ?? null; }
    public function metaDescriptionBy(int $v = 1): ?string { return $this->{"meta_description_{$v}"} ?? null; }
}
