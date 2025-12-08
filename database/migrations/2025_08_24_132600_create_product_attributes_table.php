<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('product_attributes', function (Blueprint $t) {
            $t->increments('id');

            $t->unsignedInteger('product_id');
            $t->unsignedInteger('attribute_id');

            // тексты для 2 "языков"
            $t->text('text_1')->nullable();
            $t->text('text_2')->nullable();


            $t->unique(['product_id', 'attribute_id']);
            $t->index('product_id');
            $t->index('attribute_id');

            // внешние ключи
            $t->foreign('product_id')
                ->references('product_id')->on('products')
                ->onDelete('cascade');

            $t->foreign('attribute_id')
                ->references('attribute_id')->on('attributes')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_attributes');
    }
};
