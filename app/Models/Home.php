<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Home extends Model
{
    use HasFactory;

    protected $table = 'home'; // название таблицы (по умолчанию Laravel сделал бы "homes")

    protected $fillable = [
        'title',
        'meta_description',
        'block_1',
        'block_2',
    ];
}
