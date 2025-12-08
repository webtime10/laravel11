<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('option_value_descriptions', function (Blueprint $t) {
            $t->increments('id');
            $t->unsignedInteger('option_value_id');
            $t->unique('option_value_id');

            // наши поля «два языка»
            $t->string('name_1', 64);
            $t->string('name_2', 64)->nullable();

            $t->foreign('option_value_id')->references('option_value_id')->on('option_values')->onDelete('cascade');
        });
    }
    public function down(): void { Schema::dropIfExists('option_value_descriptions'); }
};

