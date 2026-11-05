@extends('layouts.admin')
@section('title', 'Detail Hasil Skrining — ' . ($skrining->pasien->nama_lengkap ?? 'Pasien'))
@section('page-title', 'Detail Hasil Skrining')
@section('breadcrumb')
    <a href="{{ route('admin.skrining.index') }}">Hasil Skrining</a>
    <i class="bi bi-chevron-right" style="font-size:.7rem"></i> Detail
@endsection

@push('styles')
<style>
.detail-doc-card {
    background: #fff;
    border: 1px solid #cbd5e1;
    border-radius: 12px;
    box-shadow: 0 4px 16px rgba(0,0,0,.05);
    overflow: hidden;
    margin-bottom: 24px;
}
.detail-header-bar {
    padding: 16px 24px;
    color: #fff;
    font-weight: 700;
    font-size: 1.1rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 10px;
}
.detail-header-bar.siswa { background: #005a9c; }
.detail-header-bar.karyawan { background: linear-gradient(135deg, #0f766e, #115e59); }

.staff-info-banner {
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    border-radius: 8px;
    padding: 12px 18px;
    margin: 20px 24px 0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 10px;
}
.table-preview th {
    background: #f8fafc;
    color: #334155;
    font-size: .82rem;
    font-weight: 700;
    border: 1px solid #cbd5e1;
    padding: 8px 12px;
}
.table-preview td {
    border: 1px solid #cbd5e1;
    padding: 8px 12px;
    vertical-align: middle;
}
.section-tag {
    font-size: .92rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: .03em;
    padding-bottom: 6px;
    border-bottom: 2px solid #cbd5e1;
    margin-bottom: 14px;
}
.section-tag.blue { color: #005a9c; border-bottom-color: #005a9c; }
.section-tag.teal { color: #0f766e; border-bottom-color: #0f766e; }

.badge-normal { background: #dcfce7; color: #166534; font-weight: 700; padding: 4px 10px; border-radius: 6px; border: 1px solid #86efac; }
.badge-warning { background: #fef9c3; color: #854d0e; font-weight: 700; padding: 4px 10px; border-radius: 6px; border: 1px solid #fde047; }
.badge-danger { background: #fee2e2; color: #991b1b; font-weight: 700; padding: 4px 10px; border-radius: 6px; border: 1px solid #fca5a5; }
</style>
@endpush

@section('content')
<div class="container-fluid px-0">

    {{-- Action Bar --}}
    <div class="d-flex justify-content-between align-items-center mb-4 no-print flex-wrap gap-2">
        <a href="{{ route('admin.skrining.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>Kembali ke Daftar
        </a>
        <div class="d-flex gap-2">
            <button onclick="window.print()" class="btn btn-outline-secondary">
                <i class="bi bi-printer me-1"></i>Cetak Layar
            </button>
            <a href="{{ route('admin.skrining.pdf', $skrining) }}" class="btn btn-danger fw-bold shadow-sm px-4">
                <i class="bi bi-file-earmark-pdf-fill me-2"></i>Download PDF Resmi
            </a>
        </div>
    </div>

    <div class="detail-doc-card">
        {{-- Header Bar --}}
        <div class="detail-header-bar {{ $skrining->tipe }}">
            <div class="d-flex align-items-center gap-2">
                <i class="bi {{ $skrining->tipe === 'sekolah' ? 'bi-eye' : 'bi-heart-pulse' }}"></i>
                <span>{{ $skrining->tipe === 'sekolah' ? 'HASIL SKRINING KESEHATAN MATA (E-REPORT)' : 'HASIL SKRINING KESEHATAN VASKULER & METABOLIK (E-REPORT)' }}</span>
            </div>
            <span class="badge bg-white text-dark small">Kode: {{ $skrining->pasien->no_antrian }}</span>
        </div>

        {{-- Banner Akun Petugas / Staff yang mengisi form --}}
        <div class="staff-info-banner">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-person-check-fill text-success fs-5"></i>
                <div>
                    <span class="small text-muted d-block">Pemeriksaan ini diinput dan divalidasi oleh:</span>
                    <strong class="text-dark">{{ $skrining->user->name ?? 'Staff Petugas' }}</strong>
                    <span class="badge bg-secondary-subtle text-secondary ms-1">{{ strtoupper($skrining->user->role ?? 'Staff') }}</span>
                    <span class="text-muted small ms-2">({{ $skrining->user->email ?? '-' }})</span>
                </div>
            </div>
            <div class="text-end text-muted small">
                <div>Tanggal Input: <strong>{{ $skrining->created_at ? $skrining->created_at->format('d/m/Y H:i') : '-' }} WIB</strong></div>
                <div>Tanggal Pemeriksaan: <strong>{{ $skrining->tanggal_periksa ? $skrining->tanggal_periksa->format('d/m/Y') : '-' }}</strong></div>
            </div>
        </div>

        {{-- ========================================== --}}
        {{-- KONTEN DETAIL FORM SISWA                   --}}
        {{-- ========================================== --}}
        @if($skrining->tipe === 'sekolah')
        <div class="p-4">
            {{-- Patient Box --}}
            <div class="p-3 border rounded-3 bg-light mb-4">
                <div class="row g-2">
                    <div class="col-md-3"><span class="text-muted small">Nama Lengkap:</span><div class="fw-bold fs-6">{{ $skrining->pasien->nama_lengkap }}</div></div>
                    <div class="col-md-3"><span class="text-muted small">Peran / Kelas:</span><div class="fw-semibold">{{ $skrining->pasien->kategori_peserta ?? 'Siswa' }} ({{ $skrining->pasien->kelas_unit ?? '-' }})</div></div>
                    <div class="col-md-3"><span class="text-muted small">NIS / NIP / NIK:</span><div><code>{{ $skrining->pasien->nik }}</code></div></div>
                    <div class="col-md-3"><span class="text-muted small">Sekolah / Lembaga:</span><div class="fw-semibold">{{ $skrining->pasien->institusi_nama ?? '-' }}</div></div>
                </div>
            </div>

            {{-- A. HASIL PEMERIKSAAN KLINIS --}}
            <div class="section-tag blue">A. HASIL PEMERIKSAAN KLINIS</div>

            {{-- Alat yang Dipakai --}}
            @if($skrining->alat_dipakai && count($skrining->alat_dipakai))
            <div class="mb-4 p-3 border rounded-3" style="background:#eff6ff;border-color:#bfdbfe!important;">
                <div class="fw-bold small text-primary mb-2"><i class="bi bi-tools me-1"></i>Alat yang Dipakai:</div>
                <div class="d-flex flex-wrap gap-2">
                    @foreach($skrining->alat_dipakai as $alat)
                    <span class="badge" style="background:#1d4ed8;font-size:.8rem;font-weight:600;padding:6px 12px;">{{ $alat }}</span>
                    @endforeach
                </div>
            </div>
            @endif

            <h6 class="fw-bold mb-2">1. Pemeriksaan Refraksi Lengkap (Retinomax K-plus3)</h6>
            <div class="table-responsive mb-4">
                <table class="table table-preview mb-0">
                    <thead>
                        <tr>
                            <th style="width:25%;" class="text-center">Mata</th>
                            <th style="width:25%;" class="text-center">Spheris (Minus/Plus)</th>
                            <th style="width:25%;" class="text-center">Cylinder (Silinder)</th>
                            <th style="width:25%;" class="text-center">Axis</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="fw-bold text-center">Kanan (OD)</td>
                            <td class="text-center fw-semibold text-primary">{{ $skrining->refraksi_od_spheris ?: '-' }}</td>
                            <td class="text-center">{{ $skrining->refraksi_od_cylinder ?: '-' }}</td>
                            <td class="text-center">{{ $skrining->refraksi_od_axis ?: '-' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-center">Kiri (OS)</td>
                            <td class="text-center fw-semibold text-primary">{{ $skrining->refraksi_os_spheris ?: '-' }}</td>
                            <td class="text-center">{{ $skrining->refraksi_os_cylinder ?: '-' }}</td>
                            <td class="text-center">{{ $skrining->refraksi_os_axis ?: '-' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <div class="p-3 border rounded-3 h-100 bg-white">
                        <h6 class="fw-bold text-primary mb-3">2. Tekanan Bola Mata (iCare 100)</h6>
                        <div class="d-flex justify-content-between py-1 border-bottom">
                            <span>Mata Kanan (OD):</span>
                            <strong>{{ $skrining->tio_od ? $skrining->tio_od . ' mmHg' : '-' }}</strong>
                        </div>
                        <div class="d-flex justify-content-between py-1 border-bottom">
                            <span>Mata Kiri (OS):</span>
                            <strong>{{ $skrining->tio_os ? $skrining->tio_os . ' mmHg' : '-' }}</strong>
                        </div>
                        <small class="text-muted fst-italic mt-2 d-block">*Nilai normal: 10 - 21 mmHg</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 border rounded-3 h-100 bg-white">
                        <h6 class="fw-bold text-primary mb-3">3. Skrining Buta Warna (Munsell D15)</h6>
                        <div class="fs-6">
                            Status: <span class="badge bg-primary px-3 py-2 fs-6">{{ $skrining->buta_warna ?? 'Normal' }}</span>
                        </div>
                        <small class="text-muted d-block mt-2">
                            @if(($skrining->buta_warna ?? 'Normal') === 'Normal')
                                Tidak ditemukan indikasi gangguan penglihatan warna.
                            @elseif($skrining->buta_warna === 'Parsial')
                                Terdapat kecenderungan buta warna parsial / sebagian.
                            @else
                                Mengalami kesulitan membedakan spektrum warna secara menyeluruh.
                            @endif
                        </small>
                    </div>
                </div>
            </div>

            <div class="p-3 border rounded-3 bg-white mb-4">
                <h6 class="fw-bold text-primary mb-2">4. Skrining Retina Digital AI (EyeRobo AI Fundus Camera)</h6>
                <div class="p-2 bg-light rounded text-dark small" style="line-height:1.6;">
                    {{ $skrining->retina_ai_catatan ?: '-' }}
                </div>
            </div>

            {{-- B. KESIMPULAN & REKOMENDASI --}}
            <div class="section-tag blue">B. KESIMPULAN & REKOMENDASI</div>
            <div class="p-3 border rounded-3 bg-light mb-4" style="border-left: 4px solid #005a9c !important;">
                <h6 class="fw-bold text-dark mb-2">Catatan Dokter Spesialis Mata:</h6>
                <div style="line-height:1.7;white-space:pre-line;">
                    {{ $skrining->catatan_dokter ?: 'Pemeriksaan penglihatan selesai. Jaga jarak pandang membaca dan istirahatkan mata secara berkala setelah menatap gawai.' }}
                </div>
            </div>
        </div>

        {{-- ========================================== --}}
        {{-- KONTEN DETAIL FORM KARYAWAN               --}}
        {{-- ========================================== --}}
        @else
        <div class="p-4">
            {{-- Patient Box --}}
            <div class="section-tag teal">A. DATA KARYAWAN (PATIENT INFO)</div>
            <div class="p-3 border rounded-3 bg-light mb-4">
                <div class="row g-2">
                    <div class="col-md-4"><span class="text-muted small">Nama Lengkap:</span><div class="fw-bold fs-6">{{ $skrining->pasien->nama_lengkap }}</div></div>
                    <div class="col-md-4"><span class="text-muted small">Perusahaan:</span><div class="fw-semibold">{{ $skrining->pasien->institusi_nama ?? '-' }}</div></div>
                    <div class="col-md-4"><span class="text-muted small">ID Karyawan / NIK:</span><div><code>{{ $skrining->pasien->nik }}</code></div></div>
                    <div class="col-md-4"><span class="text-muted small">Departemen / Divisi:</span><div class="fw-semibold">{{ $skrining->pasien->kelas_unit ?? ($skrining->pasien->pekerjaan ?? '-') }}</div></div>
                    <div class="col-md-4"><span class="text-muted small">Usia / Jenis Kelamin:</span><div>{{ $skrining->pasien->usia ? $skrining->pasien->usia . ' Tahun' : '-' }} / {{ $skrining->pasien->jenis_kelamin }}</div></div>
                    <div class="col-md-4"><span class="text-muted small">Tanggal Pemeriksaan:</span><div class="fw-semibold">{{ $skrining->tanggal_periksa ? $skrining->tanggal_periksa->format('d F Y') : '-' }}</div></div>
                </div>
            </div>

            {{-- B. HASIL PEMERIKSAAN MEDIS --}}
            <div class="section-tag teal">B. HASIL PEMERIKSAAN MEDIS</div>

            {{-- Alat yang Dipakai --}}
            @if($skrining->alat_dipakai && count($skrining->alat_dipakai))
            <div class="mb-4 p-3 border rounded-3" style="background:#f0fdf4;border-color:#bbf7d0!important;">
                <div class="fw-bold small mb-2" style="color:#0f766e;"><i class="bi bi-tools me-1"></i>Alat yang Dipakai:</div>
                <div class="d-flex flex-wrap gap-2">
                    @foreach($skrining->alat_dipakai as $alat)
                    <span class="badge" style="background:#0f766e;font-size:.8rem;font-weight:600;padding:6px 12px;">{{ $alat }}</span>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- 1. Metabolik GCU --}}
            <h6 class="fw-bold mb-2">1. Pemeriksaan Metabolik (EasyTouch GCU)</h6>
            <div class="table-responsive mb-4">
                <table class="table table-preview mb-0">
                    <thead>
                        <tr>
                            <th style="width:30%;">Parameter</th>
                            <th style="width:25%;" class="text-center">Hasil</th>
                            <th style="width:25%;" class="text-center">Nilai Normal</th>
                            <th style="width:20%;" class="text-center">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="fw-semibold">Gula Darah (Sewaktu)</td>
                            <td class="text-center fw-bold">{{ $skrining->gula_darah ? $skrining->gula_darah . ' mg/dL' : '-' }}</td>
                            <td class="text-center text-muted">&lt; 140 mg/dL</td>
                            <td class="text-center">
                                @if($skrining->status_gula_darah === 'Normal')
                                    <span class="badge-normal">Normal</span>
                                @elseif($skrining->status_gula_darah === 'Pra-Diabetes')
                                    <span class="badge-warning">Pra-Diabetes</span>
                                @elseif($skrining->status_gula_darah === 'Tinggi')
                                    <span class="badge-danger">Tinggi</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Kolesterol Total</td>
                            <td class="text-center fw-bold">{{ $skrining->kolesterol_total ? $skrining->kolesterol_total . ' mg/dL' : '-' }}</td>
                            <td class="text-center text-muted">&lt; 200 mg/dL</td>
                            <td class="text-center">
                                @if($skrining->status_kolesterol === 'Normal')
                                    <span class="badge-normal">Normal</span>
                                @elseif($skrining->status_kolesterol)
                                    <span class="badge-danger">{{ $skrining->status_kolesterol }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Asam Urat</td>
                            <td class="text-center fw-bold">{{ $skrining->asam_urat ? $skrining->asam_urat . ' mg/dL' : '-' }}</td>
                            <td class="text-center text-muted">&lt; 7.0 mg/dL</td>
                            <td class="text-center">
                                @if($skrining->status_asam_urat === 'Normal')
                                    <span class="badge-normal">Normal</span>
                                @elseif($skrining->status_asam_urat === 'Tinggi')
                                    <span class="badge-danger">Tinggi</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- 2. ABI & 3. Kardia L6 --}}
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <div class="p-3 border rounded-3 h-100 bg-white">
                        <h6 class="fw-bold text-teal mb-2">2. Skrining Vaskuler (Ankle Brachial Index / ABI)</h6>
                        <div class="row g-2 mb-2">
                            <div class="col-6">Nilai ABI Kanan: <strong>{{ $skrining->abi_kanan ?: '-' }}</strong></div>
                            <div class="col-6">Nilai ABI Kiri: <strong>{{ $skrining->abi_kiri ?: '-' }}</strong></div>
                        </div>
                        <div>Interpretasi: <span class="badge bg-teal text-white">{{ $skrining->abi_interpretasi ?? 'Normal' }}</span></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 border rounded-3 h-100 bg-white">
                        <h6 class="fw-bold text-teal mb-2">3. Skrining Jantung (Kardia L6)</h6>
                        <div class="mb-1">Irama Jantung: <strong>{{ $skrining->ecg_irama ?? 'Normal Sinus Rhythm' }}</strong></div>
                        <div class="mb-1">Detak Jantung: <strong>{{ $skrining->ecg_detak ? $skrining->ecg_detak . ' BPM' : '-' }}</strong></div>
                        <small class="text-muted d-block">Catatan: {{ $skrining->ecg_catatan ?: '-' }}</small>
                    </div>
                </div>
            </div>

            {{-- 4. Mata & 5. Otak --}}
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <div class="p-3 border rounded-3 h-100 bg-white">
                        <h6 class="fw-bold text-teal mb-2">4. Skrining Mata (EyeRobo Fundus Camera)</h6>
                        <div class="mb-1">Mata Kanan (OD): <span class="badge bg-light text-dark border">{{ $skrining->mata_od_status ?? 'Normal' }}</span> {{ $skrining->mata_od_keterangan ? '('.$skrining->mata_od_keterangan.')' : '' }}</div>
                        <div class="mb-2">Mata Kiri (OS): <span class="badge bg-light text-dark border">{{ $skrining->mata_os_status ?? 'Normal' }}</span> {{ $skrining->mata_os_keterangan ? '('.$skrining->mata_os_keterangan.')' : '' }}</div>
                        <small class="text-muted d-block">Temuan Vaskular Retina: {{ $skrining->mata_vaskular_retina ?: '-' }}</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 border rounded-3 h-100 bg-white">
                        <h6 class="fw-bold text-teal mb-2">5. Skrining Otak (Evaluasi Risiko Stroke)</h6>
                        <div class="mb-2">Tingkat Risiko: <span class="badge {{ $skrining->otak_risiko === 'Tinggi' ? 'bg-danger' : ($skrining->otak_risiko === 'Sedang' ? 'bg-warning text-dark' : 'bg-success') }} px-3 py-1">{{ $skrining->otak_risiko ?? 'Rendah' }}</span></div>
                        <small class="text-muted d-block">Catatan: {{ $skrining->otak_catatan ?: '-' }}</small>
                    </div>
                </div>
            </div>

            {{-- C. INTERPRETASI & KESIMPULAN UMUM --}}
            <div class="section-tag teal">C. INTERPRETASI & KESIMPULAN UMUM</div>
            <div class="p-3 border rounded-3 bg-light mb-4">
                @if(!empty($skrining->kesimpulan_umum))
                    <ul class="mb-0 ps-3">
                        @foreach($skrining->kesimpulan_umum as $ku)
                            <li class="mb-1 fw-bold text-dark">{{ $ku }}</li>
                        @endforeach
                    </ul>
                @else
                    <span class="text-muted fst-italic">Kondisi secara umum dalam parameter pemantauan berkala.</span>
                @endif
            </div>

            {{-- D. REKOMENDASI TINDAK LANJUT --}}
            <div class="section-tag teal">D. REKOMENDASI TINDAK LANJUT</div>
            <div class="p-3 border rounded-3 bg-white mb-4">
                <h6 class="fw-bold text-dark mb-2">Gaya Hidup & Nutrisi:</h6>
                @if(!empty($skrining->rekomendasi_gaya_hidup))
                    <ul class="ps-3 mb-3 small">
                        @foreach($skrining->rekomendasi_gaya_hidup as $gh)
                            <li>{{ $gh }}</li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted small mb-3">-</p>
                @endif

                <h6 class="fw-bold text-dark mb-2 border-top pt-2">Rujukan & Konsultasi Medis:</h6>
                @if(!empty($skrining->rekomendasi_rujukan))
                    <ul class="ps-3 mb-0 small">
                        @foreach($skrining->rekomendasi_rujukan as $rj)
                            <li>{{ $rj }}</li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted small mb-0">-</p>
                @endif
            </div>
        </div>
        @endif

        {{-- Footer --}}
        <div class="p-3 bg-light border-top d-flex justify-content-between align-items-center">
            <span class="text-muted small">Klinik Utama Cahaya Surya & RS Mata Solo &bull; E-Report System</span>
            <a href="{{ route('admin.skrining.pdf', $skrining) }}" class="btn btn-sm btn-danger fw-bold">
                <i class="bi bi-file-earmark-pdf-fill me-1"></i>Download PDF Resmi
            </a>
        </div>
    </div>

</div>
@endsection
