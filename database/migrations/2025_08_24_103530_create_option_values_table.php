<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('option_values', function (Blueprint $t) {
            $t->increments('option_value_id');
            $t->unsignedInteger('option_id');
            $t->string('image', 255)->nullable();
            $t->integer('sort_order')->default(0);

            $t->index(['option_id','sort_order']);
            $t->foreign('option_id')->references('option_id')->on('options')->onDelete('cascade');
        });
    }
    public function down(): void { Schema::dropIfExists('option_values'); }
};
