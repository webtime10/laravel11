<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('attribute_groups', function (Blueprint $t) {
            $t->increments('attribute_group_id'); // PK AUTO_INCREMENT, NOT NULL
            $t->integer('sort_order');            // int(3) NOT NULL (без default)
            $t->index('sort_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attribute_groups');
    }
};
