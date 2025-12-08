<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('home_descriptions', function (Blueprint $t) {
            $t->increments('id');

            // Связь с home(id)
            $t->unsignedBigInteger('home_id');
            $t->foreign('home_id')
                ->references('id')->on('home')
                ->onDelete('cascade');

            // Одна запись описания на home
            $t->unique('home_id');

            // Вариант 1 (обязательное поле title, остальное опционально)
            $t->string('title_1', 255);
            $t->string('meta_description_1', 255)->nullable();
            $t->text('block_1_1')->nullable();
            $t->text('block_2_1')->nullable();

            // Вариант 2 (всё опционально)
            $t->string('title_2', 255)->nullable();
            $t->string('meta_description_2', 255)->nullable();
            $t->text('block_1_2')->nullable();
            $t->text('block_2_2')->nullable();

            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('home_descriptions');
    }
};

