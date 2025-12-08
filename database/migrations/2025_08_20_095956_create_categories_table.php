<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('category_id');               // PK, auto_increment
            $table->string('image', 255)->nullable();        // основная картинка
            $table->string('image2', 255)->nullable();       // доп. картинка 2
            $table->string('image3', 255)->nullable();       // доп. картинка 3
            $table->string('image4', 255)->nullable();       // доп. картинка 4
            $table->integer('parent_id')->default(0)->nullable()->index(); 
            $table->tinyInteger('top')->nullable();
            $table->integer('column')->nullable();
            $table->integer('sort_order')->default(0)->nullable();
            $table->tinyInteger('status')->nullable();

            // стандартные Laravel метки (created_at, updated_at)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};

