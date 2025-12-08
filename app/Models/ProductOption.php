<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductOption extends Model
{
    protected $table = 'product_options';
    protected $primaryKey = 'product_option_id';
    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'option_id',
        'value',       // для text/textarea/date/time/datetime
        'required',
        'sort_order',
    ];

    protected $casts = [
        'product_id' => 'int',
        'option_id'  => 'int',
        'required'   => 'bool',
        'sort_order' => 'int',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    public function option(): BelongsTo
    {
        return $this->belongsTo(Option::class, 'option_id', 'option_id');
    }

    public function values(): HasMany
    {
        return $this->hasMany(ProductOptionValue::class, 'product_option_id', 'product_option_id');
    }
}
