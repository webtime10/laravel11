<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // На всякий случай движок
        DB::statement('ALTER TABLE `options` ENGINE=InnoDB');

        // Сделать PK UNSIGNED
        DB::statement('ALTER TABLE `options` MODIFY `option_id` INT UNSIGNED NOT NULL AUTO_INCREMENT');
    }

    public function down(): void
    {
        // Откат (делаем обратно signed)
        DB::statement('ALTER TABLE `options` MODIFY `option_id` INT NOT NULL AUTO_INCREMENT');
    }
};
