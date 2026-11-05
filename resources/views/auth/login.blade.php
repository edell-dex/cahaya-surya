<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Staff — Klinik Utama Cahaya Surya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
    :root { --primary:#1a3c5e; --primary-dark:#0f2540; --teal:#0d9488; }
    body { font-family:'Inter',sans-serif; background:linear-gradient(135deg,var(--primary-dark),var(--primary) 55%,#1e5096); min-height:100vh; display:flex; align-items:center; justify-content:center; padding:20px; }
    .login-card { display:flex; background:#fff; border-radius:20px; overflow:hidden; box-shadow:0 25px 60px rgba(0,0,0,.3); width:100%; max-width:860px; }
    .login-brand { width:340px; flex-shrink:0; background:linear-gradient(160deg,var(--primary-dark),var(--primary) 60%,var(--teal)); display:flex; flex-direction:column; align-items:center; justify-content:center; padding:40px 30px; text-align:center; }
    .login-logo  { max-width:100px; border-radius:50%; background:rgba(255,255,255,.1); padding:8px; margin-bottom:20px; }
    .login-form  { flex:1; padding:40px 36px; }
    .form-control:focus { border-color:#2557a7; box-shadow:0 0 0 3px rgba(37,87,167,.1); }
    .btn-primary { background:var(--primary); border-color:var(--primary); }
    .btn-primary:hover { background:#2557a7; border-color:#2557a7; }
    @media(max-width:640px) { .login-brand{display:none;} .login-form{padding:30px 24px;} }
    </style>
</head>
<body>
<div class="login-card">
    {{-- Brand Side --}}
    <div class="login-brand">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="login-logo">
        <h4 class="fw-bold text-white mb-2">Klinik Utama<br>Cahaya Surya</h4>
        <p class="text-white-50 small">Sistem Informasi Manajemen<br>Rumah Sakit & Klinik</p>
        <div class="mt-4 text-white-50" style="font-size:.78rem;">
            <div class="mb-1"><i class="bi bi-shield-lock me-1"></i>Sistem Terproteksi</div>
            <div><i class="bi bi-lock me-1"></i>Akses Terbatas</div>
        </div>
    </div>

    {{-- Form Side --}}
    <div class="login-form">
        <h4 class="fw-bold mb-1">Login Staff</h4>
        <p class="text-muted mb-4 small">Masukkan kredensial Anda untuk mengakses sistem</p>

        {{-- Errors & Flash --}}
        @if($errors->any())
        <div class="alert alert-danger border-0 d-flex align-items-center gap-2 py-2">
            <i class="bi bi-exclamation-circle-fill"></i>
            {{ $errors->first() }}
        </div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger border-0 py-2">{{ session('error') }}</div>
        @endif
        @if(session('success'))
        <div class="alert alert-success border-0 py-2">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('login.post') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-medium">Email</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="email@contoh.com" required autofocus>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label fw-medium">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" class="form-control" name="password" id="pwInput" placeholder="Masukkan password" required>
                    <button class="btn btn-outline-secondary" type="button" onclick="togglePw()"><i class="bi bi-eye" id="pwEye"></i></button>
                </div>
            </div>
            <div class="mb-4 d-flex align-items-center justify-content-between">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label small" for="remember">Ingat saya</label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-100 btn-lg fw-semibold">
                <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
            </button>
        </form>

        <div class="mt-4 text-center">
            <a href="{{ route('pendaftaran.index') }}" class="text-muted small text-decoration-none">
                <i class="bi bi-arrow-left me-1"></i>Kembali ke Beranda
            </a>
        </div>

        <div class="mt-4 pt-3 border-top text-center">
            <small class="text-muted"><i class="bi bi-info-circle me-1"></i>Hanya staff dan admin berwenang yang dapat mengakses sistem ini.</small>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
function togglePw() {
    const pw = document.getElementById('pwInput');
    const eye = document.getElementById('pwEye');
    if (pw.type === 'password') { pw.type = 'text'; eye.className = 'bi bi-eye-slash'; }
    else { pw.type = 'password'; eye.className = 'bi bi-eye'; }
}
</script>
</body>
</html>
