<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // На всякий случай отключим FK, чтобы спокойно дропнуть
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('category_descriptions');
        Schema::enableForeignKeyConstraints();

        Schema::create('category_descriptions', function (Blueprint $t) {
            $t->increments('id');

            // Связь с categories(category_id)
            $t->unsignedInteger('category_id');
            $t->foreign('category_id')
                ->references('category_id')->on('categories')
                ->onDelete('cascade');

            // Одна запись описания на категорию
            $t->unique('category_id');

            // Вариант 1 (обязательное имя, остальное опционально)
            $t->string('name_1', 255);
            $t->text('description_1')->nullable();
            $t->string('meta_title_1', 255)->nullable();
            $t->string('meta_description_1', 255)->nullable();

            // Вариант 2 (всё опционально)
            $t->string('name_2', 255)->nullable();
            $t->text('description_2')->nullable();
            $t->string('meta_title_2', 255)->nullable();
            $t->string('meta_description_2', 255)->nullable();

            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('category_descriptions');
    }
};
