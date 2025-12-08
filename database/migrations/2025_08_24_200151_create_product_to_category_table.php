<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('product_to_category', function (Blueprint $t) {
            $t->unsignedInteger('product_id');
            $t->unsignedInteger('category_id');
            $t->tinyInteger('main_category')->default(0); // 0/1

            // Композитный PK (как в OpenCart)
            $t->primary(['product_id', 'category_id']);
            $t->index('category_id');

            $t->foreign('product_id')
                ->references('product_id')->on('products')
                ->cascadeOnDelete();

            $t->foreign('category_id')
                ->references('category_id')->on('categories')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_to_category');
    }
};
