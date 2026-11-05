<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pasien', function (Blueprint $table) {
            $table->enum('tipe_pendaftaran', ['sekolah', 'perusahaan'])->default('perusahaan')->after('tanggal_daftar');
            $table->string('institusi_nama', 150)->nullable()->after('tipe_pendaftaran');
            $table->string('kategori_peserta', 100)->nullable()->after('institusi_nama');
            $table->string('kelas_unit', 100)->nullable()->after('kategori_peserta');
            $table->string('email_peserta', 100)->nullable()->after('no_telepon');
        });
    }

    public function down(): void
    {
        Schema::table('pasien', function (Blueprint $table) {
            $table->dropColumn(['tipe_pendaftaran', 'institusi_nama', 'kategori_peserta', 'kelas_unit', 'email_peserta']);
        });
    }
};
