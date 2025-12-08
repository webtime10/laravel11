<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('product_images', function (Blueprint $t) {
            // PK как в OC
            $t->increments('product_image_id');   // int(11) AUTO_INCREMENT NOT NULL

            // FK на products(product_id)
            $t->unsignedInteger('product_id');    // int(11) NOT NULL
            $t->foreign('product_id')
                ->references('product_id')->on('products')
                ->onDelete('cascade');

            // путь к файлу (storage/app/public/…)
            $t->string('image', 255);             // varchar(255) NOT NULL

            // порядок
            $t->integer('sort_order')->default(0); // int(3) NOT NULL DEFAULT 0

            // индексы
            $t->index(['product_id', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_images');
    }
};
