<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Rules\Turnstile;
use Illuminate\Http\Request;

class PasienController extends Controller
{
    // Halaman utama (Layanan + Pilihan Pendaftaran Sekolah vs Perusahaan)
    public function index()
    {
        return view('pendaftaran.index');
    }

    // Form Pendaftaran Sekolah (Gambar 1: Skrining Kesehatan Mata Sekolah)
    public function createSekolah()
    {
        return view('pendaftaran.sekolah');
    }

    // Submit Pendaftaran Sekolah
    public function storeSekolah(Request $request)
    {
        $validated = $request->validate([
            'institusi_nama'    => 'required|string|max:150',
            'kategori_peserta'  => 'required|string',
            'kelas_unit'        => 'nullable|string|max:100',
            'nama_lengkap'      => 'required|string|max:150',
            'nik'               => 'required|digits:16',
            'tempat_lahir'      => 'nullable|string|max:100',
            'tanggal_lahir'     => 'nullable|date|before:today',
            'jenis_kelamin'     => 'required|in:Laki-laki,Perempuan',
            'no_telepon'        => 'required|string|max:20',
            'email_peserta'     => 'nullable|email|max:100',
            'nama_wali'         => 'nullable|string|max:150',
            'riwayat_penyakit'      => 'nullable|array',
            'persetujuan'           => 'required|accepted',
            'cf-turnstile-response' => [app()->environment('testing') ? 'nullable' : 'required', new Turnstile],
        ], [
            'institusi_nama.required'        => 'Nama sekolah / lembaga wajib diisi.',
            'kategori_peserta.required'      => 'Kategori peserta wajib dipilih.',
            'nama_lengkap.required'          => 'Nama lengkap peserta wajib diisi.',
            'nik.required'                   => 'NISN / NIP / NIK wajib diisi.',
            'nik.digits'                     => 'NISN / NIP / NIK harus berupa 16 digit angka.',
            'jenis_kelamin.required'         => 'Jenis kelamin wajib dipilih.',
            'no_telepon.required'            => 'Nomor WhatsApp / HP wajib diisi.',
            'persetujuan.required'           => 'Pernyataan persetujuan wajib disetujui.',
            'persetujuan.accepted'           => 'Pernyataan persetujuan wajib disetujui.',
            'cf-turnstile-response.required' => 'Verifikasi keamanan Cloudflare wajib diselesaikan.',
        ]);

        $waliNote = $request->nama_wali ? ' | Nama Wali: ' . $request->nama_wali : '';

        $pasien = Pasien::create([
            'no_antrian'        => Pasien::generateNoAntrian('sekolah'),
            'tanggal_daftar'    => today(),
            'tipe_pendaftaran'  => 'sekolah',
            'institusi_nama'    => $validated['institusi_nama'],
            'kategori_peserta'  => $validated['kategori_peserta'],
            'kelas_unit'        => $validated['kelas_unit'] ?? null,
            'nama_lengkap'      => $validated['nama_lengkap'],
            'nik'               => $validated['nik'],
            'tempat_lahir'      => $validated['tempat_lahir'] ?? null,
            'tanggal_lahir'     => $validated['tanggal_lahir'] ?? null,
            'jenis_kelamin'     => $validated['jenis_kelamin'],
            'no_telepon'        => $validated['no_telepon'],
            'email_peserta'     => $validated['email_peserta'] ?? null,
            'alamat'            => 'Sekolah: ' . $validated['institusi_nama'] . ($validated['kelas_unit'] ? ' (' . $validated['kelas_unit'] . ')' : '') . $waliNote,
            'pekerjaan'         => $validated['kategori_peserta'],
            'poli_tujuan'       => 'Mata',
            'riwayat_penyakit'  => !empty($validated['riwayat_penyakit']) ? implode(',', $validated['riwayat_penyakit']) : null,
            'status_verifikasi' => 'Menunggu',
        ]);

        return redirect()->route('pendaftaran.sukses', $pasien->id)->with('sukses', true);
    }

