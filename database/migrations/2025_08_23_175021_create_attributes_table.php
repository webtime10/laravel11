<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('attributes', function (Blueprint $t) {
            $t->increments('attribute_id');         // PK AUTO_INCREMENT, NOT NULL

            // принадлежит группе (NOT NULL)
            $t->unsignedInteger('attribute_group_id');
            $t->foreign('attribute_group_id')
                ->references('attribute_group_id')->on('attribute_groups')
                ->onDelete('cascade');

            // sort_order int(3) NOT NULL (без default, как просил)
            $t->integer('sort_order');

            $t->index('attribute_group_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attributes');
    }
};
