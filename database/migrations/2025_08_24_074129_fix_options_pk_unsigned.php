<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // На всякий случай один движок
        DB::statement('ALTER TABLE `options` ENGINE=InnoDB');

        // Сделать PK unsigned (совместимо с unsignedInteger в дочерних таблицах)
        DB::statement('ALTER TABLE `options` MODIFY `option_id` INT UNSIGNED NOT NULL AUTO_INCREMENT');
    }

    public function down(): void
    {
        // Откат к signed
        DB::statement('ALTER TABLE `options` MODIFY `option_id` INT NOT NULL AUTO_INCREMENT');
    }
};
