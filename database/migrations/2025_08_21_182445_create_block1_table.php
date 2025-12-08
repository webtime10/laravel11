<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('block1', function (Blueprint $table) {
            $table->id();
            $table->string('name1');
            $table->string('name2')->nullable();
            $table->text('content')->nullable();
            $table->string('image1')->nullable();
            $table->string('image2')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('block1');
    }
};

