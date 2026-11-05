<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — Klinik Utama Cahaya Surya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
    :root { --primary:#1a3c5e; --primary-light:#2557a7; --primary-dark:#0f2540; --teal:#0d9488; --teal-light:#14b8a6; }
    *   { box-sizing:border-box; }
    body { font-family:'Inter',sans-serif; color:#1e293b; background:#f1f5f9; overflow-x:hidden; }
    ::-webkit-scrollbar{width:5px;} ::-webkit-scrollbar-thumb{background:var(--primary-light);border-radius:3px;}

    /* Wrapper */
    .admin-wrapper { display:flex; min-height:100vh; }

    /* Sidebar */
    .admin-sidebar { width:260px; flex-shrink:0; background:linear-gradient(180deg, var(--primary-dark) 0%, var(--primary) 100%); position:fixed; top:0; left:0; height:100vh; z-index:1000; display:flex; flex-direction:column; transition:transform .3s; overflow-y:auto; }
    .sb-logo { padding:18px 16px; border-bottom:1px solid rgba(255,255,255,.1); display:flex; align-items:center; gap:10px; text-decoration:none; }
    .sb-logo img { height:38px; border-radius:50%; background:rgba(255,255,255,.1); padding:2px; }
    .sb-brand { font-size:.78rem; font-weight:700; color:#fff; line-height:1.3; }
    .sb-sub   { font-size:.65rem; color:rgba(255,255,255,.55); }
    .sb-nav   { flex:1; padding:10px 8px; }
    .sb-label { font-size:.63rem; font-weight:700; color:rgba(255,255,255,.4); text-transform:uppercase; letter-spacing:.1em; padding:12px 10px 4px; }
    .sb-link  { display:flex; align-items:center; gap:10px; padding:9px 12px; border-radius:10px; color:rgba(255,255,255,.72); text-decoration:none; font-size:.86rem; font-weight:500; transition:all .2s; margin-bottom:2px; }
    .sb-link:hover  { background:rgba(255,255,255,.1); color:#fff; }
    .sb-link.active { background:var(--teal); color:#fff; }
    .sb-link i { font-size:1.05rem; width:20px; flex-shrink:0; }
    .sb-user  { padding:14px 16px; border-top:1px solid rgba(255,255,255,.1); display:flex; align-items:center; gap:10px; }
    .sb-avatar { width:34px; height:34px; border-radius:50%; background:var(--teal); display:flex; align-items:center; justify-content:center; font-weight:700; color:#fff; font-size:.85rem; flex-shrink:0; }
    .sb-uname { font-size:.8rem; font-weight:600; color:#fff; }
    .sb-urole { font-size:.67rem; color:rgba(255,255,255,.5); }
    .sb-overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,.5); z-index:999; }

    /* Main content */
    .admin-main    { margin-left:260px; flex:1; display:flex; flex-direction:column; transition:margin .3s; }
    .admin-header  { background:#fff; border-bottom:1px solid #e2e8f0; padding:0 22px; height:58px; display:flex; align-items:center; justify-content:space-between; position:sticky; top:0; z-index:100; box-shadow:0 1px 6px rgba(0,0,0,.07); }
    .admin-content { padding:22px; flex:1; }
    .sb-toggle     { background:none; border:none; font-size:1.2rem; color:var(--primary); display:none; padding:4px 8px; }
    .page-title    { font-size:1.25rem; font-weight:700; color:var(--primary); margin:0; }

    /* Stat cards */
    .stat-card { background:#fff; border-radius:14px; padding:18px; border:1px solid #e2e8f0; display:flex; align-items:center; gap:14px; box-shadow:0 1px 6px rgba(0,0,0,.06); transition:all .2s; }
    .stat-card:hover { transform:translateY(-2px); box-shadow:0 4px 16px rgba(26,60,94,.1); }
    .stat-icon { width:50px; height:50px; border-radius:13px; display:flex; align-items:center; justify-content:center; font-size:1.35rem; flex-shrink:0; }
    .si-blue   { background:rgba(26,60,94,.1);   color:var(--primary); }
    .si-teal   { background:rgba(13,148,136,.1);  color:var(--teal); }
    .si-green  { background:rgba(22,163,74,.1);   color:#16a34a; }
    .si-yellow { background:rgba(245,158,11,.1);  color:#d97706; }
    .si-red    { background:rgba(220,38,38,.1);   color:#dc2626; }
    .stat-num  { font-size:1.75rem; font-weight:700; color:var(--primary); line-height:1; }
    .stat-lbl  { font-size:.75rem; color:#64748b; font-weight:500; }

    /* Table */
    .tbl-card  { background:#fff; border-radius:14px; border:1px solid #e2e8f0; overflow:hidden; box-shadow:0 1px 6px rgba(0,0,0,.06); }
    .tbl-head  { padding:14px 18px; border-bottom:1px solid #e2e8f0; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; }
    .tbl-title { font-size:.98rem; font-weight:700; color:var(--primary); }
    .table thead th { background:#f8fafc; color:#64748b; font-size:.73rem; font-weight:700; text-transform:uppercase; letter-spacing:.05em; border-bottom:1px solid #e2e8f0 !important; padding:9px 12px; white-space:nowrap; }
    .table tbody tr:hover { background:rgba(26,60,94,.02); }
    .table td  { vertical-align:middle; font-size:.86rem; padding:9px 12px; border-bottom:1px solid #f1f5f9; }

    /* Badges */
    .badge-menunggu   { background:rgba(217,119,6,.12); color:#d97706; font-weight:600; border:1px solid rgba(217,119,6,.25); padding:3px 9px; border-radius:6px; font-size:.73rem; }
    .badge-diverifikasi { background:rgba(22,163,74,.1); color:#16a34a; font-weight:600; border:1px solid rgba(22,163,74,.22); padding:3px 9px; border-radius:6px; font-size:.73rem; }
    .badge-ditolak    { background:rgba(220,38,38,.08); color:#dc2626; font-weight:600; border:1px solid rgba(220,38,38,.18); padding:3px 9px; border-radius:6px; font-size:.73rem; }
    .badge-aktif      { background:rgba(22,163,74,.1); color:#16a34a; font-weight:600; border:1px solid rgba(22,163,74,.22); padding:3px 9px; border-radius:6px; font-size:.73rem; }
    .badge-nonaktif   { background:rgba(220,38,38,.08); color:#dc2626; font-weight:600; border:1px solid rgba(220,38,38,.18); padding:3px 9px; border-radius:6px; font-size:.73rem; }

    /* Detail sections */
    .detail-sec { background:#fff; border-radius:14px; border:1px solid #e2e8f0; overflow:hidden; margin-bottom:18px; box-shadow:0 1px 6px rgba(0,0,0,.06); }
    .detail-hdr { padding:11px 18px; font-weight:700; font-size:.88rem; display:flex; align-items:center; gap:8px; }
    .detail-hdr.blue   { background:linear-gradient(135deg,var(--primary),var(--primary-light)); color:#fff; }
    .detail-hdr.teal   { background:linear-gradient(135deg,var(--teal),var(--teal-light)); color:#fff; }
    .detail-hdr.purple { background:linear-gradient(135deg,#7c3aed,#a855f7); color:#fff; }
    .detail-hdr.green  { background:linear-gradient(135deg,#16a34a,#22c55e); color:#fff; }
    .detail-body { padding:18px; }
    .d-lbl { font-size:.73rem; color:#64748b; text-transform:uppercase; letter-spacing:.05em; font-weight:700; margin-bottom:2px; }
    .d-val { font-size:.9rem; font-weight:500; color:#1e293b; }

    /* Form */
    .card-hdr-blue  { background:linear-gradient(135deg,var(--primary),var(--primary-light)); color:#fff; padding:12px 18px; font-weight:600; border-radius:12px 12px 0 0 !important; display:flex; align-items:center; }
    .card-hdr-teal  { background:linear-gradient(135deg,var(--teal),var(--teal-light)); color:#fff; padding:12px 18px; font-weight:600; border-radius:12px 12px 0 0 !important; display:flex; align-items:center; }
    label.required::after { content:' *'; color:#dc2626; }
    .form-control:focus,.form-select:focus { border-color:var(--primary-light); box-shadow:0 0 0 3px rgba(37,87,167,.1); }

    /* Breadcrumb */
    .admin-bc { font-size:.8rem; color:#64748b; display:flex; align-items:center; gap:5px; }
    .admin-bc a { color:var(--primary-light); text-decoration:none; }

    /* Login page */
    .login-body { background:linear-gradient(135deg, var(--primary-dark), var(--primary) 55%, #1e5096); }
    .login-card { display:flex; background:#fff; border-radius:20px; overflow:hidden; box-shadow:0 25px 60px rgba(0,0,0,.3); max-width:880px; width:100%; }
    .login-brand { width:360px; flex-shrink:0; background:linear-gradient(160deg,var(--primary-dark),var(--primary) 60%,var(--teal)); }
    .login-logo  { max-width:110px; border-radius:50%; background:rgba(255,255,255,.1); padding:10px; }
    .login-form  { flex:1; padding:40px 36px; }

    @media(max-width:768px) {
        .admin-sidebar { transform:translateX(-100%); }
        .admin-sidebar.open { transform:translateX(0); }
        .admin-main    { margin-left:0; }
        .sb-toggle     { display:block; }
        .sb-overlay.show { display:block; }
        .login-brand   { display:none; }
    }

    @media print { .admin-sidebar,.admin-header,.no-print{display:none!important} .admin-main{margin-left:0!important} .admin-content{padding:0!important} }
    </style>
    @stack('styles')
</head>
<body>
<div class="admin-wrapper">
    {{-- Sidebar --}}
    <nav class="admin-sidebar" id="adminSidebar">
        <a href="{{ route('pendaftaran.index') }}" class="sb-logo">
            <img src="{{ asset('images/logo.png') }}" alt="Logo">
            <div>
                <div class="sb-brand">Klinik Utama Cahaya Surya</div>
                <div class="sb-sub">Panel Manajemen</div>
            </div>
        </a>

        <div class="sb-nav">
            <div class="sb-label">Menu</div>

            @if(auth()->user()->role === 'superadmin')
            <a href="{{ route('superadmin.index') }}" class="sb-link {{ request()->routeIs('superadmin.index') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="{{ route('superadmin.index') }}" class="sb-link {{ request()->routeIs('superadmin.*') && !request()->routeIs('superadmin.index') ? 'active' : '' }}">
                <i class="bi bi-people-fill"></i> Kelola Admin
            </a>
            @endif

            <a href="{{ route('admin.pasien.index') }}" class="sb-link {{ request()->routeIs('admin.pasien.*') ? 'active' : '' }}">
                <i class="bi bi-clipboard2-pulse-fill"></i> Data Pasien
            </a>

            <a href="{{ route('admin.skrining.index') }}" class="sb-link {{ request()->routeIs('admin.skrining.*') ? 'active' : '' }}">
                <i class="bi bi-file-medical-fill"></i> Hasil Skrining
            </a>

            <div class="sb-label mt-2">Lainnya</div>
            <a href="{{ route('pendaftaran.index') }}" class="sb-link" target="_blank">
                <i class="bi bi-house-fill"></i> Halaman Publik
            </a>
        </div>

        <div class="sb-user">
            <div class="sb-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            <div>
                <div class="sb-uname">{{ auth()->user()->name }}</div>
                <div class="sb-urole">
                    @if(auth()->user()->role === 'superadmin')
                    <span style="color:#14b8a6;font-weight:600;">SUPER ADMIN</span>
                    @else
                    Admin
                    @endif
                </div>
            </div>
        </div>
    </nav>

    {{-- Overlay --}}
    <div class="sb-overlay" id="sbOverlay"></div>

    {{-- Main Content --}}
    <div class="admin-main">
        <header class="admin-header">
            <div class="d-flex align-items-center gap-3">
                <button class="sb-toggle" id="sbToggle"><i class="bi bi-list"></i></button>
                <div>
                    <h1 class="page-title">@yield('page-title', 'Dashboard')</h1>
                    <div class="admin-bc d-none d-md-flex">
                        <a href="#">Beranda</a>
                        <i class="bi bi-chevron-right" style="font-size:.7rem"></i>
                        @yield('breadcrumb')
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="d-none d-sm-block text-muted small">{{ auth()->user()->email }}</span>
                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-box-arrow-right me-1"></i>Logout
                    </button>
                </form>
            </div>
        </header>

        <div class="admin-content">
            {{-- Flash Messages --}}
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 d-flex align-items-center gap-2" role="alert">
                <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif
            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 d-flex align-items-center gap-2" role="alert">
                <i class="bi bi-exclamation-circle-fill"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @yield('content')
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Sidebar toggle
const sbToggle  = document.getElementById('sbToggle');
const sidebar   = document.getElementById('adminSidebar');
const sbOverlay = document.getElementById('sbOverlay');
if (sbToggle) {
    sbToggle.addEventListener('click', () => {
        sidebar.classList.toggle('open');
        sbOverlay.classList.toggle('show');
    });
    sbOverlay.addEventListener('click', () => {
        sidebar.classList.remove('open');
        sbOverlay.classList.remove('show');
    });
}
</script>
@stack('scripts')
</body>
</html>
