<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('manufacturers', function (Blueprint $t) {
            $t->increments('manufacturer_id');     // INT UNSIGNED PK

            $t->string('image', 255)->nullable();  // логотип
            $t->integer('sort_order')->default(0);
            $t->tinyInteger('status')->default(1); // 0/1
            $t->tinyInteger('noindex')->default(0);// 0/1 (как в OC)

            // по желанию даты, как у категорий
            $t->dateTime('date_added')->useCurrent();
            $t->dateTime('date_modified')->useCurrent()->useCurrentOnUpdate();

            $t->index(['status', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('manufacturers');
    }
};
