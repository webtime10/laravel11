<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AttributeGroup extends Model
{
    protected $table = 'attribute_groups';
    protected $primaryKey = 'attribute_group_id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = ['sort_order'];

    /** hasOne описание (name_1 / name_2) */
    public function description(): HasOne
    {
        return $this->hasOne(AttributeGroupDescription::class, 'attribute_group_id', 'attribute_group_id');
    }

    /** hasMany атрибуты группы */
    public function attributes(): HasMany
    {
        return $this->hasMany(Attribute::class, 'attribute_group_id', 'attribute_group_id')
            ->orderBy('sort_order');
    }

    /** Удобное имя для вывода в селектах */
    public function getDisplayNameAttribute(): string
    {
        $d = $this->relationLoaded('description') ? $this->description : $this->description()->first();
        return $d->name_1 ?? $d->name_2 ?? ('Группа #'.$this->attribute_group_id);
    }
}
