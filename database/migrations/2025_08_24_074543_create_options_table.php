<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('options', function (Blueprint $t) {
            $t->increments('option_id');     // INT UNSIGNED PK
            $t->string('type', 32);
            $t->integer('sort_order')->default(0);
            // без timestamps
            $t->index(['type','sort_order']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('options');
    }
};
