<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Home extends Model
{
    use HasFactory;

    protected $table = 'home'; // название таблицы (по умолчанию Laravel сделал бы "homes")

    protected $fillable = [
        // Основные поля теперь не нужны, всё в description
    ];

    /** Описание (hasOne) */
    public function description(): HasOne
    {
        return $this->hasOne(HomeDescription::class, 'home_id', 'id');
    }
}
