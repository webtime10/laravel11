<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OptionValue extends Model
{
    protected $table = 'option_values';
    protected $primaryKey = 'option_value_id';
    public $timestamps = false;

    protected $fillable = [
        'option_id',
        'image',
        'sort_order',
    ];

    public function option(): BelongsTo
    {
        return $this->belongsTo(Option::class, 'option_id', 'option_id');
    }

    public function description(): HasOne
    {
        return $this->hasOne(OptionValueDescription::class, 'option_value_id', 'option_value_id');
    }
}
