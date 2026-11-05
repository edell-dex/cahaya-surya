@extends('layouts.public')

@section('title', 'Formulir Skrining Vaskuler Perusahaan — Klinik Utama Cahaya Surya')

@push('styles')
<style>
.form-document-corp {
    background: #fff;
    border: 1px solid #cbd5e1;
    border-radius: 12px;
    box-shadow: 0 6px 28px rgba(15,118,110,.12);
    overflow: hidden;
    max-width: 920px;
    margin: 0 auto;
}
.corp-header {
    padding: 24px 28px 18px;
    display: flex;
    align-items: center;
    gap: 20px;
    border-bottom: 1px solid #e2e8f0;
}
.corp-header-logo {
    width: 70px;
    height: 70px;
    flex-shrink: 0;
}
.corp-header-text h3 {
    color: #1a3c5e;
    font-weight: 800;
    font-size: 1.3rem;
    margin-bottom: 3px;
    letter-spacing: .02em;
}
.corp-header-text .sub1 {
    font-size: .82rem;
    color: #334155;
    margin-bottom: 3px;
}
.corp-header-text .sub2 {
    font-size: .75rem;
    color: #64748b;
    margin-bottom: 3px;
}
.corp-header-text .sub3 {
    font-size: .74rem;
    color: #0d9488;
    font-weight: 600;
}

