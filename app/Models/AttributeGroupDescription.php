<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttributeGroupDescription extends Model
{
    protected $table = 'attribute_group_descriptions';
    public $timestamps = false;

    protected $fillable = [
        'attribute_group_id',
        'name_1',
        'name_2',
    ];

    public function group(): BelongsTo
    {
        return $this->belongsTo(AttributeGroup::class, 'attribute_group_id', 'attribute_group_id');
    }
}
