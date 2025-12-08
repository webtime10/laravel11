<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductDescription extends Model
{
    protected $table = 'product_descriptions';
    protected $primaryKey = 'id'; // в миграции id AUTO_INCREMENT
    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'name_1','name_2',
        'description_1','description_2',
        'meta_title_1','meta_title_2',
        'meta_description_1','meta_description_2',
        'meta_keyword_1','meta_keyword_2',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    /** Удобный локализованный accessor */
    public function getNameLocalAttribute(): ?string
    {
        $lang = (int) session('lang', 1);
        return $lang === 2 ? ($this->name_2 ?? $this->name_1) : ($this->name_1 ?? $this->name_2);
    }
}
