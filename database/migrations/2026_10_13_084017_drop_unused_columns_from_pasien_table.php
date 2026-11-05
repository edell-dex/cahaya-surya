<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pasien', function (Blueprint $table) {
            $unusedColumns = [
                'golongan_darah',
                'tekanan_darah_sistolik',
                'tekanan_darah_diastolik',
                'berat_badan',
                'tinggi_badan',
                'imt',
                'gula_darah',
                'kolesterol',
                'merokok',
                'status_pasien',
            ];

            foreach ($unusedColumns as $column) {
                if (Schema::hasColumn('pasien', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pasien', function (Blueprint $table) {
            $table->enum('golongan_darah', ['A', 'B', 'AB', 'O', 'Tidak Tahu'])->default('Tidak Tahu');
            $table->integer('tekanan_darah_sistolik')->nullable();
            $table->integer('tekanan_darah_diastolik')->nullable();
            $table->decimal('berat_badan', 5, 2)->nullable();
            $table->decimal('tinggi_badan', 5, 2)->nullable();
            $table->decimal('imt', 5, 2)->nullable();
            $table->decimal('gula_darah', 6, 2)->nullable();
            $table->decimal('kolesterol', 6, 2)->nullable();
            $table->enum('merokok', ['Tidak', 'Ya, aktif', 'Pernah/berhenti'])->default('Tidak');
            $table->enum('status_pasien', ['Baru', 'Lama'])->default('Baru');
        });
    }
};
