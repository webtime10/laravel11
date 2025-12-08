<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Option extends Model
{
    protected $table = 'options';
    protected $primaryKey = 'option_id';
    public $timestamps = false;

    protected $fillable = ['type', 'sort_order', 'status'];

    public function description(): HasOne
    {
        return $this->hasOne(OptionDescription::class, 'option_id', 'option_id');
    }

    public function values(): HasMany
    {
        return $this->hasMany(OptionValue::class, 'option_id', 'option_id')->orderBy('sort_order');
    }
}
