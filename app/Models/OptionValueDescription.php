<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OptionValueDescription extends Model
{
    protected $table = 'option_value_descriptions';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'option_value_id',
        'name_1', 'name_2',
    ];

    public function optionValue(): BelongsTo
    {
        return $this->belongsTo(OptionValue::class, 'option_value_id', 'option_value_id');
    }
}
