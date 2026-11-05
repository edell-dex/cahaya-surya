<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pasien', function (Blueprint $table) {
            $table->id();
            $table->string('no_antrian', 30)->unique();
            $table->date('tanggal_daftar');

            // Data Umum
            $table->string('nama_lengkap', 150);
            $table->string('nik', 16);
            $table->string('tempat_lahir', 100)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->text('alamat')->nullable();
            $table->string('no_telepon', 20)->nullable();
            $table->string('pekerjaan', 100)->nullable();
            $table->enum('pendidikan', ['Tidak Sekolah', 'SD', 'SMP', 'SMA/SMK', 'D1/D2/D3', 'S1', 'S2/S3'])->default('SMA/SMK');

            // Data Kesehatan Vaskuler
            $table->enum('golongan_darah', ['A', 'B', 'AB', 'O', 'Tidak Tahu'])->default('Tidak Tahu');
            $table->integer('tekanan_darah_sistolik')->nullable()->comment('mmHg');
            $table->integer('tekanan_darah_diastolik')->nullable()->comment('mmHg');
            $table->decimal('berat_badan', 5, 2)->nullable()->comment('kg');
            $table->decimal('tinggi_badan', 5, 2)->nullable()->comment('cm');
            $table->decimal('imt', 5, 2)->nullable()->comment('kg/m2');
            $table->decimal('gula_darah', 6, 2)->nullable()->comment('mg/dL');
            $table->decimal('kolesterol', 6, 2)->nullable()->comment('mg/dL');
            $table->enum('merokok', ['Tidak', 'Ya, aktif', 'Pernah/berhenti'])->default('Tidak');
            $table->string('riwayat_penyakit', 255)->nullable();
            $table->string('riwayat_keluarga', 255)->nullable();
            $table->text('keluhan_utama')->nullable();
            $table->enum('poli_tujuan', ['Umum', 'Penyakit Dalam', 'Jantung', 'Saraf', 'Bedah', 'Gigi', 'Mata', 'THT', 'Kandungan', 'Anak'])->default('Umum');
            $table->enum('status_pasien', ['Baru', 'Lama'])->default('Baru');

            // Admin
            $table->enum('status_verifikasi', ['Menunggu', 'Diverifikasi', 'Ditolak'])->default('Menunggu');
            $table->text('catatan_admin')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pasien');
    }
};
