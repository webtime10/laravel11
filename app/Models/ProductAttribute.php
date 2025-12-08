<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductAttribute extends Model
{
    protected $table = 'product_attributes';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'attribute_id',
        'text_1',
        'text_2',
    ];

    protected $casts = [
        'product_id'   => 'int',
        'attribute_id' => 'int',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    public function attribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class, 'attribute_id', 'attribute_id');
    }
}
