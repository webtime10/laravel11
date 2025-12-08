<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Удаляем старую таблицу, если была (с language_id)
        Schema::dropIfExists('product_attributes');

        // Новая схема без language_id
        Schema::create('product_attributes', function (Blueprint $t) {
            $t->increments('id');                 // PK

            $t->unsignedInteger('product_id');    // FK → products(product_id)
            $t->unsignedInteger('attribute_id');  // FK → attributes(attribute_id)

            $t->text('text_1')->nullable();       // значение «язык 1»
            $t->text('text_2')->nullable();       // значение «язык 2»

            // запрет дубликатов одного атрибута на товар
            $t->unique(['product_id', 'attribute_id']);

            // внешние ключи
            $t->foreign('product_id')
                ->references('product_id')->on('products')
                ->onDelete('cascade');

            $t->foreign('attribute_id')
                ->references('attribute_id')->on('attributes')
                ->onDelete('cascade');

            $t->index(['product_id', 'attribute_id']);
        });
    }

    public function down(): void
    {
        // Возврат к старому формату (product_id + attribute_id + language_id + text)
        Schema::dropIfExists('product_attributes');

        Schema::create('product_attributes', function (Blueprint $t) {
            $t->unsignedInteger('product_id');
            $t->unsignedInteger('attribute_id');
            $t->unsignedInteger('language_id');
            $t->text('text');

            $t->primary(['product_id', 'attribute_id', 'language_id']);

            $t->foreign('product_id')
                ->references('product_id')->on('products')
                ->onDelete('cascade');

            $t->foreign('attribute_id')
                ->references('attribute_id')->on('attributes')
                ->onDelete('cascade');
        });
    }
};
