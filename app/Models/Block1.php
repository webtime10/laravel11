<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Block1 extends Model
{
    protected $table = 'block1';

    protected $fillable = [
        'name1',
        'name2',
        'content',
        'image1',
        'image2',
    ];

    /** Описание (title_1/title_2, description_1/description_2) */
    public function description(): HasOne
    {
        return $this->hasOne(Block1Description::class, 'block1_id', 'id');
    }
}
