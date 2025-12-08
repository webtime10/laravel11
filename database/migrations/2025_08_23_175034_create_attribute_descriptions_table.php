<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('attribute_descriptions', function (Blueprint $t) {
            $t->increments('id');

            // связь 1:1 с attributes
            $t->unsignedInteger('attribute_id');
            $t->foreign('attribute_id')
                ->references('attribute_id')->on('attributes')
                ->onDelete('cascade');

            // одна строка описания на атрибут
            $t->unique('attribute_id');

            // названия (без language_id, как договорились)
            $t->string('name_1', 64);          // NOT NULL
            $t->string('name_2', 64)->nullable(); // NULL допустим

            // без created_at/updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attribute_descriptions');
    }
};
