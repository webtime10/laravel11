<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('product_attributes', function (Blueprint $t) {
            // Ключи
            $t->unsignedInteger('product_id');    // NOT NULL
            $t->unsignedInteger('attribute_id');  // NOT NULL
            $t->unsignedInteger('language_id');   // NOT NULL

            // Значение атрибута
            $t->text('text');                     // NOT NULL

            // Составной первичный ключ
            $t->primary(['product_id', 'attribute_id', 'language_id']);

            // Внешние ключи
            $t->foreign('product_id')
                ->references('product_id')->on('products')
                ->onDelete('cascade');

            $t->foreign('attribute_id')
                ->references('attribute_id')->on('attributes')
                ->onDelete('cascade');

            $t->foreign('language_id')
                ->references('language_id')->on('languages')
                ->onDelete('cascade');

            // Доп. индексы по желанию
            $t->index('attribute_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_attributes');
    }
};

