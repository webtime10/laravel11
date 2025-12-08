<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OptionDescription extends Model
{
    protected $table = 'option_descriptions';
    protected $primaryKey = 'id'; // increments
    public $timestamps = false;

    protected $fillable = [
        'option_id',
        'name_1', 'name_2',
    ];

    public function option(): BelongsTo
    {
        return $this->belongsTo(Option::class, 'option_id', 'option_id');
    }
}
