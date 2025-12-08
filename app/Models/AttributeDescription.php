<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttributeDescription extends Model
{
    protected $table = 'attribute_descriptions';
    public $timestamps = false;

    protected $fillable = [
        'attribute_id',
        'name_1',
        'name_2',
    ];

    public function attribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class, 'attribute_id', 'attribute_id');
    }
}
