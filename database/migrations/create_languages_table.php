<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
            Schema::create('languages', function (Blueprint $table) {
                $table->increments('language_id');          // PK
                $table->string('name', 32)->index();        // Название языка
                $table->string('code', 5);                  // Символьный код (ru, en)
                $table->string('locale', 255);              // Локаль (ru_RU, en_US)
                $table->string('extension', 255);           // Расширение/файл
    
                $table->integer('sort_order')->default(0);  // Для сортировки
                $table->tinyInteger('status');              // Активен / нет
            });
    }

    public function down(): void
    {
        Schema::dropIfExists('languages');
    }
};
