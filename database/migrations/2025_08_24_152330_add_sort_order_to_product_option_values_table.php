<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('product_option_values', function (Blueprint $t) {
            if (!Schema::hasColumn('product_option_values', 'sort_order')) {
                $t->integer('sort_order')->default(0)->after('price_prefix');
            }
        });
    }

    public function down(): void
    {
        Schema::table('product_option_values', function (Blueprint $t) {
            if (Schema::hasColumn('product_option_values', 'sort_order')) {
                $t->dropColumn('sort_order');
            }
        });
    }
};
