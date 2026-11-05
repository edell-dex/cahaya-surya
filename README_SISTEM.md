# Sistem Informasi Pendaftaran Pasien - Klinik Utama Cahaya Surya (Laravel)

Aplikasi pendaftaran rumah sakit / klinik formal berbasis **Laravel 10** dengan fitur skrining kesehatan vaskuler, sistem antrian otomatis, panel CRUD Admin/Staff, serta manajemen hak akses pengguna oleh Super Admin.

---

## 🚀 Fitur Utama

1. **Portal Pemilihan & Dual Formulir Pendaftaran (Publik)**:
   - **Halaman Utama / Portal**: Pendaftar memilih kategori pendaftaran sebelum mengisi form:
     - 🎓 **Program Skrining Sekolah** (`/daftar/sekolah`): Formulir Skrining Kesehatan Mata khusus Siswa/Siswi, Guru, dan Staf Sekolah (Refraksi Lengkap Retinomax, Diskriminasi Warna Farnsworth, Tekanan Bola Mata iCare, Retina Digital AI EyeRobo). Format resmi sesuai Gambar 1.
     - 🏢 **Program Skrining Perusahaan** (`/daftar/perusahaan`): Formulir Skrining Kesehatan Vaskuler khusus Karyawan & Manajemen Perusahaan (Skrining Vaskuler ABI, Jantung Kardia L6, Retina AI, Vaskuler Otak, Metabolik GCU, Kalkulator IMT otomatis). Format resmi sesuai Flyer Gambar 2 & Dokumen PDF.
   - **Nomor Antrian Khusus Berbasis Kategori**:
     - Sekolah: `SEK-YYYYMMDD-001`
     - Perusahaan: `CORP-YYYYMMDD-001`
   - **Halaman Sukses**: Kartu digital antrian lengkap dengan kategori program, identitas, dan tombol cetak bukti.

2. **Tabel CRUD Admin / Staff Rumah Sakit**:
   - Dashboard statistik pasien (hari ini, bulan ini, total pasien, menunggu verifikasi).
   - Tabel data pasien dengan fitur pencarian real-time (nama, NIK, no antrian, telepon), filter status, filter poli, dan filter tanggal.
   - Halaman detail komprehensif riwayat kesehatan & status vital pasien.
   - Form edit data pasien.
   - Verifikasi status pasien (Menunggu, Diverifikasi, Ditolak) beserta catatan admin.
   - Hapus data pasien.

3. **Super Admin (Manajemen Admin)**:
   - Dashboard monitoring total akun admin, admin aktif/nonaktif, dan total pasien.
   - Tambah akun admin / staff baru dengan hashing password bcrypt.
   - Edit data admin, ganti password, dan toggle status aktif/nonaktif.
   - Hapus akun admin (dengan proteksi akun sendiri & proteksi super admin terakhir).

---

## 🔑 Kredensial Default Login

URL Login: `http://localhost/klinik/public/login` (atau `http://127.0.0.1:8000/login`)

| Role | Email | Password |
|---|---|---|
| **Super Admin** | `superadmin@cahayasurya.com` | `password` |
| **Admin / Staff** | `admin@cahayasurya.com` | `password` |

---

## 🛠️ Menjalankan Aplikasi

Jika menggunakan XAMPP (Apache & MySQL):
- Buka browser ke: `http://localhost/klinik/public`

Atau melalui built-in development server Laravel:
```bash
cd c:\xampp\htdocs\klinik
php artisan serve
```
Buka browser ke: `http://127.0.0.1:8000`