    // Form Pendaftaran Perusahaan (Flyer Gambar 2 & PDF: Skrining Vaskuler Perusahaan)
    public function createPerusahaan()
    {
        return view('pendaftaran.perusahaan');
    }

    // Submit Pendaftaran Perusahaan
    public function storePerusahaan(Request $request)
    {
        $validated = $request->validate([
            'institusi_nama'          => 'required|string|max:150',
            'kelas_unit'              => 'nullable|string|max:100', // Divisi / Departemen
            'pekerjaan'               => 'nullable|string|max:100', // Jabatan
            'nama_lengkap'            => 'required|string|max:150',
            'nik'                     => 'required|digits:16',
            'tempat_lahir'            => 'nullable|string|max:100',
            'tanggal_lahir'           => 'nullable|date|before:today',
            'jenis_kelamin'           => 'required|in:Laki-laki,Perempuan',
            'no_telepon'              => 'required|string|max:20',
            'email_peserta'           => 'nullable|email|max:100',
            'alamat'                  => 'nullable|string',
            'riwayat_penyakit'        => 'nullable|array',
            'riwayat_keluarga'        => 'nullable|array',
            'keluhan_utama'           => 'nullable|string|max:1000',
            'persetujuan'             => 'required|accepted',
            'cf-turnstile-response'   => [app()->environment('testing') ? 'nullable' : 'required', new Turnstile],
        ], [
            'institusi_nama.required'        => 'Nama perusahaan / instansi wajib diisi.',
            'nama_lengkap.required'          => 'Nama lengkap karyawan wajib diisi.',
            'nik.required'                   => 'NIK / No. KTP wajib diisi.',
            'nik.digits'                     => 'NIK harus tepat 16 digit angka.',
            'jenis_kelamin.required'         => 'Jenis kelamin wajib dipilih.',
            'no_telepon.required'            => 'No. WhatsApp / HP aktif wajib diisi.',
            'persetujuan.required'           => 'Pernyataan persetujuan wajib disetujui.',
            'persetujuan.accepted'           => 'Pernyataan persetujuan wajib disetujui.',
            'cf-turnstile-response.required' => 'Verifikasi keamanan Cloudflare wajib diselesaikan.',
        ]);

        $pasien = Pasien::create([
            'no_antrian'              => Pasien::generateNoAntrian('perusahaan'),
            'tanggal_daftar'          => today(),
            'tipe_pendaftaran'        => 'perusahaan',
            'institusi_nama'          => $validated['institusi_nama'],
            'kategori_peserta'        => 'Karyawan / Pegawai',
            'kelas_unit'              => $validated['kelas_unit'] ?? null,
            'nama_lengkap'            => $validated['nama_lengkap'],
            'nik'                     => $validated['nik'],
            'tempat_lahir'            => $validated['tempat_lahir'] ?? null,
            'tanggal_lahir'           => $validated['tanggal_lahir'] ?? null,
            'jenis_kelamin'           => $validated['jenis_kelamin'],
            'alamat'                  => $validated['alamat'] ?? null,
            'no_telepon'              => $validated['no_telepon'],
            'email_peserta'           => $validated['email_peserta'] ?? null,
            'pekerjaan'               => $validated['pekerjaan'] ?? 'Karyawan',
            'riwayat_penyakit'        => !empty($validated['riwayat_penyakit']) ? implode(',', $validated['riwayat_penyakit']) : null,
            'riwayat_keluarga'        => !empty($validated['riwayat_keluarga']) ? implode(',', $validated['riwayat_keluarga']) : null,
            'keluhan_utama'           => $validated['keluhan_utama'] ?? null,
            'poli_tujuan'             => 'Jantung',
            'status_verifikasi'       => 'Menunggu',
        ]);

        return redirect()->route('pendaftaran.sukses', $pasien->id)->with('sukses', true);
    }

    // Halaman sukses pendaftaran
    public function sukses(Pasien $pasien)
    {
        if (!session('sukses')) {
            return redirect()->route('pendaftaran.index');
        }
        return view('pendaftaran.sukses', compact('pasien'));
    }
}
