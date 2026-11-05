<?php

namespace Database\Factories;

use App\Models\Pasien;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pasien>
 */
class PasienFactory extends Factory
{
    protected $model = Pasien::class;

    public function definition(): array
    {
        $tipe = fake()->randomElement(['sekolah', 'perusahaan']);
        $prefix = $tipe === 'sekolah' ? 'SEK' : 'CORP';
        return [
            'no_antrian'        => $prefix . '-' . now()->format('Ymd') . '-' . fake()->unique()->numerify('#####'),
            'tanggal_daftar'    => today(),
            'tipe_pendaftaran'  => $tipe,
            'institusi_nama'    => fake()->company(),
            'kategori_peserta'  => $tipe === 'sekolah' ? 'Siswa / Siswi' : 'Karyawan / Pegawai',
            'kelas_unit'        => $tipe === 'sekolah' ? 'X MIPA 1' : 'Divisi Operasional',
            'nama_lengkap'      => fake()->name(),
            'nik'               => fake()->numerify('3313############'),
            'tempat_lahir'      => fake()->city(),
            'tanggal_lahir'     => fake()->date('Y-m-d', '-15 years'),
            'jenis_kelamin'     => fake()->randomElement(['Laki-laki', 'Perempuan']),
            'no_telepon'        => fake()->phoneNumber(),
            'email_peserta'     => fake()->safeEmail(),
            'alamat'            => fake()->address(),
            'pekerjaan'         => $tipe === 'sekolah' ? 'Pelajar' : 'Karyawan',
            'poli_tujuan'       => $tipe === 'sekolah' ? 'Mata' : 'Jantung',
            'status_verifikasi' => 'Menunggu',
        ];
    }
}
