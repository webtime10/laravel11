<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $t) {
            $t->increments('product_id');               // PK

            $t->string('model', 64)->nullable();
            $t->string('sku', 222)->nullable();
            $t->string('upc', 12)->nullable();

            $t->integer('quantity')->default(0);
            $t->integer('stock_status_id')->nullable();

            $t->integer('subtract')->default(1);
            $t->integer('minimum')->default(1);

            // изображения
            $t->string('image', 255)->nullable();       // основное
            $t->string('alt', 222)->nullable();         // ALT к основному

            $t->string('image1', 255)->nullable();      // доп. 1
            $t->string('alt1', 222)->nullable();        // ALT к image1

            $t->string('image2', 255)->nullable();      // доп. 2
            $t->string('alt2', 222)->nullable();        // ALT к image2

            $t->string('image3', 255)->nullable();      // доп. 3
            $t->string('alt3', 222)->nullable();        // ALT к image3

            $t->integer('manufacturer_id')->nullable();
            $t->integer('price')->nullable();           // при необходимости поменяй на decimal(15,2)
            $t->integer('sort_order')->default(0);
            $t->tinyInteger('noindex')->default(1);

            // индексы
            $t->index('sku');
            $t->index('upc');
            $t->index('manufacturer_id');
            $t->index('sort_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
