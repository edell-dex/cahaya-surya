<?php

namespace Tests\Feature;

use App\Models\HasilSkrining;
use App\Models\Pasien;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class HasilSkriningTest extends TestCase
{
    use DatabaseTransactions;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::where('role', 'admin')->first() ?? User::factory()->create(['role' => 'admin']);
    }

    /** @test */
    public function guest_tidak_bisa_mengakses_halaman_skrining()
    {
        $response = $this->get(route('admin.skrining.index'));
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function admin_dapat_mencari_pasien_dengan_kode_antrian_untuk_autofill()
    {
        $pasien = Pasien::factory()->create([
            'no_antrian'        => 'SEK-20261019-999',
            'nama_lengkap'      => 'Budi Siswa Test',
            'nik'               => '3313010101019999',
            'tipe_pendaftaran'  => 'sekolah',
            'institusi_nama'    => 'SMA N 1 Karanganyar',
            'kategori_peserta'  => 'Siswa / Siswi',
        ]);

        $response = $this->actingAs($this->admin)->getJson(route('admin.skrining.cariPasien', [
            'no_antrian' => 'SEK-20261019-999'
        ]));

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'pasien'  => [
                'id'           => $pasien->id,
                'no_antrian'   => 'SEK-20261019-999',
                'nama_lengkap' => 'Budi Siswa Test',
                'tipe'         => 'sekolah',
                'institusi'    => 'SMA N 1 Karanganyar',
            ],
        ]);
    }

    /** @test */
    public function admin_dapat_menyimpan_hasil_skrining_siswa_dan_tercatat_staff_pengisi()
    {
        $pasien = Pasien::factory()->create([
            'tipe_pendaftaran'  => 'sekolah',
            'status_verifikasi' => 'Menunggu',
        ]);

        $payload = [
            'pasien_id'            => $pasien->id,
            'tipe'                 => 'sekolah',
            'tanggal_periksa'      => date('Y-m-d'),
            'refraksi_od_spheris'  => '-1.50',
            'refraksi_od_cylinder' => '-0.50',
            'refraksi_od_axis'     => '90',
            'refraksi_os_spheris'  => '-1.00',
            'refraksi_os_cylinder' => '0.00',
            'refraksi_os_axis'     => '180',
            'tio_od'               => '15.5',
            'tio_os'               => '16.0',
            'buta_warna'           => 'Normal',
            'retina_ai_catatan'    => 'Saraf dan retina normal.',
            'catatan_dokter'       => 'Resep kacamata minus ringan.',
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.skrining.store'), $payload);

        $this->assertDatabaseHas('hasil_skrining', [
            'pasien_id'           => $pasien->id,
            'user_id'             => $this->admin->id,
            'tipe'                => 'sekolah',
            'refraksi_od_spheris' => '-1.50',
            'buta_warna'          => 'Normal',
        ]);

        // Pasien otomatis diverifikasi
        $pasien->refresh();
        $this->assertEquals('Diverifikasi', $pasien->status_verifikasi);

        $hasil = HasilSkrining::where('pasien_id', $pasien->id)->first();
        $response->assertRedirect(route('admin.skrining.show', $hasil));
    }

    /** @test */
    public function admin_dapat_menyimpan_hasil_skrining_karyawan_dan_tercatat_staff_pengisi()
    {
        $pasien = Pasien::factory()->create([
            'tipe_pendaftaran'  => 'perusahaan',
            'status_verifikasi' => 'Menunggu',
        ]);

        $payload = [
            'pasien_id'              => $pasien->id,
            'tipe'                   => 'perusahaan',
            'tanggal_periksa'        => date('Y-m-d'),
            'gula_darah'             => 110,
            'kolesterol_total'       => 230,
            'asam_urat'              => 6.5,
            'abi_kanan'              => 1.05,
            'abi_kiri'               => 1.02,
            'abi_interpretasi'       => 'Normal',
            'ecg_irama'              => 'Normal Sinus Rhythm',
            'ecg_detak'              => 76,
            'ecg_catatan'            => 'Irama jantung normal.',
            'mata_od_status'         => 'Normal',
            'mata_os_status'         => 'Normal',
            'mata_vaskular_retina'   => 'Pembuluh retina baik.',
            'otak_risiko'            => 'Rendah',
            'otak_catatan'           => 'Suplai darah ke otak aman.',
            'kesimpulan_umum'        => ['Pemantauan Berkala (Risiko Sedang)'],
            'rekomendasi_gaya_hidup' => ['Kurangi makanan berlemak tinggi'],
            'rekomendasi_rujukan'    => ['Cek ulang kolesterol 1 bulan lagi'],
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.skrining.store'), $payload);

        $this->assertDatabaseHas('hasil_skrining', [
            'pasien_id'        => $pasien->id,
            'user_id'          => $this->admin->id,
            'tipe'             => 'perusahaan',
            'kolesterol_total' => 230,
            'ecg_detak'        => 76,
        ]);

        $pasien->refresh();
        $this->assertEquals('Diverifikasi', $pasien->status_verifikasi);

        $hasil = HasilSkrining::where('pasien_id', $pasien->id)->first();
        $response->assertRedirect(route('admin.skrining.show', $hasil));
    }

    /** @test */
    public function admin_dapat_download_pdf_hasil_skrining_siswa()
    {
        $pasien = Pasien::factory()->create(['tipe_pendaftaran' => 'sekolah']);
        $skrining = HasilSkrining::create([
            'pasien_id'       => $pasien->id,
            'user_id'         => $this->admin->id,
            'tipe'            => 'sekolah',
            'tanggal_periksa' => date('Y-m-d'),
            'refraksi_od_spheris' => '-0.75',
            'tio_od'          => 15.0,
            'tio_os'          => 15.0,
            'buta_warna'      => 'Normal',
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.skrining.pdf', $skrining));
        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
    }

    /** @test */
    public function admin_dapat_download_pdf_hasil_skrining_karyawan()
    {
        $pasien = Pasien::factory()->create(['tipe_pendaftaran' => 'perusahaan']);
        $skrining = HasilSkrining::create([
            'pasien_id'          => $pasien->id,
            'user_id'            => $this->admin->id,
            'tipe'               => 'perusahaan',
            'tanggal_periksa'    => date('Y-m-d'),
            'gula_darah'         => 105,
            'kolesterol_total'   => 190,
            'asam_urat'          => 5.8,
            'abi_kanan'          => 1.05,
            'abi_kiri'           => 1.05,
            'abi_interpretasi'   => 'Normal',
            'ecg_irama'          => 'Normal Sinus Rhythm',
            'ecg_detak'          => 72,
            'mata_od_status'     => 'Normal',
            'mata_os_status'     => 'Normal',
            'otak_risiko'        => 'Rendah',
            'kesimpulan_umum'    => ['Kondisi Sehat / Risiko Rendah'],
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.skrining.pdf', $skrining));
        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
    }
}
