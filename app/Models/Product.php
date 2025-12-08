<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'product_id';
    public $timestamps = false; // в таблице нет created_at/updated_at

    protected $fillable = [
        'model','sku','upc',
        'quantity','stock_status_id',
        'subtract','minimum',
        'image','alt',
        'image1','alt1',
        'image2','alt2',
        'image3','alt3',
        'manufacturer_id',
        'price',
        'sort_order',
        'noindex',
    ];

    protected $casts = [
        'quantity'         => 'int',
        'stock_status_id'  => 'int',
        'subtract'         => 'bool',
        'minimum'          => 'int',
        'price'            => 'int',   // если перейдёшь на decimal, поменяй на 'decimal:4'
        'sort_order'       => 'int',
        'noindex'          => 'bool',
    ];

    /** Описание (name_1/name_2, SEO) */
    public function description(): HasOne
    {
        return $this->hasOne(ProductDescription::class, 'product_id', 'product_id');
    }

    /** Производитель */
    public function manufacturer(): BelongsTo
    {
        return $this->belongsTo(Manufacturer::class, 'manufacturer_id', 'manufacturer_id');
    }

    /** Доп. изображения (product_images) */
    public function productImages(): HasMany
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'product_id')
            ->orderBy('sort_order')->orderBy('product_image_id');
    }

    /** Опции товара (product_options) */
    public function productOptions(): HasMany
    {
        return $this->hasMany(ProductOption::class, 'product_id', 'product_id');
    }

    /** Значения опций товара (product_option_values) */
    public function productOptionValues(): HasMany
    {
        return $this->hasMany(ProductOptionValue::class, 'product_id', 'product_id')
            ->orderBy('sort_order')->orderBy('product_option_value_id');
    }

    /** Атрибуты товара (product_attributes) */
    public function productAttributes(): HasMany
    {
        return $this->hasMany(ProductAttribute::class, 'product_id', 'product_id');
    }
    public function categories()
{
    return $this->belongsToMany(
        \App\Models\Category::class,
        'product_to_category',   // имя таблицы-связки
        'product_id',               // FK на текущую модель
        'category_id'               // FK на связанную модель
    )->withPivot('main_category');
}

public function mainCategory()
{
    return $this->belongsToMany(
        \App\Models\Category::class,
        'product_to_category',
        'product_id',
        'category_id'
    )->withPivot('main_category')
     ->wherePivot('main_category', 1)
     ->limit(1);
}

}
