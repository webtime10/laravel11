<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Чисто дропаем на случай существующих FK
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('category_paths');
        Schema::enableForeignKeyConstraints();

        Schema::create('category_paths', function (Blueprint $t) {
            $t->unsignedInteger('category_id'); // сама категория
            $t->unsignedInteger('path_id');     // предок (включая саму себя)
            $t->unsignedInteger('level');       // 0 = сама категория, далее 1,2,...

            // Композитный PK и индексы
            $t->primary(['category_id', 'path_id']);
            $t->index(['path_id', 'level']);

            // FK
            $t->foreign('category_id')
              ->references('category_id')->on('categories')
              ->onDelete('cascade');

            $t->foreign('path_id')
              ->references('category_id')->on('categories')
              ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('category_paths');
    }
};
