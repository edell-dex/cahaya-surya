# Panduan Lengkap Persiapan & Deployment Hosting
**Klinik Utama Cahaya Surya — Sistem Informasi Pendaftaran & Pasien**

Dokumen ini berisi panduan langkah demi langkah untuk mengunggah dan menjalankan aplikasi ke server hosting (Shared Hosting / cPanel / VPS).

---

## 1. Ringkasan File & Database yang Telah Disiapkan

1. **File Database Siap Import**:
   - Lokasi: `database/klinik_db.sql`
   - Berisi struktur tabel bersih (tanpa kolom yang tidak terpakai) dan akun default.
2. **File Konfigurasi Environment**:
   - `.env.example`: Template konfigurasi production untuk hosting.
   - `.env`: File konfigurasi aktif lokal.
3. **File Keamanan & Routing Hosting**:
   - `.htaccess` (Root): Secara otomatis mengarahkan akses web ke folder `public/` serta memproteksi file sensitif (`.env`, `storage`, `artisan`, dll.) jika dipasang pada Shared Hosting cPanel.
   - `public/.htaccess`: Routing URL standar Laravel.
4. **Akun Login Bawaan**:
   - **Super Admin**: `superadmin@cahayasurya.com` | Password: `password`
   - **Staff / Admin**: `admin@cahayasurya.com` | Password: `password`
   *(Wajib ubah password setelah login pertama kali di menu Kelola Admin).*

---

## 2. Cara Hosting di Shared Hosting / cPanel (Paling Umum)

### Langkah 1: Buat Database di cPanel
1. Buka cPanel hosting Anda.
2. Masuk ke menu **MySQL Databases**:
   - Buat database baru (misal: `u12345_klinik`).
   - Buat pengguna database baru (misal: `u12345_admin`) dan buat password yang kuat.
   - Tambahkan pengguna tersebut ke database dengan memberikan centang **ALL PRIVILEGES**.
3. Buka menu **phpMyAdmin** di cPanel:
   - Pilih nama database yang baru dibuat.
   - Klik tab **Import** -> Pilih file `database/klinik_db.sql` -> Klik **Go / Kirim**.

---

### Langkah 2: Upload File Project
1. Di komputer lokal, compress/zip semua isi folder aplikasi (kecuali folder test/cache jika ingin hemat kuota).
2. Di cPanel, buka **File Manager** -> masuk ke folder **`public_html`**.
3. Upload file ZIP tersebut ke dalam `public_html` lalu klik **Extract**.
4. Pastikan file `.htaccess` di root ikut ter-extract (di cPanel File Manager, aktifkan *Settings* -> *Show Hidden Files (dotfiles)*).

---

### Langkah 3: Konfigurasi File `.env`
1. Di dalam `public_html`, buat atau edit file `.env`:
   ```env
   APP_NAME="Klinik Utama Cahaya Surya"
   APP_ENV=production
   APP_KEY=base64:zDLBzViFJvj/K7CLtoF481SSrQV5y7xdkn2nIuY7JIo=
   APP_DEBUG=false
   APP_URL=https://domain-anda.com

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=u12345_klinik
   DB_USERNAME=u12345_admin
   DB_PASSWORD=PasswordDatabaseAnda
   ```
2. Pastikan `APP_DEBUG=false` agar tidak menampilkan error sensitif ke pengunjung umum.

---

### Langkah 4: Hubungkan Storage Symlink
Jika hosting menyediakan akses **Terminal / SSH**, jalankan:
```bash
php artisan storage:link
```
Jika tidak ada Terminal di cPanel, buat file sementara bernama `link.php` di `public_html`:
```php
<?php
symlink(__DIR__ . '/storage/app/public', __DIR__ . '/public/storage');
echo 'Storage link berhasil dibuat!';
```
Akses `https://domain-anda.com/link.php` satu kali lewat browser, kemudian **hapus file `link.php` tersebut**.

---

## 3. Cara Hosting di VPS / Cloud Server (Ubuntu/Debian Nginx/Apache)

1. Clone repositori ke `/var/www/klinik`:
   ```bash
   git clone <repo-url> /var/www/klinik
   cd /var/www/klinik
   ```
2. Install dependency:
   ```bash
   composer install --no-dev --optimize-autoloader
   ```
3. Konfigurasi file `.env` dan permissions:
   ```bash
   cp .env.example .env
   php artisan key:generate
   nano .env
   chown -R www-data:www-data /var/www/klinik/storage /var/www/klinik/bootstrap/cache
   chmod -R 775 /var/www/klinik/storage /var/www/klinik/bootstrap/cache
   ```
4. Jalankan migrasi atau import database:
   ```bash
   php artisan migrate --force --seed
   php artisan storage:link
   ```
5. Optimasi Cache Production:
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```
6. Arahkan DocumentRoot Web Server (Nginx / Apache) ke:
   ```
   /var/www/klinik/public
   ```

---

## 4. Checklist Pra-Peluncuran (Pre-Launch Checklist)

- [x] Database bersih dari kolom yang tidak terpakai (hanya menyisakan data esensial).
- [x] Timezone dikonfigurasi ke `Asia/Jakarta` (WIB).
- [x] Fitur ekspor Excel (.xlsx) dan CSV menggunakan library native OpenXML tanpa ketergantungan library berat.
- [x] File `.htaccess` pengaman di root telah aktif untuk memblokir akses ke `.env` & source code.
- [x] Form pendaftaran sekolah & perusahaan telah teruji dan otomatis menghasilkan nomor antrian.
- [x] Seluruh automated unit & feature test berstatus lulus (PASS).
