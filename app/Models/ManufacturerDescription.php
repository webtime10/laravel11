<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ManufacturerDescription extends Model
{
    protected $table = 'manufacturer_descriptions';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'manufacturer_id',
        'name_1', 'name_2',
        'description_1', 'description_2',
        'meta_title_1', 'meta_title_2',
        'meta_description_1', 'meta_description_2',
        'meta_keyword_1', 'meta_keyword_2',
        'meta_h1_1', 'meta_h1_2',
    ];

    public function manufacturer(): BelongsTo
    {
        return $this->belongsTo(Manufacturer::class, 'manufacturer_id', 'manufacturer_id');
    }
}
