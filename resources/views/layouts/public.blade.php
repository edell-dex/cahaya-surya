<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Klinik Utama Cahaya Surya')</title>

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
    :root {
        --primary: #1a3c5e;
        --primary-light: #2557a7;
        --primary-dark: #0f2540;
        --teal: #0d9488;
        --teal-light: #14b8a6;
        --bg-light: #f0f4f8;
    }
    * { box-sizing: border-box; }
    body { font-family: 'Inter', sans-serif; color: #1e293b; }
    ::-webkit-scrollbar { width: 6px; }
    ::-webkit-scrollbar-thumb { background: var(--primary-light); border-radius: 3px; }

    /* Navbar */
    #mainNavbar { background: linear-gradient(135deg, var(--primary-dark), var(--primary)); box-shadow: 0 2px 12px rgba(0,0,0,.2); }
    .brand-name { font-size: .95rem; font-weight: 700; line-height: 1.2; }
    .brand-sub  { font-size: .7rem; opacity: .7; }
    .logo-img   { border-radius: 50%; background: white; padding: 2px; }
    .navbar-nav .nav-link { font-weight: 500; transition: color .2s; }
    .navbar-nav .nav-link:hover { color: var(--teal-light) !important; }

    /* Hero */
    .hero-section { background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 55%, #1e5096 100%); position: relative; padding-bottom: 80px; overflow: hidden; }
    .hero-section::before { content:''; position:absolute; top:-40%; right:-5%; width:550px; height:550px; background:radial-gradient(circle, rgba(13,148,136,.18) 0%, transparent 70%); border-radius:50%; }
    .hero-wave { position:absolute; bottom:0; left:0; right:0; height:80px; }
    .hero-wave svg { width:100%; height:100%; }
    .stat-box { background:rgba(255,255,255,.12); border:1px solid rgba(255,255,255,.2); border-radius:12px; padding:14px 10px; text-align:center; backdrop-filter:blur(8px); }
    .stat-num { font-size:1.4rem; font-weight:700; color:var(--teal-light); }
    .stat-lbl { font-size:.7rem; color:rgba(255,255,255,.7); text-transform:uppercase; letter-spacing:.04em; }
    @keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-14px)} }
    .hero-icon { font-size:160px; color:rgba(255,255,255,.07); animation:float 3.5s ease-in-out infinite; }

    /* Buttons */
    .btn-teal { background:var(--teal); border-color:var(--teal); color:#fff; font-weight:600; transition:all .2s; }
    .btn-teal:hover { background:var(--teal-light); border-color:var(--teal-light); color:#fff; transform:translateY(-1px); }
    .btn-primary { background:var(--primary); border-color:var(--primary); }
    .btn-primary:hover { background:var(--primary-light); border-color:var(--primary-light); }

    /* Sections */
    .section-badge { display:inline-block; background:rgba(26,60,94,.1); color:var(--primary); font-size:.78rem; font-weight:700; padding:4px 14px; border-radius:20px; text-transform:uppercase; letter-spacing:.05em; margin-bottom:10px; }
    .section-title { font-size:1.75rem; font-weight:700; color:var(--primary); margin-bottom:.4rem; }
    .section-desc  { color:#64748b; max-width:540px; margin:0 auto; }

    /* Service Cards */
    .service-card { background:#fff; border:1px solid #e2e8f0; border-radius:16px; padding:22px 18px; text-align:center; transition:all .25s; height:100%; }
    .service-card:hover { transform:translateY(-4px); box-shadow:0 8px 24px rgba(26,60,94,.12); border-color:var(--primary-light); }
    .svc-icon { width:54px; height:54px; background:linear-gradient(135deg, var(--primary), var(--primary-light)); border-radius:14px; display:flex; align-items:center; justify-content:center; margin:0 auto 14px; font-size:1.4rem; color:#fff; }
    .service-card h5 { font-size:.92rem; font-weight:700; color:var(--primary); margin-bottom:6px; }
    .service-card p  { font-size:.8rem; color:#64748b; margin:0; }

    /* Step indicator */
    .step-indicator { display:flex; align-items:center; justify-content:center; gap:0; overflow-x:auto; padding:6px 0; }
    .step { display:flex; flex-direction:column; align-items:center; min-width:80px; }
    .step-circle { width:40px; height:40px; border-radius:50%; background:#e2e8f0; color:#94a3b8; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:.95rem; transition:all .3s; }
    .step.active .step-circle { background:var(--primary); color:#fff; }
    .step.done .step-circle   { background:#16a34a; color:#fff; }
    .step-label { font-size:.73rem; color:#94a3b8; margin-top:4px; white-space:nowrap; }
    .step.active .step-label  { color:var(--primary); font-weight:600; }
    .step.done .step-label    { color:#16a34a; }
    .step-line { flex:1; height:2px; background:#e2e8f0; min-width:40px; max-width:80px; margin-bottom:22px; transition:background .3s; }
    .step-line.done { background:var(--primary); }

    /* Form card headers */
    .card-hdr-blue  { background:linear-gradient(135deg, var(--primary), var(--primary-light)); color:#fff; padding:13px 20px; font-weight:600; border-radius:12px 12px 0 0 !important; display:flex; align-items:center; }
    .card-hdr-teal  { background:linear-gradient(135deg, var(--teal), var(--teal-light)); color:#fff; padding:13px 20px; font-weight:600; border-radius:12px 12px 0 0 !important; display:flex; align-items:center; }
    .card-hdr-purple{ background:linear-gradient(135deg, #7c3aed, #a855f7); color:#fff; padding:13px 20px; font-weight:600; border-radius:12px 12px 0 0 !important; display:flex; align-items:center; }
    .subsec-title { color:var(--primary); font-weight:700; font-size:.82rem; text-transform:uppercase; letter-spacing:.05em; padding-bottom:8px; border-bottom:2px solid #e2e8f0; margin-bottom:0; }
    label.required::after { content:' *'; color:#dc2626; }
    .form-control:focus, .form-select:focus { border-color:var(--primary-light); box-shadow:0 0 0 3px rgba(37,87,167,.1); }

    /* About */
    .about-feature { display:flex; align-items:flex-start; gap:12px; padding:12px; border-radius:10px; background:#f8fafc; border:1px solid #e2e8f0; }
    .about-feature i { font-size:1.4rem; flex-shrink:0; margin-top:2px; }

    /* Footer */
    .site-footer { background:linear-gradient(135deg, var(--primary-dark), var(--primary)); }
    .hover-white:hover { color:#fff !important; }

    /* Success Page */
    .queue-card { background:linear-gradient(135deg, var(--primary), var(--primary-light)); border-radius:16px; padding:24px; color:#fff; }
    .queue-lbl  { font-size:.7rem; letter-spacing:.15em; text-transform:uppercase; opacity:.8; margin-bottom:8px; }
    .queue-num  { font-size:2.4rem; font-weight:800; letter-spacing:.05em; font-family:'Courier New',monospace; }
    .queue-date { font-size:.83rem; opacity:.75; margin-top:8px; }
    .checkmark  { width:80px; height:80px; border-radius:50%; display:block; stroke-width:3; stroke:#4caf50; stroke-miterlimit:10; margin:0 auto; animation:fill .4s ease-in-out .4s forwards,scale .3s ease-in-out .9s both; }
    .checkmark__circle { stroke-dasharray:166; stroke-dashoffset:166; stroke-width:3; stroke:#4caf50; fill:none; animation:stroke .6s cubic-bezier(.65,0,.45,1) forwards; }
    .checkmark__check  { transform-origin:50% 50%; stroke-dasharray:48; stroke-dashoffset:48; animation:stroke .3s cubic-bezier(.65,0,.45,1) .8s forwards; }
    @keyframes stroke { 100%{stroke-dashoffset:0} }
    @keyframes scale  { 0%,100%{transform:none} 50%{transform:scale3d(1.1,1.1,1)} }
    @keyframes fill   { 100%{box-shadow:inset 0 0 0 30px rgba(76,175,80,.08)} }
    @media print { nav,.no-print{display:none!important} .site-footer{display:none!important} }
    </style>

    @stack('styles')
</head>
<body>
{{-- Navbar --}}
<nav class="navbar navbar-expand-lg navbar-dark sticky-top" id="mainNavbar">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('pendaftaran.index') }}">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" height="44" class="logo-img">
            <div>
                <div class="brand-name">Klinik Utama Cahaya Surya</div>
                <div class="brand-sub">Bekerja Sama dengan RS Mata Solo</div>
            </div>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav" aria-controls="nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav ms-auto align-items-center gap-lg-1">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('pendaftaran.index') ? 'active' : '' }}" href="{{ route('pendaftaran.index') }}">
                        <i class="bi bi-house-door me-1"></i>Beranda
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('pendaftaran.index') }}#layanan">
                        <i class="bi bi-heart-pulse me-1"></i>Layanan
                    </a>
                </li>

                {{-- Menu Dropdown Daftar Terintegrasi --}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('pendaftaran.sekolah', 'pendaftaran.perusahaan') ? 'active text-teal-light' : '' }}" href="#" id="navbarDaftarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-clipboard2-plus me-1"></i>Pendaftaran
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 py-2" aria-labelledby="navbarDaftarDropdown">
                        <li>
                            <a class="dropdown-item py-2 d-flex align-items-center gap-2 {{ request()->routeIs('pendaftaran.sekolah') ? 'active' : '' }}" href="{{ route('pendaftaran.sekolah') }}">
                                <i class="bi bi-mortarboard-fill text-primary fs-5"></i>
                                <div>
                                    <div class="fw-semibold">Skrining Sekolah</div>
                                    <div class="text-muted" style="font-size:0.75rem">Siswa, Guru & Staf Sekolah</div>
                                </div>
                            </a>
                        </li>
                        <li><hr class="dropdown-divider my-1"></li>
                        <li>
                            <a class="dropdown-item py-2 d-flex align-items-center gap-2 {{ request()->routeIs('pendaftaran.perusahaan') ? 'active' : '' }}" href="{{ route('pendaftaran.perusahaan') }}">
                                <i class="bi bi-building-fill text-success fs-5"></i>
                                <div>
                                    <div class="fw-semibold">Skrining Perusahaan</div>
                                    <div class="text-muted" style="font-size:0.75rem">Karyawan & Manajemen Perusahaan</div>
                                </div>
                            </a>
                        </li>
                        <li><hr class="dropdown-divider my-1"></li>
                        <li>
                            <a class="dropdown-item py-2 d-flex align-items-center gap-2" href="{{ route('pendaftaran.index') }}#pilih-pendaftaran">
                                <i class="bi bi-grid-3x3-gap-fill text-secondary fs-6"></i>
                                <span class="small text-muted">Lihat Semua Kategori Program</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('pendaftaran.index') }}#edukasi-mata">
                        <i class="bi bi-journal-medical me-1"></i>Edukasi
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('pendaftaran.index') }}#tentang">
                        <i class="bi bi-info-circle me-1"></i>Kontak & Lokasi
                    </a>
                </li>
                <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                    <a class="btn btn-outline-light btn-sm px-3 rounded-pill" href="{{ route('login') }}">
                        <i class="bi bi-person-lock me-1"></i>Login Staff
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

@yield('content')

{{-- Footer Terintegrasi --}}
<footer class="site-footer py-5" id="tentang">
    <div class="container">
        <div class="row g-4">
            {{-- Kolom 1: Profil Klinik --}}
            <div class="col-lg-4 col-md-6">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" height="42" class="bg-white rounded-circle p-1">
                    <div>
                        <div class="fw-bold text-white">Klinik Utama Cahaya Surya</div>
                        <small class="text-white-50">Bekerja Sama dengan RS Mata Solo</small>
                    </div>
                </div>
                <p class="text-white-50 small mb-3" style="line-height:1.7;">
                    Penyelenggara layanan skrining kesehatan formal terpadu berbasis teknologi medis mutakhir & AI untuk instansi pendidikan dan perusahaan.
                </p>
                <div class="d-flex gap-2 text-white-50 small">
                    <span class="badge bg-white bg-opacity-10 text-white border border-white border-opacity-10 py-2 px-3">
                        <i class="bi bi-patch-check-fill text-info me-1"></i>Layanan Medis Resmi
                    </span>
                    <span class="badge bg-white bg-opacity-10 text-white border border-white border-opacity-10 py-2 px-3">
                        <i class="bi bi-cpu-fill text-warning me-1"></i>Teknologi AI On-Site
                    </span>
                </div>
            </div>

            {{-- Kolom 2: Kontak & Lokasi --}}
            <div class="col-lg-4 col-md-6">
                <h6 class="text-white fw-bold mb-3 d-flex align-items-center gap-2">
                    <i class="bi bi-geo-alt-fill text-danger"></i>Kontak & Lokasi
                </h6>
                <ul class="list-unstyled text-white-50 small" style="line-height:1.8;">
                    <li class="mb-2 d-flex align-items-start gap-2">
                        <i class="bi bi-pin-map text-white mt-1"></i>
                        <span>Jl. Raya Solo – Tawangmangu (KM 10,6), Jati, Jaten, Kab. Karanganyar 57731</span>
                    </li>
                    <li class="mb-2 d-flex align-items-center gap-2">
                        <i class="bi bi-telephone-fill text-white"></i>
                        <a href="tel:0271495885" class="text-white-50 text-decoration-none hover-white">(0271) 495885</a>
                    </li>
                    <li class="mb-2 d-flex align-items-center gap-2">
                        <i class="bi bi-whatsapp text-success"></i>
                        <a href="https://wa.me/6285175382660" target="_blank" class="text-white-50 text-decoration-none hover-white">0851 7538 2660 (WhatsApp Layanan)</a>
                    </li>
                    <li class="d-flex align-items-center gap-2">
                        <i class="bi bi-clock-history text-white"></i>
                        <span>Senin – Sabtu: 08.00 – 20.00 WIB</span>
                    </li>
                </ul>
            </div>

            {{-- Kolom 3: Akses Cepat Terintegrasi --}}
            <div class="col-lg-4 col-md-12">
                <h6 class="text-white fw-bold mb-3 d-flex align-items-center gap-2">
                    <i class="bi bi-link-45deg text-info"></i>Akses Cepat
                </h6>
                <ul class="list-unstyled mb-0" style="line-height:2;">
                    <li>
                        <a href="{{ route('pendaftaran.index') }}" class="text-white-50 small text-decoration-none hover-white d-inline-flex align-items-center gap-2">
                            <i class="bi bi-chevron-right text-info" style="font-size:0.75rem"></i>Beranda Portal Utama
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('pendaftaran.sekolah') }}" class="text-white-50 small text-decoration-none hover-white d-inline-flex align-items-center gap-2">
                            <i class="bi bi-chevron-right text-info" style="font-size:0.75rem"></i>Formulir Skrining Sekolah (Mata)
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('pendaftaran.perusahaan') }}" class="text-white-50 small text-decoration-none hover-white d-inline-flex align-items-center gap-2">
                            <i class="bi bi-chevron-right text-info" style="font-size:0.75rem"></i>Formulir Skrining Perusahaan (Vaskuler)
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('pendaftaran.index') }}#layanan" class="text-white-50 small text-decoration-none hover-white d-inline-flex align-items-center gap-2">
                            <i class="bi bi-chevron-right text-info" style="font-size:0.75rem"></i>Informasi Layanan & Teknologi AI
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('login') }}" class="text-white-50 small text-decoration-none hover-white d-inline-flex align-items-center gap-2">
                            <i class="bi bi-lock-fill text-warning" style="font-size:0.75rem"></i>Portal Login Petugas / Admin
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <hr class="border-secondary my-4">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2 text-white-50 small">
            <div>&copy; {{ date('Y') }} Klinik Utama Cahaya Surya & Rumah Sakit Mata Solo. Hak Cipta Dilindungi.</div>
            <div class="d-flex gap-3">
                <a href="{{ route('pendaftaran.index') }}#tentang" class="text-white-50 text-decoration-none hover-white">Tentang Kami</a>
                <span>•</span>
                <a href="{{ route('login') }}" class="text-white-50 text-decoration-none hover-white">Admin SIMRS</a>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
