<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('product_descriptions', function (Blueprint $t) {
            $t->increments('id');

            // связь с products(product_id)
            $t->unsignedInteger('product_id');
            $t->foreign('product_id')
                ->references('product_id')->on('products')
                ->onDelete('cascade');

            // одна запись описания на товар
            $t->unique('product_id');

            // Название (как обычно: name_1 обяз., name_2 опционально)
            $t->string('name_1', 255);
            $t->string('name_2', 255)->nullable();

            // Описание
            $t->text('description_1')->nullable();
            $t->text('description_2')->nullable();

            // Теги
            $t->text('tag_1')->nullable();
            $t->text('tag_2')->nullable();

            // SEO
            $t->string('meta_title_1', 255)->nullable();
            $t->string('meta_title_2', 255)->nullable();

            $t->string('meta_description_1', 255)->nullable();
            $t->string('meta_description_2', 255)->nullable();

            $t->string('meta_keyword_1', 255)->nullable();
            $t->string('meta_keyword_2', 255)->nullable();

            // Индекс по названию (как в твоей схеме на name)
            $t->index('name_1');

            // без timestamps
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_descriptions');
    }
};
