<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Block1Description extends Model
{
    protected $table = 'block1_descriptions';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'block1_id',
        'title_1', 'title_2',
        'description_1', 'description_2',
    ];

    /** Обратная связь к block1 */
    public function block1(): BelongsTo
    {
        return $this->belongsTo(Block1::class, 'block1_id', 'id');
    }

    /* Удобные хелперы (по номеру варианта 1|2) */
    public function titleBy(int $v = 1): ?string
    {
        return $this->{"title_{$v}"} ?? null;
    }

    public function descriptionBy(int $v = 1): ?string
    {
        return $this->{"description_{$v}"} ?? null;
    }
}





