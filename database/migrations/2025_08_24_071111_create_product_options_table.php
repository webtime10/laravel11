<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('product_options', function (Blueprint $t) {
            // PK (как в OC)
            $t->increments('product_option_id');     // int(11) AUTO_INCREMENT NOT NULL

            // Связи
            $t->unsignedInteger('product_id');       // int(11) NOT NULL
            $t->unsignedInteger('option_id');        // int(11) NOT NULL

            // Значение для опций типа text/textarea/date/time/datetime (в OC это text)
            $t->text('value')->nullable();           // NULL допустимо

            // Обязательность выбора
            $t->tinyInteger('required')->default(0); // 0/1 NOT NULL

            // Индексы
            $t->index(['product_id', 'option_id']);

            // (необязательно) запретить дубли одной и той же опции на товаре
            $t->unique(['product_id', 'option_id']);

            // Внешние ключи (включай, если таблицы уже созданы)
            $t->foreign('product_id')
                ->references('product_id')->on('products')
                ->onDelete('cascade');

            $t->foreign('option_id')
                ->references('option_id')->on('options')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_options');
    }
};
