<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Attribute extends Model
{
    protected $table = 'attributes';
    protected $primaryKey = 'attribute_id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'attribute_group_id',
        'sort_order',
    ];

    /** принадлежит группе */
    public function group(): BelongsTo
    {
        return $this->belongsTo(AttributeGroup::class, 'attribute_group_id', 'attribute_group_id');
    }

    /** hasOne описание атрибута (name_1 / name_2) */
    public function description(): HasOne
    {
        return $this->hasOne(AttributeDescription::class, 'attribute_id', 'attribute_id');
    }

    /** удобное имя для селектов */
    public function getDisplayNameAttribute(): string
    {
        $d = $this->relationLoaded('description') ? $this->description : $this->description()->first();
        return $d->name_1 ?? $d->name_2 ?? ('Атрибут #'.$this->attribute_id);
    }
}
