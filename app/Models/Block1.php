<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
