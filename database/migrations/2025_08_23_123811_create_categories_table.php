<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $t) {
            // PK как в OpenCart
            $t->increments('category_id');

            // Общий slug (может быть NULL)
            $t->string('slug', 255)->nullable()->unique();

            // Две фотки (опционально)
            $t->string('image_1', 255)->nullable();
            $t->string('image_2', 255)->nullable();

            // Иерархия (root = 0)
            $t->unsignedInteger('parent_id')->default(0)->index();

            // Параметры отображения
            $t->unsignedTinyInteger('top')->default(0);     // 0/1
            $t->integer('column')->default(1);              // кол-во колонок
            $t->integer('sort_order')->default(0);          // сортировка
            $t->unsignedTinyInteger('status')->default(1);  // 0/1

            // Даты
            $t->dateTime('date_added')->useCurrent();
            $t->dateTime('date_modified')->useCurrent()->useCurrentOnUpdate();

            $t->index(['status', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
