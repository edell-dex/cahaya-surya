<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hasil_skrining', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasien_id')->constrained('pasien')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('tipe', ['sekolah', 'perusahaan']);
            $table->date('tanggal_periksa');

            // =============================================
            // SISWA: Pemeriksaan Refraksi Lengkap
            // =============================================
            $table->string('refraksi_od_spheris', 20)->nullable();
            $table->string('refraksi_od_cylinder', 20)->nullable();
            $table->string('refraksi_od_axis', 20)->nullable();
            $table->string('refraksi_os_spheris', 20)->nullable();
            $table->string('refraksi_os_cylinder', 20)->nullable();
            $table->string('refraksi_os_axis', 20)->nullable();

            // SISWA: Tekanan Bola Mata (TIO)
            $table->decimal('tio_od', 5, 2)->nullable(); // mmHg
            $table->decimal('tio_os', 5, 2)->nullable(); // mmHg

            // SISWA: Skrining Buta Warna
            $table->enum('buta_warna', ['Normal', 'Parsial', 'Total'])->nullable();

            // SISWA: Skrining Retina Digital AI
            $table->text('retina_ai_catatan')->nullable();

            // SISWA: Catatan Dokter Spesialis Mata
            $table->text('catatan_dokter')->nullable();

            // =============================================
            // KARYAWAN: Pemeriksaan Metabolik
            // =============================================
            $table->decimal('gula_darah', 7, 2)->nullable();      // mg/dL
            $table->decimal('kolesterol_total', 7, 2)->nullable(); // mg/dL
            $table->decimal('asam_urat', 6, 2)->nullable();        // mg/dL

            // KARYAWAN: Skrining Vaskuler (ABI)
            $table->decimal('abi_kanan', 5, 3)->nullable();
            $table->decimal('abi_kiri', 5, 3)->nullable();
            $table->enum('abi_interpretasi', ['Normal', 'Borderline', 'Indikasi PAD'])->nullable();

            // KARYAWAN: Skrining Jantung (ECG)
            $table->enum('ecg_irama', ['Normal Sinus Rhythm', 'Atrial Fibrillation (AFib)', 'Lainnya'])->nullable();
            $table->integer('ecg_detak')->nullable(); // BPM
            $table->text('ecg_catatan')->nullable();

            // KARYAWAN: Skrining Mata (EyeRobo)
            $table->enum('mata_od_status', ['Normal', 'Kelainan'])->nullable();
            $table->string('mata_od_keterangan', 255)->nullable();
            $table->enum('mata_os_status', ['Normal', 'Kelainan'])->nullable();
            $table->string('mata_os_keterangan', 255)->nullable();
            $table->text('mata_vaskular_retina')->nullable();

            // KARYAWAN: Skrining Otak
            $table->enum('otak_risiko', ['Rendah', 'Sedang', 'Tinggi'])->nullable();
            $table->text('otak_catatan')->nullable();

            // KARYAWAN: Kesimpulan & Rekomendasi (JSON arrays)
            $table->json('kesimpulan_umum')->nullable();
            $table->json('rekomendasi_gaya_hidup')->nullable();
            $table->json('rekomendasi_rujukan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hasil_skrining');
    }
};
