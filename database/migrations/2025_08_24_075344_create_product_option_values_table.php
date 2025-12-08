<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // выберем реальные имена таблиц опций (с/без префикса oc_)
        $optTable    = Schema::hasTable('options')       ? 'options'       : 'oc_option';
        $optValTable = Schema::hasTable('option_values') ? 'option_values' : 'oc_option_value';

        Schema::create('product_option_values', function (Blueprint $t) use ($optTable, $optValTable) {
            $t->increments('product_option_value_id');

            $t->unsignedInteger('product_option_id');
            $t->unsignedInteger('product_id');
            $t->unsignedInteger('option_id');
            $t->unsignedInteger('option_value_id');

            $t->integer('quantity')->default(0);          // int(3)
            $t->tinyInteger('subtract')->default(0);      // 0/1
            $t->decimal('price', 15, 4)->default(0);      // 0.0000
            $t->string('price_prefix', 1)->default('+');  // '+' или '-'

            $t->index(['product_option_id']);
            $t->index(['product_id']);
            $t->index(['option_id']);
            $t->index(['option_value_id']);

            $t->foreign('product_option_id')->references('product_option_id')->on('product_options')->onDelete('cascade');
            $t->foreign('product_id')->references('product_id')->on('products')->onDelete('cascade');
            $t->foreign('option_id')->references('option_id')->on($optTable)->onDelete('cascade');
            $t->foreign('option_value_id')->references('option_value_id')->on($optValTable)->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_option_values');
    }
};
