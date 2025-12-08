<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Manufacturer extends Model
{
    protected $table = 'manufacturers';
    protected $primaryKey = 'manufacturer_id';
    public $timestamps = false; // у нас date_added/date_modified, а не created_at/updated_at

    protected $fillable = [
        'image',
        'sort_order',
        'status',
        'noindex',
        'date_added',
        'date_modified',
    ];

    /** Описание (name_1 / name_2 и SEO) */
    public function description(): HasOne
    {
        return $this->hasOne(ManufacturerDescription::class, 'manufacturer_id', 'manufacturer_id');
    }

    /** (опционально) товары этого производителя, если в products есть manufacturer_id */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'manufacturer_id', 'manufacturer_id');
    }

    /** Удобное локализованное имя */
    public function getNameLocalAttribute(): ?string
    {
        $d = $this->relationLoaded('description') ? $this->description : $this->description()->first();
        if (! $d) return null;

        $lang = (int) session('lang', 1); // 1 или 2
        return $lang === 2 ? ($d->name_2 ?? $d->name_1) : ($d->name_1 ?? $d->name_2);
    }

    /** Быстрый скоуп “включённые” */
    public function scopeActive($q)
    {
        return $q->where('status', 1);
    }
}
