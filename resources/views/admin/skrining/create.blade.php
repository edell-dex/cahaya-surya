@extends('layouts.admin')
@section('title', 'Input Hasil Skrining')
@section('page-title', 'Form Input Hasil Skrining Pasien')
@section('breadcrumb')
    <a href="{{ route('admin.skrining.index') }}">Hasil Skrining</a>
    <i class="bi bi-chevron-right" style="font-size:.7rem"></i> Input Form
@endsection

@push('styles')
<style>
.form-document-box {
    background: #fff;
    border: 1px solid #cbd5e1;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,.06);
    overflow: hidden;
    margin-bottom: 24px;
}
.doc-top-bar {
    padding: 14px 20px;
    font-weight: 700;
    font-size: 1.05rem;
    color: #fff;
    letter-spacing: .02em;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.doc-top-bar.siswa { background: #005a9c; }
.doc-top-bar.karyawan { background: linear-gradient(135deg, #0f766e, #115e59); }

.patient-info-box {
    border: 1px solid #bfdbfe;
    border-radius: 8px;
    background: #f8fafc;
    padding: 16px 20px;
    margin: 20px;
}
.section-title-tag {
    font-size: .95rem;
    font-weight: 800;
    color: #005a9c;
    text-transform: uppercase;
    letter-spacing: .03em;
    padding: 10px 20px 6px;
    border-bottom: 2px solid #005a9c;
    margin-bottom: 16px;
}
.section-title-tag.teal {
    color: #0f766e;
    border-bottom-color: #0f766e;
}

.table-skrining th {
    background: #f1f5f9;
    color: #1e293b;
    font-size: .8rem;
    font-weight: 700;
    text-align: center;
    vertical-align: middle;
    border: 1px solid #cbd5e1;
    padding: 8px 10px;
}
.table-skrining td {
    border: 1px solid #cbd5e1;
    vertical-align: middle;
    padding: 8px 10px;
}
.card-subbox {
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    padding: 14px 16px;
    height: 100%;
    background: #fff;
}
.card-subbox-title {
    font-weight: 700;
    font-size: .88rem;
    color: #005a9c;
    margin-bottom: 12px;
}
.card-subbox-title.teal { color: #0f766e; }

.badge-status-normal { background: #dcfce7; color: #166534; font-weight: 700; border: 1px solid #86efac; padding: 4px 10px; border-radius: 6px; font-size: .75rem; }
.badge-status-warning { background: #fef9c3; color: #854d0e; font-weight: 700; border: 1px solid #fde047; padding: 4px 10px; border-radius: 6px; font-size: .75rem; }
.badge-status-danger { background: #fee2e2; color: #991b1b; font-weight: 700; border: 1px solid #fca5a5; padding: 4px 10px; border-radius: 6px; font-size: .75rem; }
</style>
@endpush

@section('content')
<div class="container-fluid px-0">

    {{-- Alert Errors --}}
    @if($errors->any())
    <div class="alert alert-danger border-0 shadow-sm mb-4">
        <i class="bi bi-exclamation-circle-fill me-2"></i><strong>Terdapat kesalahan pada input Anda:</strong>
        <ul class="mb-0 mt-1 ps-3">
            @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
        </ul>
    </div>
    @endif

    {{-- Form Pencarian / Switch Pasien --}}
    <div class="card border-0 shadow-sm mb-4" style="border-radius:10px;">
        <div class="card-body p-3">
            <div class="row align-items-center g-2">
                <div class="col-md-3">
                    <span class="fw-bold text-dark"><i class="bi bi-search me-1"></i>Pilih Pasien Lain:</span>
                </div>
                <div class="col-md-7">
                    <div class="input-group">
                        <input type="text" id="quickSearchKode" class="form-control" placeholder="Masukkan Kode Antrian (SEK-... / CORP-...)" value="{{ $pasien->no_antrian ?? '' }}" style="text-transform:uppercase;">
                        <button type="button" class="btn btn-outline-primary" id="btnQuickSearch"><i class="bi bi-arrow-repeat me-1"></i>Muat Pasien</button>
                    </div>
                </div>
                <div class="col-md-2 text-md-end">
                    <a href="{{ route('admin.skrining.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
                </div>
            </div>
            <div id="quickSearchMsg" class="mt-2"></div>
        </div>
    </div>

    @if(!$pasien)
        <div class="alert alert-info border-0 shadow-sm py-4 text-center">
            <i class="bi bi-info-circle fs-1 text-primary d-block mb-2"></i>
            <h5>Silakan masukkan Kode Antrian pasien pada kotak pencarian di atas.</h5>
            <p class="text-muted small mb-0">Sistem akan secara otomatis memuat data identitas pasien dan menampilkan form hasil skrining yang sesuai (Template Siswa atau Karyawan).</p>
        </div>
    @else

    <form action="{{ route('admin.skrining.store') }}" method="POST" id="mainSkriningForm">
        @csrf
        <input type="hidden" name="pasien_id" value="{{ $pasien->id }}">
        <input type="hidden" name="tipe" value="{{ $pasien->tipe_pendaftaran }}">

        {{-- ========================================================================= --}}
        {{-- JIKA PASIEN ADALAH SISWA (TEMPLATE SISWA.PDF)                             --}}
        {{-- ========================================================================= --}}
        @if($pasien->tipe_pendaftaran === 'sekolah')

        <div class="form-document-box">
            {{-- Header Biru Template Siswa --}}
            <div class="doc-top-bar siswa">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-eye"></i>
                    <span>HASIL SKRINING KESEHATAN MATA (E-REPORT)</span>
                </div>
                <span class="badge bg-white text-dark small">Template: Siswa.pdf</span>
            </div>

            {{-- Box Identitas Pasien (Auto-Fill) --}}
            <div class="patient-info-box">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="row g-2 align-items-center">
                            <div class="col-4 fw-bold text-dark">Nama Lengkap</div>
                            <div class="col-8">: <span class="fw-semibold text-primary fs-6">{{ $pasien->nama_lengkap }}</span></div>
                            <div class="col-4 fw-bold text-dark">Peran / Kelas</div>
                            <div class="col-8">: {{ $pasien->kategori_peserta ?? 'Siswa' }} {{ $pasien->kelas_unit ? '('.$pasien->kelas_unit.')' : '' }}</div>
                            <div class="col-4 fw-bold text-dark">Asal Sekolah</div>
                            <div class="col-8">: {{ $pasien->institusi_nama ?? '-' }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row g-2 align-items-center">
                            <div class="col-4 fw-bold text-dark">NIS / NIP / NIK</div>
                            <div class="col-8">: <code class="fw-bold">{{ $pasien->nik }}</code> (No. Antrian: {{ $pasien->no_antrian }})</div>
                            <div class="col-4 fw-bold text-dark">Tgl. Pemeriksaan <span class="text-danger">*</span></div>
                            <div class="col-8">
                                : <input type="date" class="form-control form-control-sm d-inline-block w-auto" name="tanggal_periksa" value="{{ old('tanggal_periksa', date('Y-m-d')) }}" required>
                            </div>
                            <div class="col-4 fw-bold text-dark">Petugas Staff</div>
                            <div class="col-8">: <span class="badge bg-success-subtle text-success border border-success-subtle">{{ auth()->user()->name }} ({{ auth()->user()->role }})</span></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-4 pt-0">
                {{-- ALAT YANG DIPAKAI - SISWA --}}
                <div class="card-subbox mb-4" style="border-left: 4px solid #005a9c;">
                    <div class="card-subbox-title d-flex align-items-center gap-2">
                        <i class="bi bi-tools"></i> Alat yang Dipakai
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle ms-1" style="font-size:.7rem;font-weight:500;">Pilih satu atau lebih</span>
                    </div>
                    @php
                    $alatSiswa = [
                        'Foto Fundus EyeRobo'               => 'bi-camera-fill',
                        'ICARE 100'                          => 'bi-eyedropper',
                        'Buta Warna Ishihara / Munsell 15'  => 'bi-palette-fill',
                        'Alat Refraksi Retinomax / ARK'     => 'bi-eye-fill',
                    ];
                    $selectedAlat = old('alat_dipakai', []);
                    @endphp
                    <div class="row g-2">
                        @foreach($alatSiswa as $nama => $icon)
                        <div class="col-md-6">
                            <div class="form-check d-flex align-items-center gap-2 p-2 rounded-2 border {{ in_array($nama, $selectedAlat) ? 'border-primary bg-primary bg-opacity-10' : 'border-light' }}"
                                 style="cursor:pointer;" onclick="this.querySelector('input').click()">
                                <input class="form-check-input flex-shrink-0" type="checkbox"
                                       name="alat_dipakai[]" value="{{ $nama }}"
                                       id="alat_s_{{ $loop->index }}"
                                       {{ in_array($nama, $selectedAlat) ? 'checked' : '' }}
                                       style="pointer-events:none;">
                                <label class="form-check-label d-flex align-items-center gap-2 w-100 mb-0" for="alat_s_{{ $loop->index }}" style="cursor:pointer;pointer-events:none;">
                                    <i class="bi {{ $icon }} text-primary fs-5"></i>
                                    <span class="fw-semibold small">{{ $nama }}</span>
                                </label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- A. HASIL PEMERIKSAAN KLINIS --}}
                <div class="section-title-tag">A. HASIL PEMERIKSAAN KLINIS</div>

                {{-- 1. Refraksi Lengkap (Retinomax K-plus3) --}}
                <div class="mb-4">
                    <h6 class="fw-bold text-dark mb-2">1. Pemeriksaan Refraksi Lengkap (Retinomax K-plus3)</h6>
                    <div class="table-responsive">
                        <table class="table table-skrining mb-0">
                            <thead>
                                <tr>
                                    <th style="width:25%;">Mata</th>
                                    <th style="width:25%;">Spheris (Minus/Plus)</th>
                                    <th style="width:25%;">Cylinder (Silinder)</th>
                                    <th style="width:25%;">Axis</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="fw-bold text-dark text-center">Kanan (OD)</td>
                                    <td><input type="text" class="form-control form-control-sm text-center" name="refraksi_od_spheris" value="{{ old('refraksi_od_spheris') }}" placeholder="Contoh: -1.25 atau +0.50"></td>
                                    <td><input type="text" class="form-control form-control-sm text-center" name="refraksi_od_cylinder" value="{{ old('refraksi_od_cylinder') }}" placeholder="Contoh: -0.50"></td>
                                    <td><input type="text" class="form-control form-control-sm text-center" name="refraksi_od_axis" value="{{ old('refraksi_od_axis') }}" placeholder="Contoh: 90&deg; atau 180&deg;"></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-dark text-center">Kiri (OS)</td>
                                    <td><input type="text" class="form-control form-control-sm text-center" name="refraksi_os_spheris" value="{{ old('refraksi_os_spheris') }}" placeholder="Contoh: -1.00 atau Normal"></td>
                                    <td><input type="text" class="form-control form-control-sm text-center" name="refraksi_os_cylinder" value="{{ old('refraksi_os_cylinder') }}" placeholder="Contoh: -0.25"></td>
                                    <td><input type="text" class="form-control form-control-sm text-center" name="refraksi_os_axis" value="{{ old('refraksi_os_axis') }}" placeholder="Contoh: 180&deg;"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- 2. Tekanan Bola Mata & 3. Buta Warna (2 Kolom) --}}
                <div class="row g-3 mb-4">
                    {{-- 2. Tekanan Bola Mata (iCare 100) --}}
                    <div class="col-md-6">
                        <div class="card-subbox">
                            <div class="card-subbox-title">2. Tekanan Bola Mata (iCare 100)</div>
                            <div class="row g-2 align-items-center mb-2">
                                <label class="col-sm-5 fw-semibold small">Mata Kanan (OD):</label>
                                <div class="col-sm-7">
                                    <div class="input-group input-group-sm">
                                        <input type="number" step="0.1" class="form-control" name="tio_od" value="{{ old('tio_od') }}" placeholder="Nilai">
                                        <span class="input-group-text">mmHg</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-2 align-items-center mb-2">
                                <label class="col-sm-5 fw-semibold small">Mata Kiri (OS):</label>
                                <div class="col-sm-7">
                                    <div class="input-group input-group-sm">
                                        <input type="number" step="0.1" class="form-control" name="tio_os" value="{{ old('tio_os') }}" placeholder="Nilai">
                                        <span class="input-group-text">mmHg</span>
                                    </div>
                                </div>
                            </div>
                            <div class="small text-muted fst-italic mt-2">
                                *Nilai normal: 10 - 21 mmHg
                            </div>
                        </div>
                    </div>

                    {{-- 3. Skrining Buta Warna (Munsell D15) --}}
                    <div class="col-md-6">
                        <div class="card-subbox">
                            <div class="card-subbox-title">3. Skrining Buta Warna (Munsell D15)</div>
                            <div class="d-flex flex-column gap-2 pt-1">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="buta_warna" value="Normal" id="bwNormal" {{ old('buta_warna', 'Normal') == 'Normal' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="bwNormal">
                                        <strong>Normal</strong> <span class="text-muted small">(Tidak ada gangguan)</span>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="buta_warna" value="Parsial" id="bwParsial" {{ old('buta_warna') == 'Parsial' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="bwParsial">
                                        <strong>Parsial</strong> <span class="text-muted small">(Buta warna sebagian / merah-hijau)</span>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="buta_warna" value="Total" id="bwTotal" {{ old('buta_warna') == 'Total' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="bwTotal">
                                        <strong>Total</strong> <span class="text-muted small">(Buta warna total)</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 4. Skrining Retina Digital AI --}}
                <div class="card-subbox mb-4">
                    <div class="card-subbox-title">4. Skrining Retina Digital AI (EyeRobo AI Fundus Camera)</div>
                    <label class="form-label small fw-semibold">Evaluasi Saraf, Retina & Pembuluh Darah:</label>
                    <textarea class="form-control" name="retina_ai_catatan" rows="3" placeholder="Catatan hasil deteksi AI atau tempelkan kesimpulan otomatis dari sistem EyeRobo di sini...">{{ old('retina_ai_catatan') }}</textarea>
                </div>

                {{-- B. KESIMPULAN & REKOMENDASI --}}
                <div class="section-title-tag">B. KESIMPULAN & REKOMENDASI</div>
                <div class="p-3 border rounded-3 bg-light mb-4" style="border-left: 4px solid #005a9c !important;">
                    <label class="form-label fw-bold text-dark">Catatan Dokter Spesialis Mata / Rekomendasi Klinis:</label>
                    <textarea class="form-control" name="catatan_dokter" rows="4" placeholder="Tuliskan diagnosis akhir, resep kacamata, atau anjuran rujukan jika ditemukan indikasi medis...">{{ old('catatan_dokter') }}</textarea>
                </div>

                {{-- Bar Tombol Simpan --}}
                <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                    <span class="small text-muted"><i class="bi bi-shield-check text-success me-1"></i>Data form akan disimpan dan tertera diisi oleh akun: <strong>{{ auth()->user()->name }}</strong></span>
                    <button type="submit" class="btn btn-primary btn-lg px-5 fw-bold shadow-sm" style="background:#005a9c;border-color:#005a9c;">
                        <i class="bi bi-check2-circle me-2"></i>Simpan Hasil Skrining Siswa
                    </button>
                </div>
            </div>
        </div>

        {{-- ========================================================================= --}}
        {{-- JIKA PASIEN ADALAH KARYAWAN (TEMPLATE KARYAWAN.PDF)                       --}}
        {{-- ========================================================================= --}}
        @else

        <div class="form-document-box">
            {{-- Header Hijau Tua Template Karyawan --}}
            <div class="doc-top-bar karyawan">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-heart-pulse"></i>
                    <span>HASIL SKRINING KESEHATAN VASKULER & METABOLIK (E-REPORT)</span>
                </div>
                <span class="badge bg-white text-dark small">Template: Karyawan.pdf</span>
            </div>

            <div class="p-4">
                {{-- A. DATA KARYAWAN (PATIENT INFO) --}}
                <div class="section-title-tag teal">A. DATA KARYAWAN (PATIENT INFO)</div>
                <div class="patient-info-box mt-0 mb-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="row g-2 align-items-center">
                                <div class="col-4 fw-bold text-dark">Nama Lengkap</div>
                                <div class="col-8">: <span class="fw-semibold text-teal fs-6">{{ $pasien->nama_lengkap }}</span></div>
                                <div class="col-4 fw-bold text-dark">Perusahaan</div>
                                <div class="col-8">: {{ $pasien->institusi_nama ?? '-' }}</div>
                                <div class="col-4 fw-bold text-dark">Usia / Kelamin</div>
                                <div class="col-8">: {{ $pasien->usia ? $pasien->usia.' Tahun' : '-' }} / {{ $pasien->jenis_kelamin }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row g-2 align-items-center">
                                <div class="col-4 fw-bold text-dark">ID Karyawan / NIK</div>
                                <div class="col-8">: <code class="fw-bold">{{ $pasien->nik }}</code> ({{ $pasien->no_antrian }})</div>
                                <div class="col-4 fw-bold text-dark">Departemen</div>
                                <div class="col-8">: {{ $pasien->kelas_unit ?? ($pasien->pekerjaan ?? 'Staff') }}</div>
                                <div class="col-4 fw-bold text-dark">Tgl Pemeriksaan <span class="text-danger">*</span></div>
                                <div class="col-8">
                                    : <input type="date" class="form-control form-control-sm d-inline-block w-auto" name="tanggal_periksa" value="{{ old('tanggal_periksa', date('Y-m-d')) }}" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ALAT YANG DIPAKAI - KARYAWAN --}}
                <div class="card-subbox mb-4" style="border-left: 4px solid #0f766e;">
                    <div class="card-subbox-title teal d-flex align-items-center gap-2">
                        <i class="bi bi-tools"></i> Alat yang Dipakai
                        <span class="badge ms-1" style="background:rgba(15,118,110,.15);color:#0f766e;border:1px solid #0f766e;font-size:.7rem;font-weight:500;">Pilih satu atau lebih</span>
                    </div>
                    @php
                    $alatKaryawan = [
                        'Foto Fundus EyeRobo'   => 'bi-camera-fill',
                        'Kardia L6 / Omron'     => 'bi-heart-pulse-fill',
                        'ABI'                   => 'bi-activity',
                        'Laboratorium Stik'     => 'bi-droplet-fill',
                    ];
                    $selectedAlatK = old('alat_dipakai', []);
                    @endphp
                    <div class="row g-2">
                        @foreach($alatKaryawan as $nama => $icon)
                        <div class="col-md-6">
                            <div class="form-check d-flex align-items-center gap-2 p-2 rounded-2 border {{ in_array($nama, $selectedAlatK) ? 'border-success bg-success bg-opacity-10' : 'border-light' }}"
                                 style="cursor:pointer;" onclick="this.querySelector('input').click()">
                                <input class="form-check-input flex-shrink-0" type="checkbox"
                                       name="alat_dipakai[]" value="{{ $nama }}"
                                       id="alat_k_{{ $loop->index }}"
                                       {{ in_array($nama, $selectedAlatK) ? 'checked' : '' }}
                                       style="pointer-events:none;">
                                <label class="form-check-label d-flex align-items-center gap-2 w-100 mb-0" for="alat_k_{{ $loop->index }}" style="cursor:pointer;pointer-events:none;">
                                    <i class="bi {{ $icon }} fs-5" style="color:#0f766e;"></i>
                                    <span class="fw-semibold small">{{ $nama }}</span>
                                </label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- B. HASIL PEMERIKSAAN MEDIS --}}
                <div class="section-title-tag teal">B. HASIL PEMERIKSAAN MEDIS</div>

                {{-- 1. Pemeriksaan Metabolik (EasyTouch GCU) --}}
                <div class="mb-4">
                    <h6 class="fw-bold text-dark mb-2">1. Pemeriksaan Metabolik (EasyTouch GCU)</h6>
                    <div class="table-responsive">
                        <table class="table table-skrining mb-0">
                            <thead>
                                <tr>
                                    <th style="width:30%;">Parameter</th>
                                    <th style="width:25%;">Hasil</th>
                                    <th style="width:25%;">Nilai Normal</th>
                                    <th style="width:20%;">Status Indikasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="fw-semibold">Gula Darah (Sewaktu)</td>
                                    <td>
                                        <div class="input-group input-group-sm">
                                            <input type="number" step="0.1" class="form-control" name="gula_darah" id="inputGula" value="{{ old('gula_darah') }}" placeholder="Nilai">
                                            <span class="input-group-text">mg/dL</span>
                                        </div>
                                    </td>
                                    <td class="text-center text-muted">&lt; 140 mg/dL</td>
                                    <td class="text-center" id="badgeGula"><span class="badge bg-light text-dark">-</span></td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Kolesterol Total</td>
                                    <td>
                                        <div class="input-group input-group-sm">
                                            <input type="number" step="0.1" class="form-control" name="kolesterol_total" id="inputKolesterol" value="{{ old('kolesterol_total') }}" placeholder="Nilai">
                                            <span class="input-group-text">mg/dL</span>
                                        </div>
                                    </td>
                                    <td class="text-center text-muted">&lt; 200 mg/dL</td>
                                    <td class="text-center" id="badgeKolesterol"><span class="badge bg-light text-dark">-</span></td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Asam Urat</td>
                                    <td>
                                        <div class="input-group input-group-sm">
                                            <input type="number" step="0.1" class="form-control" name="asam_urat" id="inputAsamUrat" value="{{ old('asam_urat') }}" placeholder="Nilai">
                                            <span class="input-group-text">mg/dL</span>
                                        </div>
                                    </td>
                                    <td class="text-center text-muted">&lt; 7.0 mg/dL</td>
                                    <td class="text-center" id="badgeAsamUrat"><span class="badge bg-light text-dark">-</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- 2. Skrining Vaskuler (ABI) --}}
                <div class="card-subbox mb-4">
                    <div class="card-subbox-title teal">2. Skrining Vaskuler (Ankle Brachial Index / ABI)</div>
                    <div class="row g-3 align-items-center mb-3">
                        <div class="col-md-6">
                            <div class="row g-2 align-items-center">
                                <label class="col-5 fw-semibold small">Nilai ABI Kanan:</label>
                                <div class="col-7">
                                    <input type="number" step="0.01" class="form-control form-control-sm" name="abi_kanan" value="{{ old('abi_kanan', '1.05') }}" placeholder="Contoh: 1.05">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row g-2 align-items-center">
                                <label class="col-5 fw-semibold small">Nilai ABI Kiri:</label>
                                <div class="col-7">
                                    <input type="number" step="0.01" class="form-control form-control-sm" name="abi_kiri" value="{{ old('abi_kiri', '1.02') }}" placeholder="Contoh: 1.02">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3 flex-wrap border-top pt-2">
                        <span class="fw-semibold small">Interpretasi:</span>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="abi_interpretasi" id="abiNormal" value="Normal" {{ old('abi_interpretasi', 'Normal') == 'Normal' ? 'checked' : '' }}>
                            <label class="form-check-label small" for="abiNormal"><strong>Normal</strong> (0.91 - 1.30)</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="abi_interpretasi" id="abiBorderline" value="Borderline" {{ old('abi_interpretasi') == 'Borderline' ? 'checked' : '' }}>
                            <label class="form-check-label small" for="abiBorderline"><strong>Borderline</strong></label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="abi_interpretasi" id="abiPAD" value="Indikasi PAD" {{ old('abi_interpretasi') == 'Indikasi PAD' ? 'checked' : '' }}>
                            <label class="form-check-label small" for="abiPAD"><strong>Indikasi PAD</strong></label>
                        </div>
                    </div>
                </div>

                {{-- 3. Skrining Jantung (Kardia L6) --}}
                <div class="card-subbox mb-4">
                    <div class="card-subbox-title teal">3. Skrining Jantung (Kardia L6)</div>
                    <div class="row g-3 mb-2">
                        <div class="col-md-7">
                            <label class="fw-semibold small d-block mb-1">Irama Jantung (ECG):</label>
                            <div class="d-flex gap-3 flex-wrap">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="ecg_irama" id="ecgNormal" value="Normal Sinus Rhythm" {{ old('ecg_irama', 'Normal Sinus Rhythm') == 'Normal Sinus Rhythm' ? 'checked' : '' }}>
                                    <label class="form-check-label small" for="ecgNormal">Normal Sinus Rhythm</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="ecg_irama" id="ecgAfib" value="Atrial Fibrillation (AFib)" {{ old('ecg_irama') == 'Atrial Fibrillation (AFib)' ? 'checked' : '' }}>
                                    <label class="form-check-label small" for="ecgAfib">Atrial Fibrillation (AFib)</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="ecg_irama" id="ecgLainnya" value="Lainnya" {{ old('ecg_irama') == 'Lainnya' ? 'checked' : '' }}>
                                    <label class="form-check-label small" for="ecgLainnya">Lainnya</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <label class="fw-semibold small d-block mb-1">Detak Jantung:</label>
                            <div class="input-group input-group-sm">
                                <input type="number" class="form-control" name="ecg_detak" value="{{ old('ecg_detak', 76) }}" placeholder="Contoh: 76">
                                <span class="input-group-text">BPM (Beats Per Minute)</span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2">
                        <label class="small fw-semibold text-muted">Catatan ECG:</label>
                        <input type="text" class="form-control form-control-sm" name="ecg_catatan" value="{{ old('ecg_catatan', 'Tidak ditemukan kelainan irama jantung pada saat pemeriksaan.') }}" placeholder="Catatan irama ECG">
                    </div>
                </div>

                {{-- 4. Skrining Mata (EyeRobo Fundus Camera) --}}
                <div class="card-subbox mb-4">
                    <div class="card-subbox-title teal">4. Skrining Mata (EyeRobo Fundus Camera)</div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="small fw-semibold">Mata Kanan (OD):</label>
                            <div class="d-flex align-items-center gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="mata_od_status" id="odNormal" value="Normal" {{ old('mata_od_status', 'Normal') == 'Normal' ? 'checked' : '' }}>
                                    <label class="form-check-label small" for="odNormal">Normal</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="mata_od_status" id="odKelainan" value="Kelainan" {{ old('mata_od_status') == 'Kelainan' ? 'checked' : '' }}>
                                    <label class="form-check-label small" for="odKelainan">Kelainan</label>
                                </div>
                                <input type="text" class="form-control form-control-sm" name="mata_od_keterangan" value="{{ old('mata_od_keterangan') }}" placeholder="Keterangan kelainan jika ada">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="small fw-semibold">Mata Kiri (OS):</label>
                            <div class="d-flex align-items-center gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="mata_os_status" id="osNormal" value="Normal" {{ old('mata_os_status', 'Normal') == 'Normal' ? 'checked' : '' }}>
                                    <label class="form-check-label small" for="osNormal">Normal</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="mata_os_status" id="osKelainan" value="Kelainan" {{ old('mata_os_status') == 'Kelainan' ? 'checked' : '' }}>
                                    <label class="form-check-label small" for="osKelainan">Kelainan</label>
                                </div>
                                <input type="text" class="form-control form-control-sm" name="mata_os_keterangan" value="{{ old('mata_os_keterangan') }}" placeholder="Keterangan kelainan jika ada">
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="small fw-semibold">Temuan Vaskular Retina:</label>
                        <textarea class="form-control form-control-sm" name="mata_vaskular_retina" rows="2" placeholder="Deskripsi pembuluh darah retina...">{{ old('mata_vaskular_retina', 'Pembuluh darah retina tampak baik, tidak ada tanda-tanda retinopati diabetik atau hipertensi.') }}</textarea>
                    </div>
                </div>

                {{-- 5. Skrining Otak (Evaluasi Risiko Stroke) --}}
                <div class="card-subbox mb-4">
                    <div class="card-subbox-title teal">5. Skrining Otak (Evaluasi Risiko Stroke)</div>
                    <div class="mb-2">
                        <label class="small fw-semibold d-block mb-1">Tingkat Risiko:</label>
                        <div class="d-flex gap-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="otak_risiko" id="otakRendah" value="Rendah" {{ old('otak_risiko', 'Rendah') == 'Rendah' ? 'checked' : '' }}>
                                <label class="form-check-label small" for="otakRendah"><strong>Rendah</strong> (Low)</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="otak_risiko" id="otakSedang" value="Sedang" {{ old('otak_risiko') == 'Sedang' ? 'checked' : '' }}>
                                <label class="form-check-label small" for="otakSedang"><strong>Sedang</strong> (Moderate)</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="otak_risiko" id="otakTinggi" value="Tinggi" {{ old('otak_risiko') == 'Tinggi' ? 'checked' : '' }}>
                                <label class="form-check-label small" for="otakTinggi"><strong>Tinggi</strong> (High)</label>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="small fw-semibold">Catatan Evaluasi:</label>
                        <textarea class="form-control form-control-sm" name="otak_catatan" rows="2" placeholder="Catatan evaluasi stroke...">{{ old('otak_catatan', 'Berdasarkan parameter vaskular (ABI) dan irama jantung, suplai darah ke otak terindikasi aman.') }}</textarea>
                    </div>
                </div>

                {{-- C. INTERPRETASI & KESIMPULAN UMUM --}}
                <div class="section-title-tag teal">C. INTERPRETASI & KESIMPULAN UMUM</div>
                <div class="p-3 border rounded-3 bg-light mb-4">
                    <div class="small text-muted fst-italic mb-3">Diisi oleh dokter pemeriksa berdasarkan integrasi kelima skrining:</div>
                    <div class="d-flex flex-column gap-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="kesimpulan_umum[]" value="Kondisi Sehat / Risiko Rendah" id="kuRendah" {{ in_array('Kondisi Sehat / Risiko Rendah', old('kesimpulan_umum', [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="kuRendah">
                                <strong>Kondisi Sehat / Risiko Rendah:</strong> <span class="text-muted small d-block">Parameter metabolisme dan vaskuler dalam batas normal.</span>
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="kesimpulan_umum[]" value="Pemantauan Berkala (Risiko Sedang)" id="kuSedang" {{ in_array('Pemantauan Berkala (Risiko Sedang)', old('kesimpulan_umum', ['Pemantauan Berkala (Risiko Sedang)'])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="kuSedang">
                                <strong>Pemantauan Berkala (Risiko Sedang):</strong> <span class="text-muted small d-block">Terdapat parameter yang perlu diperbaiki (Hiperkolesterolemia) melalui modifikasi gaya hidup.</span>
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="kesimpulan_umum[]" value="Perlu Penanganan Medis Lanjut (Risiko Tinggi)" id="kuTinggi" {{ in_array('Perlu Penanganan Medis Lanjut (Risiko Tinggi)', old('kesimpulan_umum', [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="kuTinggi">
                                <strong>Perlu Penanganan Medis Lanjut (Risiko Tinggi):</strong> <span class="text-muted small d-block">Ditemukan indikasi gangguan yang membutuhkan evaluasi spesialis segera.</span>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- D. REKOMENDASI TINDAK LANJUT --}}
                <div class="section-title-tag teal">D. REKOMENDASI TINDAK LANJUT</div>
                <div class="card-subbox mb-4">
                    <h6 class="fw-bold text-dark mb-3">Gaya Hidup & Nutrisi</h6>
                    <div class="d-flex flex-column gap-2 mb-4">
                        @php
                        $ghDefaults = [
                            'Kurangi konsumsi makanan berlemak tinggi, gorengan, dan santan (Diet rendah kolesterol).',
                            'Tingkatkan aktivitas fisik/olahraga aerobik minimal 30 menit sehari, 5 kali seminggu.',
                            'Perbanyak konsumsi serat dari buah dan sayuran segar.'
                        ];
                        @endphp
                        @foreach($ghDefaults as $i => $gh)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rekomendasi_gaya_hidup[]" value="{{ $gh }}" id="gh_{{ $i }}" {{ in_array($gh, old('rekomendasi_gaya_hidup', $ghDefaults)) ? 'checked' : '' }}>
                            <label class="form-check-label small" for="gh_{{ $i }}">{{ $gh }}</label>
                        </div>
                        @endforeach
                    </div>

                    <h6 class="fw-bold text-dark mb-3 border-top pt-3">Rujukan & Konsultasi Medis</h6>
                    <div class="d-flex flex-column gap-2">
                        @php
                        $rjDefaults = [
                            'Konsultasi ke Dokter Spesialis Jantung atau Saraf.',
                            'Konsultasi ke Dokter Spesialis Mata di RS Mata Solo.',
                            'Cek ulang Kolesterol Total dan Profil Lipid lengkap (LDL, HDL, Trigliserida) 1 bulan ke depan.'
                        ];
                        @endphp
                        @foreach($rjDefaults as $i => $rj)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rekomendasi_rujukan[]" value="{{ $rj }}" id="rj_{{ $i }}" {{ in_array($rj, old('rekomendasi_rujukan', [$rjDefaults[2]])) ? 'checked' : '' }}>
                            <label class="form-check-label small" for="rj_{{ $i }}">{{ $rj }}</label>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Bar Tombol Simpan --}}
                <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                    <span class="small text-muted"><i class="bi bi-shield-check text-teal me-1"></i>Data form akan disimpan dan tertera diisi oleh akun: <strong>{{ auth()->user()->name }}</strong></span>
                    <button type="submit" class="btn btn-teal btn-lg px-5 fw-bold shadow-sm" style="background:#0f766e;border-color:#0f766e;color:#fff;">
                        <i class="bi bi-check2-circle me-2"></i>Simpan Hasil Skrining Karyawan
                    </button>
                </div>
            </div>
        </div>

        @endif

    </form>
    @endif

</div>
@endsection

@push('scripts')
<script>
// Alat Dipakai — toggle highlight on checkbox click
document.querySelectorAll('[name="alat_dipakai[]"]').forEach(function(cb) {
    cb.addEventListener('change', function() {
        const wrapper = this.closest('.form-check');
        const isKaryawan = this.id.startsWith('alat_k_');
        const colorClass  = isKaryawan ? 'border-success' : 'border-primary';
        const bgClass     = isKaryawan ? 'bg-success'     : 'bg-primary';
        if (this.checked) {
            wrapper.classList.replace('border-light', colorClass);
            wrapper.classList.add(bgClass, 'bg-opacity-10');
        } else {
            wrapper.classList.replace(colorClass, 'border-light');
            wrapper.classList.remove(bgClass, 'bg-opacity-10');
        }
    });
});

// Quick Search Handler
const CARI_API = '{{ route("admin.skrining.cariPasien") }}';
const CREATE_PAGE = '{{ route("admin.skrining.create") }}';

document.getElementById('btnQuickSearch')?.addEventListener('click', function() {
    const kode = document.getElementById('quickSearchKode').value.trim().toUpperCase();
    const msgBox = document.getElementById('quickSearchMsg');
    if (!kode) {
        msgBox.innerHTML = '<span class="text-danger small">Silakan masukkan kode antrian pasien.</span>';
        return;
    }
    this.disabled = true;
    this.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Memuat...';

    fetch(CARI_API + '?no_antrian=' + encodeURIComponent(kode))
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                window.location.href = CREATE_PAGE + '?pasien_id=' + res.pasien.id;
            } else {
                this.disabled = false;
                this.innerHTML = '<i class="bi bi-arrow-repeat me-1"></i>Muat Pasien';
                msgBox.innerHTML = '<div class="alert alert-danger py-1 px-2 small mt-2 mb-0">' + res.message + '</div>';
            }
        })
        .catch(() => {
            this.disabled = false;
            this.innerHTML = '<i class="bi bi-arrow-repeat me-1"></i>Muat Pasien';
            msgBox.innerHTML = '<div class="alert alert-danger py-1 px-2 small mt-2 mb-0">Gagal mencari pasien. Silakan coba lagi.</div>';
        });
});

document.getElementById('quickSearchKode')?.addEventListener('keydown', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        document.getElementById('btnQuickSearch').click();
    }
});

// Dynamic Badge Status for GCU
function updateBadges() {
    const gula = parseFloat(document.getElementById('inputGula')?.value);
    const bgGula = document.getElementById('badgeGula');
    if (bgGula) {
        if (isNaN(gula)) bgGula.innerHTML = '<span class="badge bg-light text-dark">-</span>';
        else if (gula < 140) bgGula.innerHTML = '<span class="badge-status-normal">Normal</span>';
        else if (gula < 200) bgGula.innerHTML = '<span class="badge-status-warning">Pra-Diabetes</span>';
        else bgGula.innerHTML = '<span class="badge-status-danger">Tinggi</span>';
    }

    const kol = parseFloat(document.getElementById('inputKolesterol')?.value);
    const bgKol = document.getElementById('badgeKolesterol');
    if (bgKol) {
        if (isNaN(kol)) bgKol.innerHTML = '<span class="badge bg-light text-dark">-</span>';
        else if (kol < 200) bgKol.innerHTML = '<span class="badge-status-normal">Normal</span>';
        else bgKol.innerHTML = '<span class="badge-status-danger">Tinggi</span>';
    }

    const au = parseFloat(document.getElementById('inputAsamUrat')?.value);
    const bgAu = document.getElementById('badgeAsamUrat');
    if (bgAu) {
        if (isNaN(au)) bgAu.innerHTML = '<span class="badge bg-light text-dark">-</span>';
        else if (au < 7.0) bgAu.innerHTML = '<span class="badge-status-normal">Normal</span>';
        else bgAu.innerHTML = '<span class="badge-status-danger">Tinggi</span>';
    }
}

document.getElementById('inputGula')?.addEventListener('input', updateBadges);
document.getElementById('inputKolesterol')?.addEventListener('input', updateBadges);
document.getElementById('inputAsamUrat')?.addEventListener('input', updateBadges);
updateBadges();
</script>
@endpush
