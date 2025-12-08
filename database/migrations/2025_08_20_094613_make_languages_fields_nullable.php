<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('languages', function (Blueprint $table) {
            $table->string('name', 32)->nullable()->change();
            $table->string('code', 5)->nullable()->change();
            $table->string('locale', 255)->nullable()->change();
            $table->string('extension', 255)->nullable()->change();
            $table->integer('lang')->nullable()->change();
            $table->integer('sort_order')->default(0)->nullable()->change();
            $table->tinyInteger('status')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('languages', function (Blueprint $table) {
            $table->string('name', 32)->nullable(false)->change();
            $table->string('code', 5)->nullable(false)->change();
            $table->string('locale', 255)->nullable(false)->change();
            $table->string('extension', 255)->nullable(false)->change();
            $table->integer('lang')->nullable(false)->change();
            $table->integer('sort_order')->default(0)->nullable(false)->change();
            $table->tinyInteger('status')->nullable(false)->change();
        });
    }
};
