<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('option_descriptions', function (Blueprint $t) {
            $t->increments('id');

            $t->unsignedInteger('option_id');
            $t->foreign('option_id')
                ->references('option_id')->on('options')
                ->onDelete('cascade');

            $t->unique('option_id');           // одна строка на опцию

            $t->string('name_1', 64);          // обязательное
            $t->string('name_2', 64)->nullable(); // второе — опционально
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('option_descriptions');
    }
};

