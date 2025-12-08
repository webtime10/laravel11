<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::dropIfExists('category_descriptions');
        Schema::dropIfExists('categories');
    }
    public function down(): void
    {
        // Если вдруг нужно будет вернуть — создавайте заново отдельными миграциями.
    }
};

