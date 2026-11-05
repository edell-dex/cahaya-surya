@extends('layouts.public')

@section('title', 'Klinik Utama Cahaya Surya — Layanan & Pendaftaran Skrining')

@push('styles')
<style>
/* Portal Pemilihan */
.portal-card {
    background: #fff;
    border-radius: 18px;
    border: 2px solid transparent;
    padding: 32px 26px;
    transition: all .3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    box-shadow: 0 4px 20px rgba(26,60,94,.08);
    position: relative;
    overflow: hidden;
}
.portal-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 6px;
}
.portal-card.sekolah::before {
    background: linear-gradient(90deg, #2563eb, #38bdf8);
}
.portal-card.perusahaan::before {
    background: linear-gradient(90deg, #0d9488, #14b8a6);
}
.portal-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 16px 36px rgba(26,60,94,.16);
}
.portal-card.sekolah:hover {
    border-color: #3b82f6;
}
.portal-card.perusahaan:hover {
    border-color: #0d9488;
}
.portal-badge {
    display: inline-block;
    font-size: .72rem;
    font-weight: 700;
    padding: 4px 12px;
    border-radius: 20px;
    text-transform: uppercase;
    letter-spacing: .06em;
    margin-bottom: 12px;
}
.badge-sekolah { background: rgba(37,99,235,.1); color: #2563eb; }
.badge-perusahaan { background: rgba(13,148,136,.1); color: #0d9488; }
.portal-icon {
    width: 64px;
    height: 64px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    margin-bottom: 16px;
}
.p-icon-sekolah { background: linear-gradient(135deg, #1e40af, #3b82f6); color: #fff; }
.p-icon-perusahaan { background: linear-gradient(135deg, #0f766e, #14b8a6); color: #fff; }
.portal-title {
    font-size: 1.25rem;
    font-weight: 800;
    color: #1a3c5e;
    margin-bottom: 8px;
}
.portal-desc {
    font-size: .86rem;
    color: #64748b;
    line-height: 1.6;
    margin-bottom: 20px;
}
.portal-features {
    list-unstyled: true;
    padding-left: 0;
    margin-bottom: 24px;
}
.portal-features li {
    font-size: .82rem;
    color: #334155;
    padding: 6px 0;
    border-bottom: 1px dashed #e2e8f0;
    display: flex;
    align-items: center;
    gap: 8px;
}
.portal-features li i { font-size: 1rem; }
.portal-features li:last-child { border-bottom: none; }

/* Layanan Flyer Section */
.layanan-vaskuler { background: #f8fafc; }
.program-badge {
    display: inline-block;
    background: linear-gradient(135deg,#1a3c5e,#2557a7);
    color: #fff;
    font-size: .72rem;
    font-weight: 700;
    padding: 4px 16px;
    border-radius: 20px;
    text-transform: uppercase;
    letter-spacing: .08em;
    margin-bottom: 10px;
}
.skrining-card {
    background: #fff;
    border-radius: 14px;
    border: 1px solid #e2e8f0;
    overflow: hidden;
    height: 100%;
    transition: all .25s;
    box-shadow: 0 2px 8px rgba(26,60,94,.06);
}
.skrining-card:hover { transform: translateY(-4px); box-shadow: 0 8px 24px rgba(26,60,94,.12); }
.skrining-card-header {
    padding: 16px 18px 12px;
    display: flex;
    align-items: flex-start;
    gap: 12px;
}
.skrining-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.4rem;
    flex-shrink: 0;
}
.ic-red    { background: rgba(220,38,38,.1);   color: #dc2626; }
.ic-pink   { background: rgba(236,72,153,.1);  color: #ec4899; }
.ic-blue   { background: rgba(37,99,235,.1);   color: #2563eb; }
.ic-purple { background: rgba(124,58,237,.1);  color: #7c3aed; }
.ic-teal   { background: rgba(13,148,136,.1);  color: #0d9488; }
.skrining-card-title { font-size: .95rem; font-weight: 800; color: #1a3c5e; margin-bottom: 2px; }
.skrining-card-sub   { font-size: .74rem; color: #0d9488; font-weight: 600; }
.skrining-card-body  { padding: 0 18px 16px; }
.skrining-card-body ul { padding-left: 16px; margin: 0; }
.skrining-card-body ul li { font-size: .8rem; color: #374151; line-height: 1.7; }

/* Keunggulan */
.keunggulan-card {
    background: #fff;
    border-radius: 12px;
    padding: 18px 14px;
    text-align: center;
    border: 1px solid #e2e8f0;
    box-shadow: 0 1px 6px rgba(0,0,0,.04);
    height: 100%;
    transition: all .2s;
}
.keunggulan-card:hover { transform: translateY(-3px); box-shadow: 0 6px 18px rgba(26,60,94,.1); }
.keunggulan-icon { font-size: 1.8rem; margin-bottom: 8px; }
.keunggulan-card h6 { font-size: .82rem; font-weight: 700; color: #1a3c5e; margin-bottom: 4px; }
.keunggulan-card p  { font-size: .73rem; color: #64748b; margin: 0; line-height: 1.5; }

/* Manfaat bar */
.manfaat-bar {
    background: linear-gradient(135deg, #1a3c5e 0%, #2557a7 100%);
    border-radius: 14px;
    padding: 24px;
    color: #fff;
}
.manfaat-item { text-align: center; }
.manfaat-item i { font-size: 1.8rem; color: #14b8a6; margin-bottom: 8px; }
.manfaat-item h6 { font-size: .78rem; font-weight: 700; margin-bottom: 3px; }
.manfaat-item p  { font-size: .7rem; opacity: .8; margin: 0; line-height: 1.4; }

/* Hasil E-Report bar */
.hasil-bar {
    background: #0d9488;
    border-radius: 10px;
    padding: 14px 18px;
    display: flex;
    align-items: center;
    gap: 14px;
    color: #fff;
}
.hasil-bar i { font-size: 2.2rem; opacity: .9; }
.hasil-bar h6 { font-weight: 800; font-size: .92rem; margin: 0; }
.hasil-bar p  { font-size: .78rem; opacity: .9; margin: 0; }

/* ================================================================
   SLIDESHOW EDUKASI: RESPONSIF & PANAH BIRU SELARAS TEMA
================================================================ */
.edu-carousel-box {
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 12px 36px rgba(26, 60, 94, 0.16);
    border: 2px solid rgba(26, 60, 94, 0.14);
    background: #ffffff;
    position: relative;
}
.edu-carousel-box .carousel-inner {
    aspect-ratio: 16 / 9;
    width: 100%;
    background: #ffffff;
}
.edu-carousel-box .carousel-item {
    height: 100%;
}
.edu-slide-img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    display: block;
    background: #ffffff;
}

/* Panah Slideshow Murni Biru (#1a3c5e) Tanpa Lingkaran / Background */
.edu-carousel-box .carousel-control-prev,
.edu-carousel-box .carousel-control-next {
    width: 9%;
    background: transparent !important;
    border: none !important;
    opacity: 0.85;
    transition: opacity 0.2s ease, transform 0.2s ease;
}
.edu-carousel-box .carousel-control-prev:hover,
.edu-carousel-box .carousel-control-next:hover {
    opacity: 1;
    transform: scale(1.15);
}
.edu-carousel-box .carousel-control-prev-icon {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%231a3c5e'%3e%3cpath d='M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z'/%3e%3c/svg%3e") !important;
    width: 3.2rem;
    height: 3.2rem;
    filter: drop-shadow(0 2px 4px rgba(255, 255, 255, 0.85));
}
.edu-carousel-box .carousel-control-next-icon {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%231a3c5e'%3e%3cpath d='M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e") !important;
    width: 3.2rem;
    height: 3.2rem;
    filter: drop-shadow(0 2px 4px rgba(255, 255, 255, 0.85));
}

/* Indikator Slide Selaras */
.edu-indicators {
    margin-bottom: 12px;
}
.edu-indicators [data-bs-target] {
    width: 10px !important;
    height: 10px !important;
    border-radius: 50% !important;
    background-color: rgba(26, 60, 94, 0.35) !important;
    border: 1px solid rgba(255, 255, 255, 0.8) !important;
    margin: 0 4px !important;
    transition: all 0.3s ease !important;
    opacity: 0.85 !important;
}
.edu-indicators .active {
    width: 28px !important;
    border-radius: 10px !important;
    background-color: #1a3c5e !important;
    opacity: 1 !important;
}

/* Responsif Mobile & Tablet */
@media (max-width: 768px) {
    .edu-carousel-box .carousel-control-prev-icon,
    .edu-carousel-box .carousel-control-next-icon {
        width: 2.3rem;
        height: 2.3rem;
    }
    .edu-indicators [data-bs-target] {
        width: 8px !important;
        height: 8px !important;
        margin: 0 3px !important;
    }
    .edu-indicators .active {
        width: 20px !important;
    }
}

@media (max-width: 576px) {
    .edu-carousel-box .carousel-control-prev-icon,
    .edu-carousel-box .carousel-control-next-icon {
        width: 1.85rem;
        height: 1.85rem;
    }
}
</style>
@endpush

@section('content')

{{-- ================================================================
     HERO SECTION
================================================================ --}}
<section class="hero-section" id="beranda">
    <div class="container">
        <div class="row align-items-center" style="min-height:75vh">
            <div class="col-lg-7 text-white py-5">
                <span class="badge mb-3 px-3 py-2" style="background:var(--teal);font-size:.82rem;">
                    <i class="bi bi-hospital me-1"></i>Klinik Utama Cahaya Surya & Rumah Sakit Mata Solo
                </span>
                <h1 class="display-4 fw-bold mb-3">Portal Pendaftaran<br>Skrining Kesehatan Formal</h1>
                <p class="lead mb-4" style="opacity:.9">
                    Program deteksi dini kesehatan terpadu berbasis teknologi mutakhir dan AI untuk <strong>Sekolah</strong> (Siswa & Guru) dan <strong>Perusahaan</strong> (Karyawan & Manajemen).
                </p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="#pilih-pendaftaran" class="btn btn-teal btn-lg px-4">
                        <i class="bi bi-ui-checks-grid me-2"></i>Pilih Formulir Pendaftaran
                    </a>
                    <a href="#layanan" class="btn btn-outline-light btn-lg px-4">
                        <i class="bi bi-info-circle me-2"></i>Informasi Layanan
                    </a>
                </div>
                <div class="row mt-5 g-3">
                    <div class="col-4"><div class="stat-box"><div class="stat-num">On-Site</div><div class="stat-lbl">Layanan di Lokasi</div></div></div>
                    <div class="col-4"><div class="stat-box"><div class="stat-num">AI Digital</div><div class="stat-lbl">Teknologi Modern</div></div></div>
                    <div class="col-4"><div class="stat-box"><div class="stat-num">E-Report</div><div class="stat-lbl">Hasil Terintegrasi</div></div></div>
                </div>
            </div>
            <div class="col-lg-5 d-none d-lg-flex justify-content-center">
                <i class="bi bi-hospital-fill hero-icon"></i>
            </div>
        </div>
    </div>
    <div class="hero-wave"><svg viewBox="0 0 1200 120" preserveAspectRatio="none"><path d="M0,60 C200,120 400,0 600,60 C800,120 1000,0 1200,60 L1200,120 L0,120 Z" fill="#f8f9fa"/></svg></div>
</section>

{{-- ================================================================
     PILIHAN PENDAFTARAN (SEKOLAH vs PERUSAHAAN)
================================================================ --}}
<div id="daftar"></div>
<section class="py-5" id="pilih-pendaftaran" style="background:#f0f4f8;">
    <div class="container py-3">
        <div class="text-center mb-5">
            <div class="program-badge">Langkah Pendaftaran</div>
            <h2 class="section-title">Pilih Kategori Pendaftar Anda</h2>
            <p class="section-desc">Silakan pilih apakah Anda mendaftar melalui Program Sekolah atau Program Perusahaan</p>
        </div>

        <div class="row g-4 justify-content-center">
            {{-- PILIHAN 1: SEKOLAH --}}
            <div class="col-md-6 col-lg-5">
                <div class="portal-card sekolah">
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="portal-badge badge-sekolah"><i class="bi bi-mortarboard-fill me-1"></i>Program Sekolah</span>
                            <small class="text-muted">Formulir 1</small>
                        </div>
                        <div class="portal-icon p-icon-sekolah">
                            <i class="bi bi-eye-fill"></i>
                        </div>
                        <h3 class="portal-title">Skrining Kesehatan Mata Sekolah</h3>
                        <p class="portal-desc">
                            Khusus untuk <strong>Siswa/Siswi, Guru, dan Staf Sekolah</strong>. Program deteksi dini tajam penglihatan dan kesehatan mata untuk performa belajar & mengajar optimal.
                        </p>
                        <ul class="portal-features">
                            <li><i class="bi bi-check-circle-fill text-primary"></i> <strong>Refraksi Lengkap</strong> (Retinomax K-plus3 Handheld)</li>
                            <li><i class="bi bi-check-circle-fill text-primary"></i> <strong>Diskriminasi Warna</strong> (Farnsworth-Munsell D15)</li>
                            <li><i class="bi bi-check-circle-fill text-primary"></i> <strong>Tekanan Bola Mata</strong> (iCare 100 Tonometer)</li>
                            <li><i class="bi bi-check-circle-fill text-primary"></i> <strong>Retina Digital AI</strong> (EyeRobo AI Fundus Camera)</li>
                            <li><i class="bi bi-check-circle-fill text-primary"></i> Resume Medis Digital (E-Report) untuk Orang Tua & Siswa</li>
                        </ul>
                    </div>
                    <div>
                        <a href="{{ route('pendaftaran.sekolah') }}" class="btn btn-primary w-100 py-3 fw-bold" style="background:#2563eb;border-color:#2563eb;border-radius:10px;">
                            <i class="bi bi-clipboard2-check me-2"></i>Buka Formulir Sekolah
                        </a>
                    </div>
                </div>
            </div>

            {{-- PILIHAN 2: PERUSAHAAN --}}
            <div class="col-md-6 col-lg-5">
                <div class="portal-card perusahaan">
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="portal-badge badge-perusahaan"><i class="bi bi-building-fill me-1"></i>Program Perusahaan</span>
                            <small class="text-muted">Formulir 2</small>
                        </div>
                        <div class="portal-icon p-icon-perusahaan">
                            <i class="bi bi-heart-pulse-fill"></i>
                        </div>
                        <h3 class="portal-title">Skrining Kesehatan Vaskuler Perusahaan</h3>
                        <p class="portal-desc">
                            Khusus untuk <strong>Karyawan, Tenaga Kerja, & Manajemen Perusahaan</strong>. Deteksi dini risiko kardiovaskular, jantung, otak, dan gangguan metabolik.
                        </p>
                        <ul class="portal-features">
                            <li><i class="bi bi-check-circle-fill text-teal" style="color:#0d9488"></i> <strong>Skrining Vaskuler</strong> (Ankle Brachial Index / ABI)</li>
                            <li><i class="bi bi-check-circle-fill text-teal" style="color:#0d9488"></i> <strong>Skrining Jantung</strong> (EKG Kardia L6 Portable)</li>
                            <li><i class="bi bi-check-circle-fill text-teal" style="color:#0d9488"></i> <strong>Skrining Mata AI</strong> (Retina & Vaskuler Mata)</li>
                            <li><i class="bi bi-check-circle-fill text-teal" style="color:#0d9488"></i> <strong>Evaluasi Vaskular Otak</strong> (Deteksi Risiko Stroke)</li>
                            <li><i class="bi bi-check-circle-fill text-teal" style="color:#0d9488"></i> <strong>Pemeriksaan Metabolik</strong> (Gula, Kolesterol, Asam Urat)</li>
                        </ul>
                    </div>
                    <div>
                        <a href="{{ route('pendaftaran.perusahaan') }}" class="btn btn-teal w-100 py-3 fw-bold" style="border-radius:10px;">
                            <i class="bi bi-clipboard2-pulse me-2"></i>Buka Formulir Perusahaan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ================================================================
     LAYANAN UTAMA (FLYER PROGRAM PERUSAHAAN - GAMBAR 2)
================================================================ --}}
<section class="layanan-vaskuler py-5" id="layanan">
    <div class="container py-3">
        <div class="text-center mb-5">
            <div class="program-badge">Program Unggulan</div>
            <h2 class="section-title">Paket Skrining Jantung, Otak, Mata & Vaskuler Terpadu</h2>
            <p class="section-desc">Deteksi Dini Jantung, Otak & Mata untuk Karyawan yang Lebih Sehat dan Produktif</p>
        </div>

        {{-- 5 Kartu Skrining + 1 Hasil E-Report --}}
        <div class="row g-4 mb-4">
            {{-- 1. Vaskuler --}}
            <div class="col-sm-6 col-lg-4">
                <div class="skrining-card">
                    <div class="skrining-card-header">
                        <div class="skrining-icon ic-red"><i class="bi bi-arrow-left-right"></i></div>
                        <div>
                            <div class="skrining-card-title">Skrining Vaskuler</div>
                            <div class="skrining-card-sub">dengan Ankle Brachial Index (ABI)</div>
                        </div>
                    </div>
                    <div class="skrining-card-body">
                        <ul>
                            <li>Evaluasi aliran darah pada tungkai</li>
                            <li>Deteksi dini risiko PAD (Peripheral Artery Disease)</li>
                            <li>Menggunakan alat Kardia L6 / Doppler</li>
                            <li>Non-invasif, cepat & akurat</li>
                        </ul>
                    </div>
                </div>
            </div>
            {{-- 2. Jantung --}}
            <div class="col-sm-6 col-lg-4">
                <div class="skrining-card">
                    <div class="skrining-card-header">
                        <div class="skrining-icon ic-pink"><i class="bi bi-heart-pulse-fill"></i></div>
                        <div>
                            <div class="skrining-card-title">Skrining Jantung</div>
                            <div class="skrining-card-sub">dengan Kardia L6</div>
                        </div>
                    </div>
                    <div class="skrining-card-body">
                        <ul>
                            <li>Evaluasi irama jantung (EKG 6-Lead)</li>
                            <li>Deteksi risiko kardiovaskular</li>
                            <li>Pemeriksaan cepat, akurat, dan non-invasif</li>
                        </ul>
                    </div>
                </div>
            </div>
            {{-- 3. Mata --}}
            <div class="col-sm-6 col-lg-4">
                <div class="skrining-card">
                    <div class="skrining-card-header">
                        <div class="skrining-icon ic-blue"><i class="bi bi-eye-fill"></i></div>
                        <div>
                            <div class="skrining-card-title">Skrining Mata</div>
                            <div class="skrining-card-sub">dengan EyeRobo Fundus Camera</div>
                        </div>
                    </div>
                    <div class="skrining-card-body">
                        <ul>
                            <li>Pemeriksaan retina dan pembuluh darah mata</li>
                            <li>Deteksi dini gangguan mata dan perubahan vaskuler retina</li>
                        </ul>
                    </div>
                </div>
            </div>
            {{-- 4. Otak --}}
            <div class="col-sm-6 col-lg-4">
                <div class="skrining-card">
                    <div class="skrining-card-header">
                        <div class="skrining-icon ic-purple"><i class="bi bi-cpu-fill"></i></div>
                        <div>
                            <div class="skrining-card-title">Skrining Otak</div>
                            <div class="skrining-card-sub">Evaluasi Vaskular Otak</div>
                        </div>
                    </div>
                    <div class="skrining-card-body">
                        <ul>
                            <li>Deteksi dini faktor risiko stroke</li>
                            <li>Evaluasi kondisi vaskuler yang berkaitan dengan kesehatan otak</li>
                        </ul>
                    </div>
                </div>
            </div>
            {{-- 5. Metabolik --}}
            <div class="col-sm-6 col-lg-4">
                <div class="skrining-card">
                    <div class="skrining-card-header">
                        <div class="skrining-icon ic-teal"><i class="bi bi-droplet-half"></i></div>
                        <div>
                            <div class="skrining-card-title">Pemeriksaan Metabolik</div>
                            <div class="skrining-card-sub">dengan EasyTouch GCU</div>
                        </div>
                    </div>
                    <div class="skrining-card-body">
                        <ul>
                            <li>Gula darah</li>
                            <li>Kolesterol total</li>
                            <li>Asam urat</li>
                        </ul>
                    </div>
                </div>
            </div>
            {{-- Hasil E-Report --}}
            <div class="col-sm-6 col-lg-4 d-flex align-items-stretch">
                <div class="hasil-bar w-100">
                    <i class="bi bi-file-earmark-medical-fill"></i>
                    <div>
                        <h6>Hasil Instan & Digital (E-Report)</h6>
                        <p>Hasil pemeriksaan langsung tersedia dalam bentuk E-Report lengkap dengan interpretasi dan rekomendasi medis.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Keunggulan Layanan --}}
        <h5 class="fw-bold text-center text-primary mb-3 mt-5">Keunggulan Layanan</h5>
        <div class="row g-3 mb-5">
            @foreach([
                ['bi-building-check','🏢','Layanan On-Site di Perusahaan','Pemeriksaan dilakukan langsung di lokasi perusahaan.'],
                ['bi-clock-history','⏱','Efisien 10–15 Menit/Orang','Meminimalkan waktu yang dibutuhkan karyawan.'],
                ['bi-phone-fill','📱','Teknologi Medis Handheld','Perangkat medis portabel untuk pemeriksaan yang praktis dan modern.'],
                ['bi-file-earmark-bar-graph-fill','📊','Hasil Instan & Digital (E-Report)','Hasil pemeriksaan tersedia dalam bentuk E-Report.'],
                ['bi-person-check-fill','👨‍⚕️','Interpretasi & Rekomendasi Medis','Hasil dilengkapi arahan tindak lanjut dari tenaga medis profesional.'],
            ] as $k)
            <div class="col-sm-6 col-lg">
                <div class="keunggulan-card">
                    <div class="keunggulan-icon">{{ $k[1] }}</div>
                    <h6>{{ $k[2] }}</h6>
                    <p>{{ $k[3] }}</p>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Manfaat Bagi Perusahaan --}}
        <div class="manfaat-bar">
            <h5 class="fw-bold text-center text-white mb-4">
                <i class="bi bi-shield-check me-2" style="color:#14b8a6"></i>Manfaat Bagi Perusahaan
            </h5>
            <div class="row g-3 text-center">
                @foreach([
                    ['bi-graph-up-arrow','Menunjang Produktivitas Karyawan','Deteksi dini membantu menjaga kesehatan dan kebugaran karyawan.'],
                    ['bi-shield-plus','Deteksi Risiko Penyakit Tidak Menular','Mengenali faktor risiko jantung, stroke, diabetes, dan gangguan mata lebih awal.'],
                    ['bi-briefcase-fill','Mendukung Program K3 Perusahaan','Menjadi bagian dari upaya menjaga kesehatan tenaga kerja.'],
                    ['bi-people-fill','Meningkatkan Employee Wellbeing','Wujud kepedulian perusahaan terhadap kesehatan karyawan.'],
                    ['bi-file-earmark-check-fill','E-Report Kesehatan','Hasil pemeriksaan terdokumentasi secara digital.'],
                ] as $m)
                <div class="col-sm-6 col-lg">
                    <div class="manfaat-item">
                        <i class="bi {{ $m[0] }}"></i>
                        <h6>{{ $m[1] }}</h6>
                        <p>{{ $m[2] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ================================================================
     SLIDESHOW EDUKASI KESEHATAN MATA (SISWA)
================================================================ --}}
@php
    /* Ambil file gambar edukasi mata dari folder public/images/siswa_mata */
    $imgMataRaw = array_merge(
        glob(public_path('images/siswa_mata/*.jpg'))  ?: [],
        glob(public_path('images/siswa_mata/*.jpeg')) ?: [],
        glob(public_path('images/siswa_mata/*.png'))  ?: [],
        glob(public_path('images/siswa_mata/*.gif'))  ?: [],
        glob(public_path('images/siswa_mata/*.webp')) ?: [],
        glob(public_path('images/siswa_mata/*.JPG'))  ?: [],
        glob(public_path('images/siswa_mata/*.PNG'))  ?: []
    );
    sort($imgMataRaw);
    $imgMata = collect($imgMataRaw)->map(fn($p) => asset('images/siswa_mata/' . rawurlencode(basename($p))))->values();
@endphp
<section class="py-5" id="edukasi-mata" style="background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);">
    <div class="container py-2">
        <div class="text-center mb-4">
            <span class="section-badge" style="background:rgba(37,99,235,.1);color:#2563eb;">
                <i class="bi bi-eye-fill me-1"></i>Edukasi Kesehatan
            </span>
            <h2 class="section-title">Edukasi Kesehatan Mata</h2>
            <p class="section-desc">Kenali pentingnya menjaga kesehatan mata sejak dini untuk siswa dan generasi muda</p>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-9">
                @if($imgMata->isNotEmpty())
                {{-- ===== Carousel Slide Presentasi Edukasi Mata ===== --}}
                <div id="carouselMata" class="carousel slide carousel-fade edu-carousel-box"
                     data-bs-ride="carousel" data-bs-interval="4500">
                    <div class="carousel-indicators edu-indicators">
                        @foreach($imgMata as $i => $img)
                        <button type="button" data-bs-target="#carouselMata" data-bs-slide-to="{{ $i }}"
                            class="{{ $i === 0 ? 'active' : '' }}" aria-label="Slide {{ $i + 1 }}"></button>
                        @endforeach
                    </div>
                    <div class="carousel-inner">
                        @foreach($imgMata as $i => $img)
                        <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
                            <img src="{{ $img }}" class="edu-slide-img"
                                 alt="Edukasi Kesehatan Mata Slide {{ $i + 1 }}" loading="lazy">
                        </div>
                        @endforeach
                    </div>
                    {{-- Tombol Navigasi Panah Biru Murni Tanpa Lingkaran --}}
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselMata" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Slide Sebelumnya</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselMata" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Slide Selanjutnya</span>
                    </button>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-2 px-1">
                    <small class="text-muted"><i class="bi bi-shield-check text-primary me-1"></i>Materi Resmi Skrining Sekolah</small>
                    <small class="text-muted"><i class="bi bi-images me-1"></i>{{ $imgMata->count() }} Slide Materi</small>
                </div>
                @else
                {{-- ===== Placeholder kartu infografis jika belum ada gambar ===== --}}
                <div class="row g-3">
                    @foreach([
                        ['bi-eye','#2563eb','Tajam Penglihatan','Periksa visus mata secara rutin setiap tahun untuk mendeteksi gangguan refraksi sejak dini.'],
                        ['bi-droplet','#7c3aed','Tekanan Bola Mata','Tekanan bola mata normal 10–21 mmHg. Pemeriksaan tonometri membantu deteksi glaukoma.'],
                        ['bi-palette','#0891b2','Buta Warna','Tes Ishihara dan Munsell 15 mendeteksi gangguan diskriminasi warna yang perlu diketahui sejak dini.'],
                        ['bi-camera','#0d9488','Foto Fundus AI','EyeRobo menganalisis retina dengan kecerdasan buatan untuk deteksi dini kelainan pembuluh darah mata.'],
                    ] as $tip)
                    <div class="col-sm-6">
                        <div class="edu-tip-card h-100 p-3 rounded-3 bg-white border" style="border-left:4px solid {{ $tip[1] }} !important;">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <i class="bi {{ $tip[0] }} fs-4" style="color:{{ $tip[1] }}"></i>
                                <span class="fw-bold small" style="color:#1a3c5e">{{ $tip[2] }}</span>
                            </div>
                            <p class="text-muted mb-0" style="font-size:.8rem;line-height:1.6;">{{ $tip[3] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
                <p class="text-center text-muted small mt-3 mb-0">
                    <i class="bi bi-info-circle me-1"></i>
                    Materi edukasi berupa gambar dapat ditambahkan di folder <code>public/images/siswa_mata/</code>
                </p>
                @endif
            </div>
        </div>
    </div>
</section>

{{-- ================================================================
     SLIDESHOW EDUKASI KESEHATAN VASKULER (KARYAWAN)
================================================================ --}}
@php
    /* Ambil file gambar edukasi vaskuler dari folder public/images/karyawan_vaskuler */
    $imgVaskulerRaw = array_merge(
        glob(public_path('images/karyawan_vaskuler/*.jpg'))  ?: [],
        glob(public_path('images/karyawan_vaskuler/*.jpeg')) ?: [],
        glob(public_path('images/karyawan_vaskuler/*.png'))  ?: [],
        glob(public_path('images/karyawan_vaskuler/*.gif'))  ?: [],
        glob(public_path('images/karyawan_vaskuler/*.webp')) ?: [],
        glob(public_path('images/karyawan_vaskuler/*.JPG'))  ?: [],
        glob(public_path('images/karyawan_vaskuler/*.PNG'))  ?: []
    );
    sort($imgVaskulerRaw);
    $imgVaskuler = collect($imgVaskulerRaw)->map(fn($p) => asset('images/karyawan_vaskuler/' . rawurlencode(basename($p))))->values();
@endphp
<section class="py-5" id="edukasi-vaskuler" style="background: linear-gradient(135deg, #f0fdfa 0%, #ccfbf1 100%);">
    <div class="container py-2">
        <div class="text-center mb-4">
            <span class="section-badge" style="background:rgba(13,148,136,.1);color:#0d9488;">
                <i class="bi bi-heart-pulse-fill me-1"></i>Edukasi Kesehatan
            </span>
            <h2 class="section-title" style="color:#0f766e;">Edukasi Kesehatan Vaskuler</h2>
            <p class="section-desc">Pahami risiko penyakit kardiovaskular dan cara menjaga kesehatan jantung serta pembuluh darah</p>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-9">
                @if($imgVaskuler->isNotEmpty())
                {{-- ===== Carousel Slide Presentasi Edukasi Vaskuler ===== --}}
                <div id="carouselVaskuler" class="carousel slide carousel-fade edu-carousel-box"
                     data-bs-ride="carousel" data-bs-interval="4500">
                    <div class="carousel-indicators edu-indicators">
                        @foreach($imgVaskuler as $i => $img)
                        <button type="button" data-bs-target="#carouselVaskuler" data-bs-slide-to="{{ $i }}"
                            class="{{ $i === 0 ? 'active' : '' }}" aria-label="Slide {{ $i + 1 }}"></button>
                        @endforeach
                    </div>
                    <div class="carousel-inner">
                        @foreach($imgVaskuler as $i => $img)
                        <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
                            <img src="{{ $img }}" class="edu-slide-img"
                                 alt="Edukasi Kesehatan Vaskuler Slide {{ $i + 1 }}" loading="lazy">
                        </div>
                        @endforeach
                    </div>
                    {{-- Tombol Navigasi Panah Biru Murni Tanpa Lingkaran --}}
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselVaskuler" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Slide Sebelumnya</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselVaskuler" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Slide Selanjutnya</span>
                    </button>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-2 px-1">
                    <small class="text-muted"><i class="bi bi-shield-check text-success me-1"></i>Materi Resmi Skrining Perusahaan</small>
                    <small class="text-muted"><i class="bi bi-images me-1"></i>{{ $imgVaskuler->count() }} Slide Materi</small>
                </div>
                @else
                {{-- ===== Placeholder kartu infografis jika belum ada gambar ===== --}}
                <div class="row g-3">
                    @foreach([
                        ['bi-arrow-left-right','#dc2626','Ankle Brachial Index (ABI)','Pemeriksaan ABI mendeteksi risiko penyakit arteri perifer (PAD) yang sering tanpa gejala.'],
                        ['bi-heart-pulse','#ec4899','EKG Kardia L6','Rekam jantung 6-lead portabel untuk deteksi aritmia dan risiko kardiovaskular dalam hitungan menit.'],
                        ['bi-camera','#0d9488','Foto Fundus Vaskuler','Retina adalah satu-satunya bagian tubuh tempat pembuluh darah bisa diamati langsung tanpa operasi.'],
                        ['bi-droplet-half','#7c3aed','Cek Metabolik','Gula darah, kolesterol, dan asam urat adalah tiga indikator utama risiko penyakit tidak menular.'],
                    ] as $tip)
                    <div class="col-sm-6">
                        <div class="edu-tip-card h-100 p-3 rounded-3 bg-white border" style="border-left:4px solid {{ $tip[1] }} !important;">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <i class="bi {{ $tip[0] }} fs-4" style="color:{{ $tip[1] }}"></i>
                                <span class="fw-bold small" style="color:#1a3c5e">{{ $tip[2] }}</span>
                            </div>
                            <p class="text-muted mb-0" style="font-size:.8rem;line-height:1.6;">{{ $tip[3] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
                <p class="text-center text-muted small mt-3 mb-0">
                    <i class="bi bi-info-circle me-1"></i>
                    Materi edukasi berupa gambar dapat ditambahkan di folder <code>public/images/karyawan_vaskuler/</code>
                </p>
                @endif
            </div>
        </div>
    </div>
</section>

{{-- ================================================================
     TENTANG KLINIK
================================================================ --}}
<section class="py-5 bg-white">
    <div class="container py-3">
        <div class="row align-items-center g-5">
            <div class="col-lg-5 text-center">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="img-fluid"
                    style="max-height:200px;filter:drop-shadow(0 8px 24px rgba(26,60,94,.18))">
            </div>
            <div class="col-lg-7">
                <span class="section-badge">Tentang Kami</span>
                <h2 class="section-title">Klinik Utama Cahaya Surya</h2>
                <p class="text-muted mb-3">
                    Jln. Raya Solo – Tawangmangu Kec. Jaten Kab. Karanganyar 57731<br>
                    <strong>Telp:</strong> 0271 495885 &nbsp;|&nbsp; <strong>WhatsApp:</strong> 0851 7538 2660<br>
                    <strong>Instagram:</strong> @klinik.cahayasurya
                </p>
                <p class="text-muted mb-4">
                    Klinik Utama Cahaya Surya bekerjasama dengan Rumah Sakit Mata Solo menyelenggarakan Program Skrining Kesehatan Terpadu untuk Sekolah dan Perusahaan guna mendeteksi faktor risiko penyakit sejak dini.
                </p>
                <div class="row g-3">
                    @foreach([
                        ['bi-shield-check','Terstandarisasi','Berizin resmi Kemenkes RI'],
                        ['bi-people','Tim Profesional','Dokter & tenaga medis berpengalaman'],
                        ['bi-geo-alt','Lokasi Strategis','Jl. Raya Solo – Tawangmangu, Karanganyar'],
                    ] as $f)
                    <div class="col-sm-6">
                        <div class="about-feature">
                            <i class="bi {{ $f[0] }} text-primary"></i>
                            <div><strong>{{ $f[1] }}</strong><p class="mb-0 text-muted small">{{ $f[2] }}</p></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
