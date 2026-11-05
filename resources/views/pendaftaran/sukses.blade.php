@extends('layouts.public')
@section('title', 'Pendaftaran Berhasil')

@section('content')
<style>
.success-body { background:#f0f4f8; min-height:calc(100vh - 70px); display:flex; align-items:center; }
.success-card { background:#fff; border-radius:20px; padding:40px 32px; box-shadow:0 4px 24px rgba(26,60,94,.12); }
.info-card    { background:#f8fafc; border-radius:12px; padding:16px; border:1px solid #e2e8f0; }
</style>

<div class="success-body py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="success-card text-center">
                    {{-- Animated Checkmark --}}
                    <div class="mb-4">
                        <div style="width:90px;height:90px;border-radius:50%;background:rgba(22,163,74,.1);display:flex;align-items:center;justify-content:center;margin:0 auto;">
                            <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                                <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
                                <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                            </svg>
                        </div>
                    </div>

                    <h2 class="fw-bold text-success mb-2">Pendaftaran Berhasil!</h2>
                    <p class="text-muted mb-4">Data Anda telah tersimpan. Harap simpan nomor antrian berikut.</p>

                    {{-- Queue Number --}}
                    <div class="queue-card mb-4">
                        <div class="queue-lbl">NOMOR ANTRIAN ANDA</div>
                        <div class="queue-num">{{ $pasien->no_antrian }}</div>
                        <div class="queue-date">{{ $pasien->tanggal_daftar_format }}</div>
                    </div>

                    {{-- Patient Info --}}
                    <div class="info-card mb-4 text-start">
                        <table class="table table-borderless mb-0 small">
                            <tr>
                                <td class="text-muted py-1" width="38%"><i class="bi bi-tag me-1"></i>Program</td>
                                <td class="fw-bold py-1">
                                    @if($pasien->tipe_pendaftaran === 'sekolah')
                                    <span class="badge bg-primary">Skrining Sekolah (Mata)</span>
                                    @else
                                    <span class="badge bg-teal" style="background:#0d9488">Skrining Perusahaan (Vaskuler)</span>
                                    @endif
                                </td>
                            </tr>
                            @if($pasien->institusi_nama)
                            <tr>
                                <td class="text-muted py-1">
                                    <i class="bi bi-building me-1"></i>{{ $pasien->tipe_pendaftaran === 'sekolah' ? 'Sekolah' : 'Perusahaan' }}
                                </td>
                                <td class="fw-medium py-1">: {{ $pasien->institusi_nama }} {{ $pasien->kelas_unit ? '(' . $pasien->kelas_unit . ')' : '' }}</td>
                            </tr>
                            @endif
                            <tr>
                                <td class="text-muted py-1"><i class="bi bi-person me-1"></i>Nama Lengkap</td>
                                <td class="fw-medium py-1">: {{ $pasien->nama_lengkap }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted py-1"><i class="bi bi-card-text me-1"></i>NIK / ID</td>
                                <td class="fw-medium py-1">: {{ $pasien->nik }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted py-1"><i class="bi bi-clipboard2-pulse me-1"></i>Pemeriksaan</td>
                                <td class="fw-medium py-1">: {{ $pasien->poli_tujuan }}</td>
                            </tr>
                        </table>
                    </div>

                    {{-- Instructions --}}
                    <div class="alert alert-warning border-0 text-start mb-4">
                        <h6 class="fw-bold small"><i class="bi bi-exclamation-triangle me-2"></i>Petunjuk Selanjutnya:</h6>
                        <ol class="mb-0 ps-3" style="font-size:.85rem;">
                            <li>Catat atau <strong>screenshot</strong> nomor antrian Anda.</li>
                            <li>Datang ke klinik sesuai jadwal.</li>
                            <li>Tunjukkan nomor antrian kepada petugas pendaftaran.</li>
                            <li>Bawa <strong>KTP/kartu identitas asli</strong> untuk verifikasi.</li>
                        </ol>
                    </div>

                    <div class="d-flex gap-2 justify-content-center flex-wrap no-print">
                        <button onclick="window.print()" class="btn btn-outline-primary">
                            <i class="bi bi-printer me-1"></i>Cetak Bukti
                        </button>
                        <a href="{{ route('pendaftaran.index') }}" class="btn btn-primary">
                            <i class="bi bi-house me-1"></i>Kembali ke Beranda
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
