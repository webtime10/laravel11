<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    /** Таблица и PK */
    protected $table = 'categories';
    protected $primaryKey = 'category_id';
    public $incrementing = true;
    protected $keyType = 'int';

    /** Таймстемпы в нестандартных полях */
    const CREATED_AT = 'date_added';
    const UPDATED_AT = 'date_modified';

    protected $fillable = [
        'slug',
        'image_1', 'image_2',
        'parent_id',
        'top', 'column', 'sort_order', 'status',
    ];

    protected $casts = [
        'parent_id' => 'int',
        'top'       => 'bool',
        'status'    => 'bool',
    ];

    /* =========================
     |          Связи
     ========================= */

    /** Описание (одна строка с *_1 / *_2) */
    public function description(): HasOne
    {
        return $this->hasOne(CategoryDescription::class, 'category_id', 'category_id');
    }

    /** Родитель */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id', 'category_id');
    }

    /** Дети */
    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id', 'category_id')
            ->orderBy('sort_order');
    }

    /* =========================
     |     Утилиты / аксессоры
     ========================= */

    /** Удобная подпись для админки */
    public function getDisplayNameAttribute(): string
    {
        $d = $this->relationLoaded('description') ? $this->description : $this->description()->first();
        return $d->name_1
            ?? $d->name_2
            ?? ($this->slug ?: 'Категория #'.$this->category_id);
    }

    /** Скоупы */
    public function scopeActive($q)  { return $q->where('status', 1); }
    public function scopeRoots($q)   { return $q->where('parent_id', 0); }
    public function scopeOrdered($q) { return $q->orderBy('sort_order'); }

    /* =========================
     |   Поддержка category_paths
     ========================= */

    protected static function booted(): void
    {
        // после создания/обновления — перестроить пути
        static::saved(function (Category $c) {
            $c->rebuildPaths();
        });

        // перед удалением — «поднимем» детей к корню
        static::deleting(function (Category $c) {
            $c->children()->update(['parent_id' => 0]);
        });
    }
    public function products()
{
    return $this->belongsToMany(
        \App\Models\Product::class,
        'product_to_category',
        'category_id',
        'product_id'
    )->withPivot('main_category');
}


    /** Перестроить записи в category_paths (как в OpenCart) */
    public function rebuildPaths(): void
    {
        DB::table('category_paths')->where('category_id', $this->category_id)->delete();

        $level = 0;

        // пути предков, если есть родитель (0 = корень)
        if ($this->parent_id && $this->parent_id != 0) {
            $parentPaths = DB::table('category_paths')
                ->where('category_id', $this->parent_id)
                ->orderBy('level')
                ->get();

            foreach ($parentPaths as $pp) {
                DB::table('category_paths')->insert([
                    'category_id' => $this->category_id,
                    'path_id'     => $pp->path_id,
                    'level'       => $level++,
                ]);
            }
        }

        // ссылка на саму себя
        DB::table('category_paths')->insert([
            'category_id' => $this->category_id,
            'path_id'     => $this->category_id,
            'level'       => $level,
        ]);

        // обновить детей (на случай смены родителя)
        foreach ($this->children as $child) {
            $child->rebuildPaths();
        }
    }
    public function setParentIdAttribute($value): void
{
    $this->attributes['parent_id'] = (int) ($value ?? 0);
}

}
