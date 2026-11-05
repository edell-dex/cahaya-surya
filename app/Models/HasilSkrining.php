<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilSkrining extends Model
{
    use HasFactory;

    protected $table = 'hasil_skrining';

    protected $fillable = [
        'pasien_id', 'user_id', 'tipe', 'tanggal_periksa',
        'alat_dipakai',
        // Siswa
        'refraksi_od_spheris', 'refraksi_od_cylinder', 'refraksi_od_axis',
        'refraksi_os_spheris', 'refraksi_os_cylinder', 'refraksi_os_axis',
        'tio_od', 'tio_os', 'buta_warna', 'retina_ai_catatan', 'catatan_dokter',
        // Karyawan
        'gula_darah', 'kolesterol_total', 'asam_urat',
        'abi_kanan', 'abi_kiri', 'abi_interpretasi',
        'ecg_irama', 'ecg_detak', 'ecg_catatan',
        'mata_od_status', 'mata_od_keterangan', 'mata_os_status', 'mata_os_keterangan',
        'mata_vaskular_retina', 'otak_risiko', 'otak_catatan',
        'kesimpulan_umum', 'rekomendasi_gaya_hidup', 'rekomendasi_rujukan',
    ];

    protected $casts = [
        'tanggal_periksa'        => 'date',
        'alat_dipakai'           => 'array',
        'kesimpulan_umum'        => 'array',
        'rekomendasi_gaya_hidup' => 'array',
        'rekomendasi_rujukan'    => 'array',
    ];

    // Relasi ke pasien
    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

    // Relasi ke user (yang mengisi form)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Keterangan status gula darah
    public function getStatusGulaDarahAttribute(): ?string
    {
        if (!$this->gula_darah) return null;
        return $this->gula_darah < 140 ? 'Normal' : ($this->gula_darah < 200 ? 'Pra-Diabetes' : 'Tinggi');
    }

    // Keterangan status kolesterol
    public function getStatusKolesterolAttribute(): ?string
    {
        if (!$this->kolesterol_total) return null;
        return $this->kolesterol_total < 200 ? 'Normal' : ($this->kolesterol_total < 240 ? 'Tinggi' : 'Sangat Tinggi');
    }

    // Keterangan status asam urat
    public function getStatusAsamUratAttribute(): ?string
    {
        if (!$this->asam_urat) return null;
        return $this->asam_urat < 7.0 ? 'Normal' : 'Tinggi';
    }

    // TIO normal range check
    public function getTioOdStatusAttribute(): ?string
    {
        if (!$this->tio_od) return null;
        return ($this->tio_od >= 10 && $this->tio_od <= 21) ? 'Normal' : 'Abnormal';
    }

    public function getTioOsStatusAttribute(): ?string
    {
        if (!$this->tio_os) return null;
        return ($this->tio_os >= 10 && $this->tio_os <= 21) ? 'Normal' : 'Abnormal';
    }
}
