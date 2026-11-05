<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;

    protected $table = 'pasien';

    protected $fillable = [
        'no_antrian', 'tanggal_daftar', 'tipe_pendaftaran',
        'institusi_nama', 'kategori_peserta', 'kelas_unit', 'email_peserta',
        'nama_lengkap', 'nik', 'tempat_lahir', 'tanggal_lahir',
        'jenis_kelamin', 'alamat', 'no_telepon', 'pekerjaan', 'pendidikan',
        'riwayat_penyakit', 'riwayat_keluarga', 'keluhan_utama',
        'poli_tujuan', 'status_verifikasi', 'catatan_admin',
    ];

    protected $casts = [
        'tanggal_daftar' => 'date',
        'tanggal_lahir'  => 'date',
    ];

    // Relasi ke hasil skrining
    public function hasilSkrining()
    {
        return $this->hasOne(HasilSkrining::class);
    }

    // Generate queue number: SEK-YYYYMMDD-NNN or CORP-YYYYMMDD-NNN
    public static function generateNoAntrian(string $tipe = 'perusahaan'): string
    {
        $today = now()->format('Ymd');
        $prefix = ($tipe === 'sekolah') ? 'SEK' : 'CORP';
        $latest = self::where('no_antrian', 'like', $prefix . '-' . $today . '-%')
                      ->orderBy('id', 'desc')
                      ->first();

        $num = 1;
        if ($latest && preg_match('/-(\d+)$/', $latest->no_antrian, $m)) {
            $num = (int)$m[1] + 1;
        }

        while (self::where('no_antrian', $prefix . '-' . $today . '-' . str_pad($num, 3, '0', STR_PAD_LEFT))->exists()) {
            $num++;
        }

        return $prefix . '-' . $today . '-' . str_pad($num, 3, '0', STR_PAD_LEFT);
    }

    // Riwayat penyakit as array
    public function getRiwayatPenyakitArrayAttribute(): array
    {
        return $this->riwayat_penyakit ? explode(',', $this->riwayat_penyakit) : [];
    }

    // Riwayat keluarga as array
    public function getRiwayatKeluargaArrayAttribute(): array
    {
        return $this->riwayat_keluarga ? explode(',', $this->riwayat_keluarga) : [];
    }

    // Status badge color
    public function getStatusBadgeClassAttribute(): string
    {
        return match($this->status_verifikasi) {
            'Diverifikasi' => 'badge-diverifikasi',
            'Ditolak'      => 'badge-ditolak',
            default        => 'badge-menunggu',
        };
    }

    // Age from date of birth
    public function getUsiaAttribute(): ?int
    {
        return $this->tanggal_lahir ? $this->tanggal_lahir->age : null;
    }

    // Formatted tanggal daftar in Indonesian
    public function getTanggalDaftarFormatAttribute(): string
    {
        $bulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        return $this->tanggal_daftar->day . ' ' . $bulan[$this->tanggal_daftar->month] . ' ' . $this->tanggal_daftar->year;
    }
}
