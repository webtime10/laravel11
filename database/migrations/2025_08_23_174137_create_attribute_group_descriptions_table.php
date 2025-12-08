<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('attribute_group_descriptions', function (Blueprint $t) {
            $t->increments('id');

            $t->unsignedInteger('attribute_group_id');
            $t->foreign('attribute_group_id')
                ->references('attribute_group_id')->on('attribute_groups')
                ->onDelete('cascade');

            // одна строка описания на группу
            $t->unique('attribute_group_id');

            $t->string('name_1', 64);        // NOT NULL
            $t->string('name_2', 64)->nullable(); // NULL допустимо

            // без created_at/updated_at, как ты и просил
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attribute_group_descriptions');
    }
};
