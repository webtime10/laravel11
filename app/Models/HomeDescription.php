<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HomeDescription extends Model
{
    protected $table = 'home_descriptions';

    protected $fillable = [
        'home_id',
        'title_1', 'title_2',
        'meta_description_1', 'meta_description_2',
        'block_1_1', 'block_1_2',
        'block_2_1', 'block_2_2',
    ];

    /** Обратная связь к home */
    public function home(): BelongsTo
    {
        return $this->belongsTo(Home::class, 'home_id', 'id');
    }

    /* Удобные хелперы (по номеру варианта 1|2) */
    public function titleBy(int $v = 1): ?string
    {
        return $this->{"title_{$v}"} ?? null;
    }

    public function metaDescriptionBy(int $v = 1): ?string
    {
        return $this->{"meta_description_{$v}"} ?? null;
    }

    public function block1By(int $v = 1): ?string
    {
        return $this->{"block_1_{$v}"} ?? null;
    }

    public function block2By(int $v = 1): ?string
    {
        return $this->{"block_2_{$v}"} ?? null;
    }
}