.corp-banner-title {
    background: linear-gradient(135deg, #0f766e 0%, #115e59 100%);
    color: #fff;
    text-align: center;
    padding: 16px 20px 14px;
    margin: 18px 24px 12px 24px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(15,118,110,.15);
}
.corp-banner-title h4 {
    font-size: 1.15rem;
    font-weight: 800;
    margin-bottom: 4px;
    letter-spacing: .02em;
    text-transform: uppercase;
}
.corp-banner-title p {
    font-size: .8rem;
    opacity: .95;
    margin: 0;
}
.corp-badge-flyer {
    background: #facc15;
    color: #854d0e;
    font-weight: 800;
    font-size: .7rem;
    padding: 4px 12px;
    border-radius: 20px;
    display: inline-block;
    margin-top: 8px;
    text-transform: uppercase;
    letter-spacing: .03em;
}

.corp-info-bar {
    background: #e6fffa;
    border-left: 4px solid #0d9488;
    border-radius: 6px;
    margin: 0 24px 16px 24px;
    padding: 10px 16px;
    font-size: .78rem;
    color: #0f766e;
    line-height: 1.5;
}

.corp-section-head {
    font-size: .88rem;
    font-weight: 800;
    color: #0f766e;
    text-transform: uppercase;
    letter-spacing: .03em;
    padding: 12px 24px 6px;
    border-bottom: 1.5px solid #e2e8f0;
    background: #f0fdfa;
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
.form-field-row .field-input .form-control,
.form-field-row .field-input .form-select {
    border: none;
    border-bottom: 1.5px dashed #94a3b8;
    border-radius: 0;
    padding: 4px 0;
    font-size: .86rem;
    background: transparent;
}
.form-field-row .field-input .form-control:focus,
.form-field-row .field-input .form-select:focus {
    box-shadow: none;
    border-bottom-color: #0d9488;
    background: transparent;
}

/* 5 Item Layanan Vaskuler Mini-Grid */
.vaskuler-items-box {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    margin: 14px 24px;
    padding: 14px 18px;
}
.vaskuler-item-pill {
    background: #fff;
    border: 1px solid #cbd5e1;
    border-radius: 6px;
    padding: 8px 12px;
    font-size: .78rem;
    line-height: 1.4;
    height: 100%;
}
.vaskuler-item-pill strong { color: #0f766e; }

/* Consent */
.corp-consent {
    padding: 22px 28px;
    background: #fafafa;
    border-top: 2px solid #e2e8f0;
    font-size: .8rem;
    color: #334155;
    line-height: 1.6;
}

.corp-footer-note {
    background: #f1f5f9;
    padding: 10px 18px;
    font-size: .72rem;
    color: #64748b;
    text-align: center;
    border-top: 1px solid #e2e8f0;
}

@media (max-width: 600px) {
    .corp-header { flex-direction: column; text-align: center; }
    .form-field-row { flex-direction: column; }
    .form-field-row .field-lbl { width: 100%; }
    .form-field-row .field-colon { display: none; }
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

        {{-- FORMULIR DOKUMEN PERUSAHAAN --}}
        <div class="form-document-corp">
            {{-- Kop Surat / Header --}}
            <div class="corp-header">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="corp-header-logo">
                <div class="corp-header-text">
                    <h3>KLINIK UTAMA CAHAYA SURYA</h3>
                    <div class="sub1">Bekerjasama dengan <strong>Rumah Sakit Mata Solo</strong> • Lampiran: Flyer Program Skrining Perusahaan</div>
                    <div class="sub2">Jln. Raya Solo – Tawangmangu Kec. Jaten Kab. Karanganyar 57731 Telp. 0271 495885</div>
                    <div class="sub3">Email: klinikcahayasurya@gmail.com | WhatsApp: 0851 7538 2660 | Instagram: @klinik.cahayasurya</div>
                </div>
            </div>

            {{-- Banner Title (Gambar 2 Flyer) --}}
            <div class="corp-banner-title">
                <h4>PROGRAM SKRINING KESEHATAN VASKULER UNTUK PERUSAHAAN</h4>
                <p>Deteksi Dini Jantung, Otak & Mata untuk Karyawan yang Lebih Sehat dan Produktif</p>
                <div>
                    <span class="corp-badge-flyer"><i class="bi bi-star-fill me-1"></i>Tarif Kemitraan On-Site: Subsidi Korporasi / Perusahaan</span>
                </div>
            </div>

            {{-- Info Bar --}}
            <div class="corp-info-bar">
                <strong>Informasi Layanan:</strong> Layanan On-Site langsung di Perusahaan • Efisien 10–15 Menit/Orang • Perangkat Medis Handheld Mutakhir • Hasil Instan & Digital (E-Report) dengan Interpretasi Medis Lengkap.
            </div>

            <form action="{{ route('pendaftaran.storePerusahaan') }}" method="POST" id="formPerusahaan" novalidate>
                @csrf

                {{-- ==========================================
                     A. DATA PERUSAHAAN / INSTITUSI
                ========================================== --}}
                <div class="corp-section-head">A. DATA PERUSAHAAN / LEMBAGA</div>

                <div class="form-field-row">
                    <div class="field-lbl">Nama Perusahaan / Lembaga <span class="text-danger">*</span></div>
                    <div class="field-colon">:</div>
                    <div class="field-input">
                        <input type="text" class="form-control @error('institusi_nama') is-invalid @enderror"
                            name="institusi_nama" value="{{ old('institusi_nama') }}"
                            placeholder="Contoh: PT. Sumber Makmur Abadi" required>
                    </div>
                </div>

                <div class="form-field-row">
                    <div class="field-lbl">Departemen / Divisi / Unit Kerja</div>
                    <div class="field-colon">:</div>
                    <div class="field-input">
                        <input type="text" class="form-control" name="kelas_unit"
                            value="{{ old('kelas_unit') }}" placeholder="Contoh: Divisi Operasional & Produksi">
                    </div>
                </div>

                <div class="form-field-row">
                    <div class="field-lbl">Jabatan / Posisi Pekerjaan</div>
                    <div class="field-colon">:</div>
                    <div class="field-input">
                        <input type="text" class="form-control" name="pekerjaan"
                            value="{{ old('pekerjaan') }}" placeholder="Contoh: Staff HRD, Operator Mesin, Supervisor">
                    </div>
                </div>

                {{-- ==========================================
                     B. DATA DIRI KARYAWAN / PESERTA
                ========================================== --}}
                <div class="corp-section-head">B. DATA DIRI KARYAWAN / PESERTA</div>

                <div class="form-field-row">
                    <div class="field-lbl">Nama Lengkap Karyawan <span class="text-danger">*</span></div>
                    <div class="field-colon">:</div>
                    <div class="field-input">
                        <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror"
                            name="nama_lengkap" value="{{ old('nama_lengkap') }}"
                            placeholder="Nama sesuai KTP" required>
                    </div>
                </div>

                <div class="form-field-row">
                    <div class="field-lbl">NIK / ID Karyawan <span class="text-danger">*</span></div>
                    <div class="field-colon">:</div>
                    <div class="field-input">
                        <input type="text" class="form-control @error('nik') is-invalid @enderror"
                            name="nik" value="{{ old('nik') }}"
                            placeholder="16 digit NIK KTP / No. ID Karyawan" maxlength="16" required>
                    </div>
                </div>

                <div class="form-field-row">
                    <div class="field-lbl">Tempat, Tanggal Lahir</div>
                    <div class="field-colon">:</div>
                    <div class="field-input">
                        <div class="row g-2">
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="tempat_lahir"
                                    value="{{ old('tempat_lahir') }}" placeholder="Kota kelahiran">
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
                                    value="Laki-laki" id="jk_corp_l" {{ old('jenis_kelamin') == 'Laki-laki' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="jk_corp_l" style="font-size:.84rem;">Laki-laki</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="jenis_kelamin"
                                    value="Perempuan" id="jk_corp_p" {{ old('jenis_kelamin') == 'Perempuan' ? 'checked' : '' }}>
                                <label class="form-check-label" for="jk_corp_p" style="font-size:.84rem;">Perempuan</label>
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
                            placeholder="08xx-xxxx-xxxx" required>
                    </div>
                </div>

                <div class="form-field-row">
                    <div class="field-lbl">Email (Pengiriman E-Report)</div>
                    <div class="field-colon">:</div>
                    <div class="field-input">
                        <input type="email" class="form-control" name="email_peserta"
                            value="{{ old('email_peserta') }}" placeholder="karyawan@perusahaan.com">
                    </div>
                </div>

                <div class="form-field-row">
                    <div class="field-lbl">Alamat Domisili</div>
                    <div class="field-colon">:</div>
                    <div class="field-input">
                        <input type="text" class="form-control" name="alamat"
                            value="{{ old('alamat') }}" placeholder="Alamat tempat tinggal saat ini">
                    </div>
                </div>

                {{-- ==========================================
                     C. RIWAYAT KESEHATAN
                ========================================== --}}
                <div class="corp-section-head">C. RIWAYAT KESEHATAN</div>

                {{-- Info Paket Mini Grid (dari Flyer Gambar 2) --}}
                <div class="vaskuler-items-box">
                    <div class="fw-bold mb-2 text-dark small"><i class="bi bi-layers-fill me-1 text-teal"></i>Rangkaian Item Pemeriksaan dalam Program:</div>
                    <div class="row g-2">
                        <div class="col-md-4">
                            <div class="vaskuler-item-pill">
                                <strong>1. Skrining Vaskuler (ABI)</strong>
                                <div>Evaluasi aliran darah tungkai & deteksi risiko PAD.</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="vaskuler-item-pill">
                                <strong>2. Skrining Jantung (Kardia L6)</strong>
                                <div>Evaluasi irama jantung EKG & deteksi risiko kardiovaskular.</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="vaskuler-item-pill">
                                <strong>3. Skrining Mata (EyeRobo AI)</strong>
                                <div>Pemeriksaan retina & pembuluh darah mata berbasis AI.</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="vaskuler-item-pill">
                                <strong>4. Skrining Otak</strong>
                                <div>Evaluasi kondisi vaskuler terkait risiko stroke.</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="vaskuler-item-pill">
                                <strong>5. Pemeriksaan Metabolik (GCU)</strong>
                                <div>Skrining Gula Darah, Kolesterol, & Asam Urat.</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="vaskuler-item-pill" style="background:#e6fffa;border-color:#14b8a6">
                                <strong style="color:#0f766e">6. E-Report Digital</strong>
                                <div>Hasil instan lengkap dengan rekomendasi & interpretasi medis.</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-field-row">
                    <div class="field-lbl">Riwayat Penyakit Pribadi</div>
                    <div class="field-colon">:</div>
                    <div class="field-input pt-1">
                        <div class="row g-2">
                            @foreach(['Hipertensi (Tekanan Darah Tinggi)','Diabetes Melitus','Penyakit Jantung','Stroke / TIA','Kolesterol Tinggi','Asam Urat','Pernah Nyeri Dada / Sesak Napas','Pegal / Kram Kaki Saat Berjalan'] as $rp)
                            <div class="col-sm-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="riwayat_penyakit[]"
                                        value="{{ $rp }}" id="crp_{{ Str::slug($rp) }}"
                                        {{ in_array($rp, old('riwayat_penyakit', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="crp_{{ Str::slug($rp) }}" style="font-size:.82rem;">
                                        {{ $rp }}
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="form-field-row">
                    <div class="field-lbl">Riwayat Penyakit Keluarga</div>
                    <div class="field-colon">:</div>
                    <div class="field-input pt-1">
                        <div class="row g-2">
                            @foreach(['Hipertensi','Diabetes','Serangan Jantung','Stroke','Kolesterol Tinggi'] as $rk)
                            <div class="col-sm-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="riwayat_keluarga[]"
                                        value="{{ $rk }}" id="crk_{{ Str::slug($rk) }}"
                                        {{ in_array($rk, old('riwayat_keluarga', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="crk_{{ Str::slug($rk) }}" style="font-size:.82rem;">
                                        {{ $rk }}
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="form-field-row">
                    <div class="field-lbl">Keluhan / Gejala Utama</div>
                    <div class="field-colon">:</div>
                    <div class="field-input">
                        <textarea class="form-control" name="keluhan_utama" rows="2"
                            placeholder="Keluhan yang sering dirasakan (misal: mudah lelah, kesemutan, pusing, dll)">{{ old('keluhan_utama') }}</textarea>
                    </div>
                </div>

                {{-- ==========================================
                     CONSENT & TANDA TANGAN KARYAWAN
                ========================================== --}}
                <div class="corp-consent">
                    <strong class="d-block mb-1">Pernyataan Persetujuan (Informed Consent):</strong>
                    <p class="mb-3 text-muted" style="font-size:.8rem;line-height:1.6;">
                        Dengan mengisi formulir pendaftaran ini, saya menyatakan bersedia mengikuti rangkaian prosedur Program Skrining Kesehatan Vaskuler yang diselenggarakan oleh Klinik Utama Cahaya Surya bersama Rumah Sakit Mata Solo di lingkungan perusahaan, serta setuju menerima hasil berupa resume medis digital (E-Report).
                    </p>

                    <div class="form-check p-3 bg-white rounded border mb-4">
                        <input class="form-check-input ms-0 me-2" type="checkbox" name="persetujuan" id="persetujuanCorp" value="1" required>
                        <label class="form-check-label fw-bold text-dark" for="persetujuanCorp" style="font-size:.84rem;">
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
                        <button type="submit" class="btn btn-teal btn-lg px-5 py-3 fw-bold" id="btnSubmitCorp"
                            style="border-radius:10px;font-size:.95rem;">
                            <i class="bi bi-send-fill me-2"></i>Kirim Formulir Perusahaan
                        </button>
                    </div>
                </div>

                <div class="corp-footer-note">
                    Kenali Risikonya, Cegah Lebih Dini, Jaga Produktivitas Karyawan • Klinik Utama Cahaya Surya & RS Mata Solo
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
<script>
document.getElementById('formPerusahaan')?.addEventListener('submit', function(e) {
    const cb = document.getElementById('persetujuanCorp');
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
    const btn = document.getElementById('btnSubmitCorp');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Memproses pendaftaran...';
});
</script>
@endpush
