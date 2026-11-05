# BUKU PANDUAN PENGOPERASIAN SISTEM INFORMASI
## (MANUAL BOOK OPERASIONAL ADMIN & SUPER ADMIN)
### KLINIK UTAMA CAHAYA SURYA
**Bekerja Sama dengan Rumah Sakit Mata Solo**

---

| Informasi Dokumen | Keterangan |
| :--- | :--- |
| **Nama Sistem** | Sistem Informasi Pendaftaran & Manajemen Pasien Skrining |
| **Instansi** | Klinik Utama Cahaya Surya |
| **Versi Dokumen** | 1.0 (Produksi) |
| **Klasifikasi** | Internal / Rahasia (Confidential) |
| **Tanggal Pembaruan** | 13 Oktober 2026 |

---

## DAFTAR ISI
1. [Kredensial Akses Resmi](#1-kredensial-akses-resmi)
2. [Hak Akses & Matriks Peran Pengguna](#2-hak-akses--matriks-peran-pengguna)
3. [Panduan Masuk Sistem (Login)](#3-panduan-masuk-sistem-login)
4. [Panduan Operasional Administrator (Staff Pendaftaran)](#4-panduan-operasional-administrator-staff-pendaftaran)
   - [4.1 Navigasi & Memahami Dashboard Pasien](#41-navigasi--memahami-dashboard-pasien)
   - [4.2 Pencarian & Filter Cepat Data Pasien](#42-pencarian--filter-cepat-data-pasien)
   - [4.3 Verifikasi Status & Catatan Medis Pasien](#43-verifikasi-status--catatan-medis-pasien)
   - [4.4 Melihat Detail & Rekam Pendaftaran](#44-melihat-detail--rekam-pendaftaran)
   - [4.5 Mengedit Data Pasien](#45-mengedit-data-pasien)
   - [4.6 Mencetak Resume Data Pasien](#46-mencetak-resume-data-pasien)
   - [4.7 Mengunduh Data ke Format Microsoft Excel (.xlsx) / CSV](#47-mengunduh-data-ke-format-microsoft-excel-xlsx--csv)
   - [4.8 Menghapus Data Pasien](#48-menghapus-data-pasien)
5. [Panduan Operasional Super Administrator](#5-panduan-operasional-super-administrator)
   - [5.1 Dashboard Utama Super Admin](#51-dashboard-utama-super-admin)
   - [5.2 Menambahkan Petugas / Admin Baru](#52-menambahkan-petugas--admin-baru)
   - [5.3 Mengubah Data & Reset Password Petugas](#53-mengubah-data--reset-password-petugas)
   - [5.4 Menonaktifkan / Mengaktifkan Akun Petugas](#54-menonaktifkan--mengaktifkan-akun-petugas)
   - [5.5 Menghapus Akun Petugas](#55-menghapus-akun-petugas)
6. [Alur Referensi Pendaftaran Pasien (Sisi Publik)](#6-alur-referensi-pendaftaran-pasien-sisi-publik)
7. [Panduan Penanganan Kendala (Troubleshooting & FAQ)](#7-panduan-penanganan-kendala-troubleshooting--faq)

---

## 1. Kredensial Akses Resmi

Gunakan kredensial resmi di bawah ini untuk mengakses portal manajemen:

### A. Akun Super Administrator
```text
id:superadmin@cahayasurya.com
password:super@dmincahaya_
```
*Peran: Memiliki kewenangan tertinggi untuk mengelola akun petugas/admin, konfigurasi sistem, dan pemantauan menyeluruh.*

### B. Akun Administrator / Staff Pendaftaran
```text
id:admin@cahayasurya.com
password:@dmincahaya_
```
*Peran: Bertanggung jawab atas verifikasi data pendaftar harian, pembaruan status pasien, pencetakan berkas, serta ekspor rekapitulasi data pasien ke Excel.*

> [!CAUTION]
> Jagalah kerahasiaan kata sandi di atas. Jangan membagikan kata sandi kepada pihak yang tidak berkepentingan. Segera lakukan pembaruan kata sandi secara berkala melalui menu yang tersedia.

---

## 2. Hak Akses & Matriks Peran Pengguna

Sistem membagi kewenangan ke dalam dua tingkatan pengguna internal:

| Modul / Fitur | Administrator (Staff) | Super Administrator |
| :--- | :---: | :---: |
| **Login Portal Petugas** | Dilayani | Dilayani |
| **Melihat Dashboard & Statistik Pasien** | Dilayani | Dilayani |
| **Pencarian & Filter Pasien** | Dilayani | Dilayani |
| **Verifikasi Status Pasien (Menunggu / Diverifikasi / Ditolak)** | Dilayani | Dilayani |
| **Mengedit Identitas Pasien** | Dilayani | Dilayani |
| **Menghapus Data Pasien** | Dilayani | Dilayani |
| **Ekspor Data Pasien ke Excel (.xlsx) & CSV** | Dilayani | Dilayani |
| **Cetak Lembar Resume Medis Pasien** | Dilayani | Dilayani |
| **Melihat Daftar Akun Petugas Admin** | Ditolak | Dilayani |
| **Menambah Akun Admin Baru** | Ditolak | Dilayani |
| **Mengubah Role & Password Admin Lain** | Ditolak | Dilayani |
| **Menonaktifkan Akun Petugas** | Ditolak | Dilayani |
| **Menghapus Akun Petugas** | Ditolak | Dilayani |

---

## 3. Panduan Masuk Sistem (Login)

1. Buka peramban (Google Chrome, Microsoft Edge, atau Mozilla Firefox).
2. Akses alamat URL portal manajemen:
   ```text
   https://klinikcahayasurya.com/login
   ```
   *(Atau klik tombol **Login Staff** pada pojok kanan atas halaman utama website).*
3. Masukkan **Alamat Email** dan **Password** sesuai kredensial resmi pada [Bagian 1](#1-kredensial-akses-resmi).
4. *(Opsional)* Centang kotak **Ingat Saya** pada perangkat kerja pribadi agar sesi login tersimpan lebih lama.
5. Klik tombol biru **Masuk ke Panel**.
6. Sistem akan memvalidasi kredensial:
   - Jika login sebagai **Super Administrator**, Anda akan otomatis diarahkan ke **Dashboard Super Admin** (`/superadmin`).
   - Jika login sebagai **Administrator**, Anda akan otomatis diarahkan ke **Data Pasien** (`/admin/pasien`).

---

## 4. Panduan Operasional Administrator (Staff Pendaftaran)

### 4.1 Navigasi & Memahami Dashboard Pasien
Setelah berhasil masuk, Administrator disambut dengan antarmuka tabel pasien yang dilengkapi 4 kartu statistik ringkas di bagian atas:
1. **Pasien Hari Ini (Kartu Biru)**: Menghitung jumlah pendaftar baru per hari ini secara *real-time*.
2. **Pasien Bulan Ini (Kartu Toska)**: Akumulasi pendaftar dalam bulan berjalan.
3. **Total Pasien (Kartu Hijau)**: Total keseluruhan data pasien di database.
4. **Menunggu Verifikasi (Kartu Kuning)**: Pasien baru yang membutuhkan tindakan verifikasi dari petugas.

> **Pintas Cepat (Quick Filter):** Anda dapat mengklik langsung kartu **"Pasien Hari Ini"** atau kartu **"Menunggu Verifikasi"** untuk memfilter tabel secara instan tanpa perlu mengetik manual.

---

### 4.2 Pencarian & Filter Cepat Data Pasien
Gunakan toolbar pencarian yang terletak tepat di bawah header tabel untuk menyaring data:
- **Kotak Cari**: Masukkan Nama Pasien, Nomor NIK (KTP), Nomor Antrian, atau Nama Perusahaan/Sekolah.
- **Semua Program**: Pilih antara **Sekolah** (Skrining Mata) atau **Perusahaan** (Skrining Vaskuler).
- **Semua Status**: Pilih antara **Menunggu**, **Diverifikasi**, atau **Ditolak**.
- **Pilih Tanggal**: Pilih tanggal pendaftaran tertentu untuk menampilkan rekapitulasi hari tersebut.
- Klik tombol **Filter** untuk menjalankan penyaringan.
- Klik tombol **Reset** untuk mengembalikan tampilan ke seluruh data pasien.

---

### 4.3 Verifikasi Status & Catatan Medis Pasien
1. Pada tabel pasien, cari pasien yang ingin diverifikasi.
2. Klik tombol **Detail** (ikon mata berwarna biru).
3. Pada kolom kanan bawah, terdapat kotak hijau **Tindakan Admin**:
   - **Pilihan Status**:
     - `Menunggu`: Berkas pendaftaran baru masuk, belum divalidasi.
     - `Diverifikasi`: Berkas telah disetujui untuk mengikuti jadwal skrining / pemeriksaan dokter.
     - `Ditolak`: Berkas tidak memenuhi syarat atau data duplikat.
   - **Catatan Admin**: Isikan catatan internal (misal: *"Jadwal pemeriksaan dikonfirmasi pukul 09.00 WIB"* atau *"Nomor telepon tidak dapat dihubungi"*).
4. Klik tombol **Simpan Status**. Sistem akan memperbarui status secara instan tanpa perlu memuat ulang halaman secara manual.

---

### 4.4 Melihat Detail & Rekam Pendaftaran
Halaman detail pasien menyajikan informasi komprehensif yang terstruktur dalam 3 bagian kartu:
- **Header Profil**: Menampilkan avatar inisial, Nama Lengkap, Status Badge, Program Skrining, Nomor Antrian, Tanggal Registrasi, dan Institusi/Perusahaan.
- **Box 1 (Biru) - Data Diri**: Identitas NIK, Tempat & Tanggal Lahir, Usia terhitung otomatis, Jenis Kelamin, Kontak WhatsApp, Email E-Report, Pekerjaan, Pendidikan Terakhir, dan Alamat Lengkap.
- **Box 2 (Ungu) - Riwayat & Keluhan**: Rekam penyakit pribadi (tampil dalam bentuk pill badge merah), riwayat kesehatan keluarga (badge kuning), serta kotak keluhan utama pasien.
- **Box 3 (Hijau) - Tindakan Admin**: Area eksekusi status verifikasi dan pencatatan catatan petugas.

---

### 4.5 Mengedit Data Pasien
Jika calon pasien melakukan kesalahan pengetikan nama, NIK, alamat, atau nomor WhatsApp:
1. Pada baris tabel pasien (atau dari halaman Detail), klik tombol **Edit** (ikon pensil kuning).
2. Formulir edit akan menampilkan isian yang sudah terisi sebelumnya. Lakukan perbaikan data yang diperlukan.
3. Klik tombol biru **Simpan Perubahan** di bagian bawah.
4. Data akan segera diperbarui dan Anda akan dikembalikan ke daftar pasien dengan notifikasi sukses.

---

### 4.6 Mencetak Resume Data Pasien
Sistem menyediakan antarmuka pencetakan ramah cetak (*print-friendly*):
1. Buka halaman **Detail Pasien**.
2. Klik tombol **Cetak / Print** (ikon printer) pada sudut kanan atas.
3. Jendela dialog cetak browser akan terbuka secara otomatis:
   - Bilah navigasi (navbar) dan tombol admin disembunyikan otomatis oleh sistem saat dicetak.
   - Layout dokumen rapi dan proporsional untuk kertas A4 atau disimpan ke format **Save as PDF**.

---

### 4.7 Mengunduh Data ke Format Microsoft Excel (.xlsx) / CSV
Sistem dilengkapi fitur pengekspor data cerdas yang **menyesuaikan dengan filter yang sedang aktif**:
1. *(Contoh)* Jika Anda ingin mengunduh **hanya pasien yang mendaftar hari ini**:
   - Klik kartu **Pasien Hari Ini** (atau gunakan filter tanggal).
2. Pada pojok kanan atas tabel, klik tombol hijau **Download Excel**.
3. File spreadsheet `.xlsx` akan langsung terunduh ke komputer Anda dengan penamaan otomatis informatif (misal: `data-pasien_2026-10-13_171500.xlsx`).
4. **Keunggulan Format Excel Sistem**:
   - Header kolom berwarna biru rapi dengan teks tebal.
   - Lebar kolom otomatis disesuaikan secara proporsional.
   - Nomor NIK (16 digit) diawali proteksi teks sehingga angka `0` di awal tidak hilang dan angka tidak berubah menjadi notasi eksponensial (seperti `3.2E+15`).
5. *(Opsi CSV)*: Klik panah kecil dropdown di samping tombol Download Excel -> pilih **File CSV (.csv)** jika ingin mengimpor ke software pihak ketiga atau basis data lain.

---

### 4.8 Menghapus Data Pasien
1. Pada tabel pasien, klik tombol **Hapus** (ikon tempat sampah merah) pada baris pasien yang dimaksud.
2. Kotak konfirmasi peringatan akan muncul: *"Yakin hapus data pasien [Nama Pasien]?"*.
3. Klik **OK** untuk mengonfirmasi penghapusan permanen.

---

## 5. Panduan Operasional Super Administrator

### 5.1 Dashboard Utama Super Admin
Akses menu **Dashboard Utama** (`/superadmin`):
- **Statistik Akun**: Total Admin Keseluruhan, Admin Aktif, Admin Nonaktif, dan Total Pasien Terdaftar.
- **Tabel Daftar Akun Petugas**: Menampilkan Nomor urut, Nama Petugas, Email Login, Nomor HP, Hak Akses (Role), Status Akun, Tanggal Pembuatan, serta Tombol Aksi.

---

### 5.2 Menambahkan Petugas / Admin Baru
1. Pada halaman Kelola Admin, klik tombol biru **Tambah Admin Baru**.
2. Lengkapi formulir pendaftaran akun:
   - **Nama Lengkap**: Nama terang petugas/staf.
   - **Email Login**: Alamat email aktif unik (akan digunakan sebagai ID login).
   - **No. WhatsApp / HP**: Nomor telepon yang dapat dihubungi.
   - **Role (Hak Akses)**: Pilih **Admin** (staf operasional) atau **Superadmin**.
   - **Status Akun**: Pilih **Aktif**.
   - **Password Baru**: Minimal 8 karakter (disarankan kombinasi huruf, angka, dan simbol).
   - **Konfirmasi Password**: Masukkan ulang password yang sama persis.
3. Klik **Simpan Akun**. Akun baru langsung dapat digunakan login seketika itu juga.

---

### 5.3 Mengubah Data & Reset Password Petugas
1. Pada baris akun petugas di tabel, klik tombol **Edit** (ikon pensil kuning).
2. Anda dapat memperbarui Nama, Email, Nomor Telepon, Role, maupun Status.
3. **Mereset Kata Sandi Petugas**:
   - Jika petugas lupa kata sandi, cukup ketikkan password baru pada kolom *Password Baru* dan *Konfirmasi Password*.
   - Jika hanya ingin memperbarui identitas tanpa mengganti password, biarkan kedua kolom password tersebut **KOSONG**.
4. Klik **Simpan Perubahan**.

---

### 5.4 Menonaktifkan / Mengaktifkan Akun Petugas
Jika seorang staf sedang cuti, mutasi, atau tidak bertugas:
- Pada kolom **Status Akun**, klik langsung badge status petugas:
  - Klik **Aktif (Badge Hijau)** -> status akan langsung berganti menjadi **Nonaktif (Badge Merah)**.
  - Klik kembali untuk mengaktifkannya kembali (*instant toggle*).
- Petugas dengan status nonaktif akan langsung ditolak oleh sistem saat mencoba login.

---

### 5.5 Menghapus Akun Petugas
1. Klik tombol **Hapus** (ikon tempat sampah merah) pada akun petugas yang ingin dihapus.
2. Konfirmasi penghapusan pada kotak dialog browser.
3. *Pengaman Sistem:* Super Administrator tidak dapat menghapus akunnya sendiri yang sedang aktif digunakan.

---

## 6. Alur Referensi Pendaftaran Pasien (Sisi Publik)

1. **Program Skrining Sekolah (Mata)**:
   - Ditujukan bagi: Siswa, Siswi, Guru, dan Staf Lembaga Pendidikan.
   - Format Nomor Antrian: **`SEK-YYYYMMDD-XXX`** (contoh: `SEK-20261013-001`).
   - Fokus Skrining: Refraksi, Ketajaman Penglihatan, Diskriminasi Warna, dan Kamera Retina AI (EyeRobo Fundus).
2. **Program Skrining Perusahaan (Vaskuler)**:
   - Ditujukan bagi: Karyawan, Tenaga Kerja, dan Manajemen Perusahaan.
   - Format Nomor Antrian: **`CORP-YYYYMMDD-XXX`** (contoh: `CORP-20261013-001`).
   - Fokus Skrining: Deteksi Dini Jantung (EKG Kardia), Vaskuler Tungkai (ABI Doppler), Retina Mata AI, dan Risiko Stroke.

---

## 7. Panduan Penanganan Kendala (Troubleshooting & FAQ)

### Q1: Muncul pesan "500 Server Error" saat menekan tombol login di hosting
- **Penyebab**: Folder penampung sesi login di server hosting belum memiliki izin tulis (*write permission*).
- **Solusi**: Masuk ke cPanel File Manager -> klik kanan folder `storage` dan folder `bootstrap/cache` -> pilih **Change Permissions** -> ubah izin akses menjadi **`775`** (atau `755`).

### Q2: Muncul pesan "Email atau password salah" saat login
- Pastikan tidak ada spasi di awal atau akhir pengetikan email/password.
- Perhatikan huruf kapital dan simbol karakter khusus pada password:
  - Superadmin: `super@dmincahaya_`
  - Admin: `@dmincahaya_`

### Q3: Angka NIK 16 digit berubah menjadi `3.2E+15` saat file Excel dibuka
- Sistem Klinik Utama Cahaya Surya telah dilengkapi pelindung kutip satu (`'`) otomatis pada setiap digit NIK saat diekspor. Pastikan Anda mengunduh melalui tombol resmi **Download Excel** pada tabel.

---

*Manual Book ini disusun untuk memastikan kelancaran operasional harian Klinik Utama Cahaya Surya.*
*Hak Cipta © 2026 Klinik Utama Cahaya Surya & Rumah Sakit Mata Solo.*
