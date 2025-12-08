<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('category_descriptions', function (Blueprint $table) {
            $table->integer('category_id')->unsigned();
            $table->integer('language_id')->unsigned();

            $table->string('name', 255)->nullable();
            $table->text('description')->nullable();
            $table->string('meta_title', 255)->nullable();
            $table->string('meta_description', 255)->nullable();
            $table->string('meta_keyword', 255)->nullable();
            $table->string('meta_h1', 255)->nullable();
            $table->string('slug', 222);

            // составной первичный ключ
            $table->primary(['category_id', 'language_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('category_descriptions');
    }
};
