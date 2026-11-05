<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hasil_skrining', function (Blueprint $table) {
            // Kolom alat yang dipakai (JSON array, bisa lebih dari satu pilihan)
            // Untuk siswa: Foto Fundus EyeRobo, ICARE 100, Buta Warna Ishihara/Munsell 15, Alat Refraksi Retinomax/ARK
            // Untuk karyawan: Foto Fundus EyeRobo, Kardia L6/Omron, ABI, Laboratorium Stik
            $table->json('alat_dipakai')->nullable()->after('tanggal_periksa')
                  ->comment('Array alat yang digunakan saat skrining');
        });
    }

    public function down(): void
    {
        Schema::table('hasil_skrining', function (Blueprint $table) {
            $table->dropColumn('alat_dipakai');
        });
    }
};
