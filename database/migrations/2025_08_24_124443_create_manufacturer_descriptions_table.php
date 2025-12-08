<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('manufacturer_descriptions', function (Blueprint $t) {
            $t->increments('id');

            $t->unsignedInteger('manufacturer_id');
            $t->foreign('manufacturer_id')
                ->references('manufacturer_id')->on('manufacturers')
                ->onDelete('cascade');

            // одна строка описания на производителя
            $t->unique('manufacturer_id');

            // названия (двуязычно)
            $t->string('name_1', 255);
            $t->string('name_2', 255)->nullable();

            // описания
            $t->text('description_1')->nullable();
            $t->text('description_2')->nullable();

            // дополнительное поле как у тебя в схеме (description3)
            $t->text('description3_1')->nullable();
            $t->text('description3_2')->nullable();

            // SEO
            $t->string('meta_title_1', 255)->nullable();
            $t->string('meta_title_2', 255)->nullable();

            $t->string('meta_description_1', 255)->nullable();
            $t->string('meta_description_2', 255)->nullable();

            $t->string('meta_keyword_1', 255)->nullable();
            $t->string('meta_keyword_2', 255)->nullable();

            $t->string('meta_h1_1', 255)->nullable();
            $t->string('meta_h1_2', 255)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('manufacturer_descriptions');
    }
};
