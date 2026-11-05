<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\AdminPasienController;
use App\Http\Controllers\HasilSkriningController;
use App\Http\Controllers\SuperAdminController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Halaman utama (Pilihan jenis pendaftaran & layanan)
Route::get('/', [PasienController::class, 'index'])->name('pendaftaran.index');

// Pendaftaran Sekolah
Route::get('/daftar/sekolah', [PasienController::class, 'createSekolah'])->name('pendaftaran.sekolah');
Route::post('/daftar/sekolah', [PasienController::class, 'storeSekolah'])->name('pendaftaran.storeSekolah');

// Pendaftaran Perusahaan
Route::get('/daftar/perusahaan', [PasienController::class, 'createPerusahaan'])->name('pendaftaran.perusahaan');
Route::post('/daftar/perusahaan', [PasienController::class, 'storePerusahaan'])->name('pendaftaran.storePerusahaan');

// Halaman Sukses
Route::get('/sukses/{pasien}', [PasienController::class, 'sukses'])->name('pendaftaran.sukses');

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Redirect /home & /dashboard
Route::get('/home', fn() => Auth::check() ? (Auth::user()->role === 'superadmin' ? redirect()->route('superadmin.index') : redirect()->route('admin.pasien.index')) : redirect()->route('login'))->name('home');
Route::get('/dashboard', fn() => Auth::check() ? (Auth::user()->role === 'superadmin' ? redirect()->route('superadmin.index') : redirect()->route('admin.pasien.index')) : redirect()->route('login'))->name('dashboard');

/*
|--------------------------------------------------------------------------
| Admin Routes (admin + superadmin)
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin,superadmin'])->group(function () {
    Route::get('/', fn() => redirect()->route('admin.pasien.index'))->name('index');
    Route::get('pasien/export', [AdminPasienController::class, 'export'])->name('pasien.export');
    Route::resource('pasien', AdminPasienController::class)->except(['create', 'store']);
    Route::post('pasien/{pasien}/status', [AdminPasienController::class, 'updateStatus'])->name('pasien.updateStatus');

    // Hasil Skrining
    Route::get('skrining/cari-pasien', [HasilSkriningController::class, 'cariPasien'])->name('skrining.cariPasien');
    Route::get('skrining/{skrining}/pdf', [HasilSkriningController::class, 'downloadPdf'])->name('skrining.pdf');
    Route::resource('skrining', HasilSkriningController::class)->only(['index', 'create', 'store', 'show']);
});

/*
|--------------------------------------------------------------------------
| Super Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('superadmin')->name('superadmin.')->middleware(['auth', 'role:superadmin'])->group(function () {
    Route::get('/', [SuperAdminController::class, 'index'])->name('index');
    Route::get('/tambah', [SuperAdminController::class, 'create'])->name('create');
    Route::post('/tambah', [SuperAdminController::class, 'store'])->name('store');
    Route::get('/{user}/edit', [SuperAdminController::class, 'edit'])->name('edit');
    Route::put('/{user}', [SuperAdminController::class, 'update'])->name('update');
    Route::delete('/{user}', [SuperAdminController::class, 'destroy'])->name('destroy');
    Route::post('/{user}/toggle-status', [SuperAdminController::class, 'toggleStatus'])->name('toggleStatus');
});
