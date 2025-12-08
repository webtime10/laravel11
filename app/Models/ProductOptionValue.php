<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductOptionValue extends Model
{
    protected $table = 'product_option_values';
    protected $primaryKey = 'product_option_value_id';
    public $timestamps = false;

    protected $fillable = [
        'product_option_id',
        'product_id',        // заполним автоматически
        'option_id',         // заполним автоматически
        'option_value_id',
        'quantity',
        'subtract',
        'price',
        'price_prefix',
        'sort_order',
    ];

    protected $casts = [
        'product_option_id' => 'int',
        'product_id'        => 'int',
        'option_id'         => 'int',
        'option_value_id'   => 'int',
        'quantity'          => 'int',
        'subtract'          => 'bool',
        'price'             => 'decimal:4',
        'sort_order'        => 'int',
    ];

    public function productOption(): BelongsTo
    {
        return $this->belongsTo(ProductOption::class, 'product_option_id', 'product_option_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    public function option(): BelongsTo
    {
        return $this->belongsTo(Option::class, 'option_id', 'option_id');
    }

    public function optionValue(): BelongsTo
    {
        return $this->belongsTo(OptionValue::class, 'option_value_id', 'option_value_id');
    }

    /** Авто-заполнение product_id и option_id из родительской product_options */
    protected static function booted(): void
    {
        static::creating(function (ProductOptionValue $v) {
            if (!$v->product_id || !$v->option_id) {
                // загрузим родителя, если известен product_option_id
                if ($v->product_option_id) {
                    $po = ProductOption::query()->select('product_id','option_id')
                        ->where('product_option_id', $v->product_option_id)->first();

                    if ($po) {
                        if (!$v->product_id) {
                            $v->product_id = (int) $po->product_id;
                        }
                        if (!$v->option_id) {
                            $v->option_id = (int) $po->option_id;
                        }
                    }
                }
            }
        });
    }
}
