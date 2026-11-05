<?php

namespace Tests\Feature;

use App\Models\Pasien;
use App\Models\User;
use Tests\TestCase;

class HospitalRegistrationFlowTest extends TestCase
{
    /** @test */
    public function calon_peserta_sekolah_dapat_mendaftar()
    {
        $payload = [
            'institusi_nama'   => 'SMA Negeri 1 Karanganyar',
            'kategori_peserta' => 'Siswa / Siswi',
            'kelas_unit'       => 'XII MIPA 3',
            'nama_lengkap'     => 'Ananda Pratama',
            'nik'              => '3313010101010001',
            'tempat_lahir'     => 'Karanganyar',
            'tanggal_lahir'    => '2007-08-17',
            'jenis_kelamin'    => 'Laki-laki',
            'no_telepon'       => '081234567890',
            'email_peserta'    => 'ananda@sekolah.sch.id',
            'nama_wali'        => 'Bambang Pratama',
            'riwayat_penyakit' => [
                'Menggunakan Kacamata / Lensa Kontak saat ini',
                'Penglihatan buram / kabur melihat papan tulis atau jauh',
                'Mata sering lelah / pusing saat membaca atau melihat gawai (gadget)',
                'Mata sering merah, gatal, atau berair',
                'Riwayat infeksi / iritasi mata berulang',
                'Riwayat cedera / trauma pada mata',
                'Sulit membedakan warna tertentu',
                'Sensitif berlebihan terhadap cahaya (silau)'
            ],
            'persetujuan'      => '1',
        ];

        $response = $this->post(route('pendaftaran.storeSekolah'), $payload);

        $pasien = Pasien::where('nik', '3313010101010001')->latest('id')->first();
        $this->assertNotNull($pasien);
        $this->assertEquals('sekolah', $pasien->tipe_pendaftaran);
        $this->assertEquals('SMA Negeri 1 Karanganyar', $pasien->institusi_nama);
        $this->assertStringStartsWith('SEK-', $pasien->no_antrian);

        $response->assertRedirect(route('pendaftaran.sukses', $pasien->id));
    }

    /** @test */
    public function karyawan_perusahaan_dapat_mendaftar()
    {
        $payload = [
            'institusi_nama'          => 'PT. Industri Surya Mandiri',
            'kelas_unit'              => 'Divisi HR & Operasional',
            'pekerjaan'               => 'Staff Administrasi',
            'nama_lengkap'            => 'Budi Wijaya',
            'nik'                     => '3313020202020002',
            'tempat_lahir'            => 'Solo',
            'tanggal_lahir'           => '1988-12-10',
            'jenis_kelamin'           => 'Laki-laki',
            'no_telepon'              => '082198765432',
            'email_peserta'           => 'budi@industrisurya.co.id',
            'alamat'                  => 'Jl. Lawu No. 100, Jaten, Karanganyar',
            'riwayat_penyakit'        => ['Kolesterol Tinggi'],
            'riwayat_keluarga'        => ['Hipertensi'],
            'keluhan_utama'           => 'Pemeriksaan rutin kesehatan vaskuler tahunan perusahaan',
            'persetujuan'             => '1',
        ];

        $response = $this->post(route('pendaftaran.storePerusahaan'), $payload);

        $pasien = Pasien::where('nik', '3313020202020002')->latest('id')->first();
        $this->assertNotNull($pasien);
        $this->assertEquals('perusahaan', $pasien->tipe_pendaftaran);
        $this->assertEquals('PT. Industri Surya Mandiri', $pasien->institusi_nama);
        $this->assertStringStartsWith('CORP-', $pasien->no_antrian);

        $response->assertRedirect(route('pendaftaran.sukses', $pasien->id));
    }

    /** @test */
    public function admin_dapat_melihat_data_pasien()
    {
        $admin = User::where('email', 'admin@cahayasurya.com')->first();
        $this->assertNotNull($admin);

        $response = $this->actingAs($admin)->get(route('admin.pasien.index'));
        $response->assertStatus(200);
    }

    /** @test */
    public function admin_dapat_download_excel_pasien()
    {
        $admin = User::where('email', 'admin@cahayasurya.com')->first();
        $this->assertNotNull($admin);

        $response = $this->actingAs($admin)->get(route('admin.pasien.export'));
        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    }

    /** @test */
    public function admin_dapat_download_excel_pasien_dengan_filter_tanggal()
    {
        $admin = User::where('email', 'admin@cahayasurya.com')->first();
        $this->assertNotNull($admin);

        $today = date('Y-m-d');
        $response = $this->actingAs($admin)->get(route('admin.pasien.export', ['tanggal' => $today]));
        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    }
}
