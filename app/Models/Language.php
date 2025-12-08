<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $table = 'languages';
    protected $primaryKey = 'language_id';
    public $timestamps = false; // у тебя в таблице нет created_at/updated_at

    protected $fillable = [
        'name',
        'code',
        'locale',
        'extension',
        'lang',
        'sort_order',
        'status',
    ];
}
