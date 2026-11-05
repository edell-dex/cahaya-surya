<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Gunakan DB statement agar langsung mengubah tipe data kolom menjadi TEXT
        DB::statement("ALTER TABLE `pasien` MODIFY `riwayat_penyakit` TEXT NULL");
        DB::statement("ALTER TABLE `pasien` MODIFY `riwayat_keluarga` TEXT NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE `pasien` MODIFY `riwayat_penyakit` VARCHAR(255) NULL");
        DB::statement("ALTER TABLE `pasien` MODIFY `riwayat_keluarga` VARCHAR(255) NULL");
    }
};
