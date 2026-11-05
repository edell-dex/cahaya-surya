@extends('layouts.public')

@section('title', 'Formulir Pendaftaran Skrining Mata Sekolah — Klinik Utama Cahaya Surya')

@push('styles')
<style>
.form-document {
    background: #fff;
    border: 1px solid #cbd5e1;
    border-radius: 12px;
    box-shadow: 0 6px 28px rgba(26,60,94,.12);
    overflow: hidden;
    max-width: 900px;
    margin: 0 auto;
}
.doc-header {
    padding: 24px 28px 18px;
    display: flex;
    align-items: center;
    gap: 20px;
    border-bottom: 1px solid #e2e8f0;
}
.doc-header-logo {
    width: 68px;
    height: 68px;
    flex-shrink: 0;
}
.doc-header-text h3 {
    color: #1a3c5e;
    font-weight: 800;
    font-size: 1.25rem;
    margin-bottom: 3px;
    letter-spacing: .02em;
}
.doc-header-text .sub1 {
    font-size: .8rem;
    color: #334155;
    margin-bottom: 3px;
}
.doc-header-text .sub2 {
    font-size: .75rem;
    color: #64748b;
    margin-bottom: 3px;
}
.doc-header-text .sub3 {
    font-size: .73rem;
    color: #0284c7;
    font-weight: 600;
}

.doc-banner-title {
    background: #0284c7;
    color: #fff;
    text-align: center;
    padding: 16px 20px 14px;
    margin: 18px 24px 12px 24px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(2,132,199,.15);
}
.doc-banner-title h4 {
    font-size: 1.15rem;
    font-weight: 800;
    margin-bottom: 4px;
    letter-spacing: .02em;
    text-transform: uppercase;
}
.doc-banner-title p {
    font-size: .8rem;
    opacity: .95;
    margin: 0;
}

.doc-info-bar {
    background: #e0f2fe;
    border-left: 4px solid #0284c7;
    border-radius: 6px;
    margin: 0 24px 16px 24px;
    padding: 10px 16px;
    font-size: .78rem;
    color: #0369a1;
    line-height: 1.5;
}

.doc-section-head {
    font-size: .88rem;
    font-weight: 800;
    color: #1a3c5e;
    text-transform: uppercase;
    letter-spacing: .03em;
    padding: 12px 24px 6px;
    border-bottom: 1.5px solid #e2e8f0;
    background: #f8fafc;
}

.form-field-row {
    display: flex;
    align-items: flex-start;
    padding: 8px 24px;
    border-bottom: 1px dashed #e2e8f0;
}
.form-field-row .field-lbl {
    width: 220px;
    font-size: .84rem;
    font-weight: 600;
    color: #334155;
    padding-top: 6px;
    flex-shrink: 0;
}
.form-field-row .field-colon {
    width: 20px;
    font-size: .84rem;
    font-weight: 600;
    color: #334155;
    padding-top: 6px;
    flex-shrink: 0;
}
.form-field-row .field-input {
    flex: 1;
}
.form-field-row .field-input .form-control {
    border: none;
    border-bottom: 1.5px dashed #94a3b8;
    border-radius: 0;
    padding: 4px 0;
    font-size: .86rem;
    background: transparent;
}
.form-field-row .field-input .form-control:focus {
    box-shadow: none;
    border-bottom-color: #0284c7;
    background: transparent;
}

.doc-checks-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px 24px;
    padding: 14px 24px;
}
.doc-checks-grid .form-check-label {
    font-size: .82rem;
    color: #334155;
    line-height: 1.4;
}

/* Tabel Paket Pemeriksaan AI */
.doc-table {
    width: 100%;
    border-collapse: collapse;
    font-size: .8rem;
}
.doc-table thead th {
    background: #1a3c5e;
    color: #fff;
    padding: 10px 12px;
    font-size: .78rem;
    font-weight: 700;
}
.doc-table tbody tr:nth-child(even) {
    background: #f8fafc;
}
.doc-table tbody td {
    padding: 10px 12px;
    border-bottom: 1px solid #e2e8f0;
    vertical-align: top;
    line-height: 1.5;
}
.doc-table .item-name { font-weight: 700; color: #1a3c5e; }
.doc-table .alat-name { color: #0284c7; font-weight: 600; }

/* Consent */
.doc-consent {
    padding: 22px 28px;
    background: #fafafa;
    border-top: 2px solid #e2e8f0;
    font-size: .8rem;
    color: #334155;
    line-height: 1.6;
}

.doc-footer-note {
    background: #f1f5f9;
    padding: 10px 18px;
    font-size: .72rem;
    color: #64748b;
    text-align: center;
    border-top: 1px solid #e2e8f0;
}

@media (max-width: 600px) {
    .doc-header { flex-direction: column; text-align: center; }
    .form-field-row { flex-direction: column; }
    .form-field-row .field-lbl { width: 100%; }
    .form-field-row .field-colon { display: none; }
    .doc-checks-grid { grid-template-columns: 1fr; }
    .ttd-container { grid-template-columns: 1fr; }
}
</style>
@endpush

@section('content')
<div class="py-4" style="background:#eef2f6; min-height: 85vh;">
    <div class="container">
        {{-- Navigasi Kembali (Rapi & Sejajar Dokumen) --}}
        <div style="max-width: 900px; margin: 0 auto 14px auto;">
            <a href="{{ route('pendaftaran.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3 py-1 bg-white shadow-sm d-inline-flex align-items-center gap-2">
                <i class="bi bi-arrow-left"></i>
                <span>Kembali ke Pilihan Program</span>
            </a>
        </div>

        @if($errors->any())
        <div style="max-width: 900px; margin: 0 auto 16px auto;">
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm">
                <i class="bi bi-exclamation-circle-fill me-2"></i><strong>Terdapat kesalahan pada isian Anda:</strong>
                <ul class="mb-0 mt-1 ps-3">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
        @endif

        {{-- FORMULIR DOKUMEN --}}
        <div class="form-document">
            {{-- Kop Surat / Header --}}
            <div class="doc-header">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="doc-header-logo">
                <div class="doc-header-text">
                    <h3>KLINIK UTAMA CAHAYA SURYA</h3>
                    <div class="sub1">Bekerja Sama dengan <strong>Rumah Sakit Mata Solo</strong> • Lampiran Program Skrining Sekolah</div>
                    <div class="sub2">Jl. Raya Solo – Tawangmangu (Jl. Raya Lawu KM 10,6), Jati, Jaten, Karanganyar 57731</div>
                    <div class="sub3">Telp: 0271 495885 | WhatsApp: 0851 7538 2660 | Instagram: @klinik.cahayasurya</div>
                </div>
            </div>

            {{-- Banner Title (Gambar 1) --}}
            <div class="doc-banner-title">
                <h4>FORMULIR PENDAFTARAN SKRINING KESEHATAN MATA</h4>
                <p>Program Deteksi Dini untuk Performa Belajar & Mengajar Optimal (Siswa, Guru & Staf Sekolah)</p>
            </div>

            {{-- Info Bar --}}
            <div class="doc-info-bar">
                <strong>Informasi Layanan:</strong> Layanan On-Site langsung di Sekolah • Didukung Dokter Sp.M • Waktu Efisien (10–15 Menit/Peserta) • Hasil Pemeriksaan Digital (E-Report terintegrasi).
            </div>

            <form action="{{ route('pendaftaran.storeSekolah') }}" method="POST" id="formSekolah" novalidate>
                @csrf

                {{-- ==========================================
                     A. DATA INSTITUSI / SEKOLAH
                ========================================== --}}
                <div class="doc-section-head">A. DATA INSTITUSI / SEKOLAH</div>

                <div class="form-field-row">
                    <div class="field-lbl">Nama Sekolah / Lembaga <span class="text-danger">*</span></div>
                    <div class="field-colon">:</div>
                    <div class="field-input">
                        <input type="text" class="form-control @error('institusi_nama') is-invalid @enderror"
                            name="institusi_nama" value="{{ old('institusi_nama') }}"
                            placeholder="Contoh: SMA Negeri 1 Karanganyar" required>
                    </div>
                </div>

                <div class="form-field-row">
                    <div class="field-lbl">Kategori Peserta <span class="text-danger">*</span></div>
                    <div class="field-colon">:</div>
                    <div class="field-input pt-1">
                        <div class="d-flex flex-wrap gap-4">
                            @foreach(['Siswa / Siswi', 'Guru / Tenaga Pendidik', 'Staf / Karyawan'] as $kat)
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="kategori_peserta"
                                    value="{{ $kat }}" id="k_{{ Str::slug($kat) }}"
                                    {{ old('kategori_peserta') == $kat ? 'checked' : '' }} required>
                                <label class="form-check-label" for="k_{{ Str::slug($kat) }}" style="font-size:.84rem;">
                                    {{ $kat }}
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="form-field-row">
                    <div class="field-lbl">Kelas / Unit Kerja</div>
                    <div class="field-colon">:</div>
                    <div class="field-input">
                        <input type="text" class="form-control" name="kelas_unit"
                            value="{{ old('kelas_unit') }}" placeholder="Contoh: X MIPA 1 / Bagian Tata Usaha">
                    </div>
                </div>

                {{-- ==========================================
                     B. DATA DIRI PESERTA
                ========================================== --}}
                <div class="doc-section-head">B. DATA DIRI PESERTA</div>

                <div class="form-field-row">
                    <div class="field-lbl">Nama Lengkap Peserta <span class="text-danger">*</span></div>
                    <div class="field-colon">:</div>
                    <div class="field-input">
                        <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror"
                            name="nama_lengkap" value="{{ old('nama_lengkap') }}"
                            placeholder="Nama sesuai rapor / kartu identitas" required>
                    </div>
                </div>

                <div class="form-field-row">
                    <div class="field-lbl">NISN / NIP / NIK <span class="text-danger">*</span></div>
                    <div class="field-colon">:</div>
                    <div class="field-input">
                        <input type="text" class="form-control @error('nik') is-invalid @enderror"
                            name="nik" value="{{ old('nik') }}"
                            placeholder="16 digit angka identitas" maxlength="16" required>
                    </div>
                </div>

                <div class="form-field-row">
                    <div class="field-lbl">Tempat, Tanggal Lahir</div>
                    <div class="field-colon">:</div>
                    <div class="field-input">
                        <div class="row g-2">
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="tempat_lahir"
                                    value="{{ old('tempat_lahir') }}" placeholder="Tempat lahir">
                            </div>
                            <div class="col-sm-7">
                                <input type="date" class="form-control" name="tanggal_lahir"
                                    value="{{ old('tanggal_lahir') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-field-row">
                    <div class="field-lbl">Jenis Kelamin <span class="text-danger">*</span></div>
                    <div class="field-colon">:</div>
                    <div class="field-input pt-1">
                        <div class="d-flex gap-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="jenis_kelamin"
                                    value="Laki-laki" id="jk_l" {{ old('jenis_kelamin') == 'Laki-laki' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="jk_l" style="font-size:.84rem;">Laki-laki</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="jenis_kelamin"
                                    value="Perempuan" id="jk_p" {{ old('jenis_kelamin') == 'Perempuan' ? 'checked' : '' }}>
                                <label class="form-check-label" for="jk_p" style="font-size:.84rem;">Perempuan</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-field-row">
                    <div class="field-lbl">No. WhatsApp / HP Aktif <span class="text-danger">*</span></div>
                    <div class="field-colon">:</div>
                    <div class="field-input">
                        <input type="tel" class="form-control @error('no_telepon') is-invalid @enderror"
                            name="no_telepon" value="{{ old('no_telepon') }}"
                            placeholder="Contoh: 081234567890" required>
                    </div>
                </div>

                <div class="form-field-row">
                    <div class="field-lbl">Email (Pengiriman E-Report)</div>
                    <div class="field-colon">:</div>
                    <div class="field-input">
                        <input type="email" class="form-control" name="email_peserta"
                            value="{{ old('email_peserta') }}" placeholder="email@contoh.com">
                    </div>
                </div>

                <div class="form-field-row">
                    <div class="field-lbl">Nama Orang Tua / Wali (Siswa)</div>
                    <div class="field-colon">:</div>
                    <div class="field-input">
                        <input type="text" class="form-control" name="nama_wali"
                            value="{{ old('nama_wali') }}" placeholder="Diisi bagi peserta siswa/siswi">
                    </div>
                </div>

                {{-- ==========================================
                     C. SKRINING AWAL & RIWAYAT KESEHATAN MATA
                ========================================== --}}
                <div class="doc-section-head">C. SKRINING AWAL & RIWAYAT KESEHATAN MATA</div>

                <div class="doc-checks-grid">
                    @foreach([
                        'Menggunakan Kacamata / Lensa Kontak saat ini',
                        'Sering pusing atau sakit kepala saat membaca/menatap layar',
                        'Penglihatan buram / kabur melihat papan tulis atau jauh',
                        'Mata sering merah, perih, berair, atau cepat lelah',
                        'Riwayat keluarga memiliki Glaukoma / Buta Warna',
                        'Pernah mengalami trauma/cedera atau operasi pada mata',
                    ] as $riwayat)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="riwayat_penyakit[]"
                            value="{{ $riwayat }}" id="rw_{{ Str::slug($riwayat) }}"
                            {{ in_array($riwayat, old('riwayat_penyakit', [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="rw_{{ Str::slug($riwayat) }}">
                            {{ $riwayat }}
                        </label>
                    </div>
                    @endforeach
                </div>

                {{-- ==========================================
                     D. PAKET PEMERIKSAAN TERPADU BERBASIS AI
                ========================================== --}}
                <div class="doc-section-head">D. PAKET PEMERIKSAAN TERPADU BERBASIS AI</div>

                <div class="p-3">
                    <div class="table-responsive">
                        <table class="doc-table">
                            <thead>
                                <tr>
                                    <th style="width:24%;">Item Pemeriksaan</th>
                                    <th style="width:34%;">Alat / Metode</th>
                                    <th>Tujuan & Manfaat Klinis</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><span class="item-name">1. Refraksi Lengkap</span></td>
                                    <td><span class="alat-name">Retinomax K-plus3 Handheld Autoref</span></td>
                                    <td>Deteksi akurat minus (miopia), plus (hipermetropia), dan silinder (astigmatisme) secara portabel dan nyaman.</td>
                                </tr>
                                <tr>
                                    <td><span class="item-name">2. Diskriminasi Warna</span></td>
                                    <td><span class="alat-name">Metode Farnsworth-Munsell D15</span></td>
                                    <td>Presisi tinggi deteksi dini buta warna parsial maupun total untuk kesiapan studi & karir.</td>
                                </tr>
                                <tr>
                                    <td><span class="item-name">3. Tekanan Bola Mata</span></td>
                                    <td><span class="alat-name">iCare 100 Portable Tonometer</span></td>
                                    <td>Cegah risiko Glaukoma dengan pengukuran non-kontak tanpa hembusan udara yang menyakitkan.</td>
                                </tr>
                                <tr>
                                    <td><span class="item-name">4. Retina Digital AI</span></td>
                                    <td><span class="alat-name">EyeRobo AI Fundus Camera</span></td>
                                    <td>Evaluasi kondisi saraf mata, retina, & pembuluh darah secara mutakhir, cepat, dan akurat.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- ==========================================
                     CONSENT & TANDA TANGAN
                ========================================== --}}
                <div class="doc-consent">
                    <strong class="d-block mb-1">Pernyataan Persetujuan (Informed Consent):</strong>
                    <p class="mb-3 text-muted" style="font-size:.8rem;line-height:1.6;">
                        Dengan mengisi formulir ini, saya/orang tua/wali peserta memberikan izin kepada tim medis Klinik Utama Cahaya Surya dan RS Mata Solo untuk melakukan rangkaian prosedur skrining kesehatan mata sesuai standar operasional yang berlaku, serta menerima hasil pemeriksaan berupa resume medis digital (E-Report).
                    </p>

                    <div class="form-check p-3 bg-white rounded border mb-4">
                        <input class="form-check-input ms-0 me-2" type="checkbox" name="persetujuan" id="persetujuan" value="1" required>
                        <label class="form-check-label fw-bold text-dark" for="persetujuan" style="font-size:.84rem;">
                            Saya telah membaca, memahami, dan menyetujui pernyataan persetujuan di atas.
                        </label>
                    </div>

                    {{-- Cloudflare Turnstile Captcha Anti-Spam --}}
                    <div class="my-3 d-flex flex-column align-items-center justify-content-center">
                        <div class="cf-turnstile" data-sitekey="{{ config('services.turnstile.site_key') }}"></div>
                        @error('cf-turnstile-response')
                            <div class="text-danger small text-center mt-2 fw-semibold">
                                <i class="bi bi-shield-x me-1"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-center align-items-center gap-3 flex-wrap">
                        <a href="{{ route('pendaftaran.index') }}" class="btn btn-outline-secondary btn-lg px-4 py-3 fw-semibold"
                            style="border-radius:10px;font-size:.92rem;">
                            <i class="bi bi-arrow-left me-1"></i>Kembali
                        </a>
                        <button type="submit" class="btn btn-primary btn-lg px-5 py-3 fw-bold" id="btnSubmitSekolah"
                            style="background:#0284c7;border-color:#0284c7;border-radius:10px;font-size:.95rem;">
                            <i class="bi bi-send-fill me-2"></i>Kirim Formulir Sekolah
                        </button>
                    </div>
                </div>

                <div class="doc-footer-note">
                    Klinik Utama Cahaya Surya • Jl. Raya Solo - Tawangmangu Kec. Jaten Kab. Karanganyar Telp. 0271 495885 • Mata Sehat, Prestasi Hebat!
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
<script>
document.getElementById('formSekolah')?.addEventListener('submit', function(e) {
    const cb = document.getElementById('persetujuan');
    if (!cb.checked) {
        e.preventDefault();
        cb.focus();
        alert('Silakan centang pernyataan persetujuan terlebih dahulu.');
        return;
    }
    const turnstileResponse = document.querySelector('[name="cf-turnstile-response"]');
    if (turnstileResponse && !turnstileResponse.value) {
        e.preventDefault();
        alert('Silakan selesaikan verifikasi Cloudflare Turnstile terlebih dahulu.');
        return;
    }
    const btn = document.getElementById('btnSubmitSekolah');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Memproses pendaftaran...';
});
</script>
@endpush
