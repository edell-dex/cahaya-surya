<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Hasil Skrining Mata Siswa — {{ $skrining->pasien->nama_lengkap }}</title>
    <style>
        @page {
            margin: 24px 30px;
        }
        body {
            font-family: 'Helvetica', Arial, sans-serif;
            color: #1e293b;
            font-size: 11px;
            line-height: 1.35;
        }
        /* Kop Surat Header */
        .kop-table {
            width: 100%;
            border-bottom: 2px solid #005a9c;
            padding-bottom: 8px;
            margin-bottom: 12px;
        }
        .kop-table td {
            vertical-align: middle;
        }
        .kop-title {
            color: #005a9c;
            font-size: 14px;
            font-weight: bold;
            margin: 0;
            text-transform: uppercase;
        }
        .kop-sub {
            font-size: 9px;
            color: #475569;
            margin-top: 2px;
        }

        /* Banner Title */
        .banner-title {
            background-color: #005a9c;
            color: #ffffff;
            text-align: center;
            font-size: 13px;
            font-weight: bold;
            padding: 8px 12px;
            border-radius: 4px;
            margin-bottom: 12px;
            letter-spacing: 0.5px;
        }

        /* Patient Info Box */
        .info-box {
            border: 1px solid #cbd5e1;
            background-color: #f8fafc;
            border-radius: 6px;
            padding: 8px 12px;
            margin-bottom: 14px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-table td {
            padding: 3px 4px;
            font-size: 10.5px;
        }

        /* Section Title */
        .section-header {
            color: #005a9c;
            font-size: 11.5px;
            font-weight: bold;
            border-bottom: 1.5px solid #005a9c;
            padding-bottom: 3px;
            margin-top: 10px;
            margin-bottom: 8px;
            text-transform: uppercase;
        }

        /* Subheader */
        .sub-header {
            font-size: 10.5px;
            font-weight: bold;
            color: #0f172a;
            margin-bottom: 5px;
        }

        /* Refraction Table */
        .table-data {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        .table-data th {
            background-color: #f1f5f9;
            color: #005a9c;
            border: 1px solid #cbd5e1;
            padding: 6px 8px;
            font-size: 10px;
            font-weight: bold;
            text-align: center;
        }
        .table-data td {
            border: 1px solid #cbd5e1;
            padding: 6px 8px;
            font-size: 10.5px;
            text-align: center;
        }

        /* 2 Column Box Layout */
        .col-box {
            border: 1px solid #cbd5e1;
            border-radius: 5px;
            padding: 8px 10px;
            background-color: #ffffff;
            min-height: 85px;
        }

        /* Checked box simulation */
        .checkbox-item {
            margin-bottom: 4px;
            font-size: 10px;
        }
        .box-check {
            display: inline-block;
            width: 11px;
            height: 11px;
            border: 1.5px solid #475569;
            text-align: center;
            line-height: 10px;
            font-size: 9px;
            font-weight: bold;
            margin-right: 5px;
            vertical-align: middle;
        }

        /* Doctor Notes Box */
        .doctor-box {
            border: 1px solid #005a9c;
            border-radius: 5px;
            background-color: #f0fdf4;
            padding: 10px 12px;
            margin-top: 5px;
            min-height: 60px;
            font-size: 10.5px;
        }

        /* Footer / Tanda Tangan */
        .footer-table {
            width: 100%;
            margin-top: 16px;
            border-top: 1px solid #cbd5e1;
            padding-top: 8px;
        }
        .footer-table td {
            vertical-align: top;
            font-size: 9.5px;
        }
    </style>
</head>
<body>

    {{-- Kop Klinik --}}
    <table class="kop-table">
        <tr>
            <td style="width: 70%;">
                <div class="kop-title">KLINIK UTAMA CAHAYA SURYA</div>
                <div class="kop-sub">Bekerja Sama dengan <strong>Rumah Sakit Mata Solo</strong> &bull; Program Skrining Sekolah</div>
                <div class="kop-sub">Jl. Raya Solo – Tawangmangu (KM 10,6), Jaten, Karanganyar &bull; Telp: (0271) 495885</div>
            </td>
            <td style="width: 30%; text-align: right;">
                <div style="font-size: 9px; color:#64748b;">No. Antrian Pasien:</div>
                <div style="font-size: 13px; font-weight: bold; color: #005a9c;">{{ $skrining->pasien->no_antrian }}</div>
            </td>
        </tr>
    </table>

    {{-- Banner Biru (Sesuai Siswa.pdf) --}}
    <div class="banner-title">
        HASIL SKRINING KESEHATAN MATA (E-REPORT)
    </div>

    {{-- Box Identitas Pasien --}}
    <div class="info-box">
        <table class="info-table">
            <tr>
                <td style="width: 16%; font-weight: bold;">Nama Lengkap</td>
                <td style="width: 34%;">: <strong>{{ $skrining->pasien->nama_lengkap }}</strong></td>
                <td style="width: 18%; font-weight: bold;">NIS / NIP / NIK</td>
                <td style="width: 32%;">: {{ $skrining->pasien->nik }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Peran / Kelas</td>
                <td>: {{ $skrining->pasien->kategori_peserta ?? 'Siswa' }} {{ $skrining->pasien->kelas_unit ? '('.$skrining->pasien->kelas_unit.')' : '' }}</td>
                <td style="font-weight: bold;">Tgl. Pemeriksaan</td>
                <td>: {{ $skrining->tanggal_periksa ? $skrining->tanggal_periksa->format('d / m / Y') : '-' }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Asal Sekolah</td>
                <td colspan="3">: {{ $skrining->pasien->institusi_nama ?? '-' }}</td>
            </tr>
        </table>
    </div>

    {{-- A. HASIL PEMERIKSAAN KLINIS --}}
    <div class="section-header">A. HASIL PEMERIKSAAN KLINIS</div>

    {{-- Alat yang Dipakai --}}
    @if($skrining->alat_dipakai && count($skrining->alat_dipakai))
    <div style="background:#eff6ff;border:1px solid #bfdbfe;border-radius:4px;padding:7px 10px;margin-bottom:12px;">
        <span style="font-weight:700;font-size:10px;color:#1d4ed8;">Alat yang Dipakai: </span>
        @foreach($skrining->alat_dipakai as $alat)
        <span style="display:inline-block;background:#1d4ed8;color:#fff;font-size:9px;font-weight:700;padding:2px 8px;border-radius:4px;margin:2px 3px 2px 0;">{{ $alat }}</span>
        @endforeach
    </div>
    @endif

    {{-- 1. Refraksi Lengkap --}}
    <div class="sub-header">1. Pemeriksaan Refraksi Lengkap (Retinomax K-plus3)</div>
    <table class="table-data">
        <thead>
            <tr>
                <th style="width: 25%;">Mata</th>
                <th style="width: 25%;">Spheris (Minus/Plus)</th>
                <th style="width: 25%;">Cylinder (Silinder)</th>
                <th style="width: 25%;">Axis</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="font-weight: bold; text-align: left; padding-left: 14px;">Kanan (OD)</td>
                <td><strong>{{ $skrining->refraksi_od_spheris ?: '-' }}</strong></td>
                <td>{{ $skrining->refraksi_od_cylinder ?: '-' }}</td>
                <td>{{ $skrining->refraksi_od_axis ?: '-' }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold; text-align: left; padding-left: 14px;">Kiri (OS)</td>
                <td><strong>{{ $skrining->refraksi_os_spheris ?: '-' }}</strong></td>
                <td>{{ $skrining->refraksi_os_cylinder ?: '-' }}</td>
                <td>{{ $skrining->refraksi_os_axis ?: '-' }}</td>
            </tr>
        </tbody>
    </table>

    {{-- 2. TIO & 3. Buta Warna --}}
    <table style="width: 100%; border-collapse: collapse; margin-bottom: 10px;">
        <tr>
            {{-- 2. Tekanan Bola Mata --}}
            <td style="width: 50%; vertical-align: top; padding-right: 6px;">
                <div class="col-box">
                    <div style="font-weight: bold; color: #005a9c; margin-bottom: 8px; font-size: 10.5px;">
                        2. Tekanan Bola Mata (iCare 100)
                    </div>
                    <table style="width: 100%; font-size: 10px;">
                        <tr>
                            <td style="padding: 2px 0;">Mata Kanan (OD):</td>
                            <td style="text-align: right; font-weight: bold;">{{ $skrining->tio_od ? $skrining->tio_od . ' mmHg' : '- mmHg' }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 2px 0;">Mata Kiri (OS):</td>
                            <td style="text-align: right; font-weight: bold;">{{ $skrining->tio_os ? $skrining->tio_os . ' mmHg' : '- mmHg' }}</td>
                        </tr>
                    </table>
                    <div style="font-size: 8.5px; color: #64748b; font-style: italic; margin-top: 6px;">
                        *Nilai normal: 10 - 21 mmHg
                    </div>
                </div>
            </td>

            {{-- 3. Buta Warna --}}
            <td style="width: 50%; vertical-align: top; padding-left: 6px;">
                <div class="col-box">
                    <div style="font-weight: bold; color: #005a9c; margin-bottom: 8px; font-size: 10.5px;">
                        3. Skrining Buta Warna (Munsell D15)
                    </div>
                    <div class="checkbox-item">
                        <span class="box-check">{{ ($skrining->buta_warna ?? 'Normal') === 'Normal' ? 'X' : '' }}</span>
                        <strong>Normal</strong> <span style="color:#64748b;">(Tidak ada gangguan)</span>
                    </div>
                    <div class="checkbox-item">
                        <span class="box-check">{{ ($skrining->buta_warna ?? '') === 'Parsial' ? 'X' : '' }}</span>
                        <strong>Parsial</strong> <span style="color:#64748b;">(Buta warna sebagian)</span>
                    </div>
                    <div class="checkbox-item">
                        <span class="box-check">{{ ($skrining->buta_warna ?? '') === 'Total' ? 'X' : '' }}</span>
                        <strong>Total</strong> <span style="color:#64748b;">(Buta warna total)</span>
                    </div>
                </div>
            </td>
        </tr>
    </table>

    {{-- 4. Skrining Retina Digital AI --}}
    <div class="col-box" style="margin-bottom: 12px; min-height: auto;">
        <div style="font-weight: bold; color: #005a9c; margin-bottom: 5px; font-size: 10.5px;">
            4. Skrining Retina Digital AI (EyeRobo AI Fundus Camera)
        </div>
        <div style="font-size: 10px; font-weight: bold; color: #334155; margin-bottom: 3px;">
            Evaluasi Saraf, Retina & Pembuluh Darah:
        </div>
        <div style="font-size: 10px; color: #1e293b; background-color: #f8fafc; border: 1px dashed #cbd5e1; padding: 6px 8px; border-radius: 4px;">
            {{ $skrining->retina_ai_catatan ?: '-' }}
        </div>
    </div>

    {{-- B. KESIMPULAN & REKOMENDASI --}}
    <div class="section-header">B. KESIMPULAN & REKOMENDASI</div>
    <div class="doctor-box">
        <div style="font-weight: bold; color: #005a9c; margin-bottom: 5px;">
            Catatan Dokter Spesialis Mata:
        </div>
        <div style="line-height: 1.5; color: #1e293b;">
            {!! nl2br(e($skrining->catatan_dokter ?: 'Pemeriksaan tajam penglihatan dan kesehatan mata selesai. Disarankan menjaga jarak membaca minimal 30 cm dan istirahat 20 detik setiap 20 menit menatap layar gawai.')) !!}
        </div>
    </div>

    {{-- Informasi Akun Staff Pengisi & Validasi --}}
    <table class="footer-table">
        <tr>
            <td style="width: 60%;">
                <div style="color: #64748b;">Informasi Pencatatan Sistem:</div>
                <div style="margin-top: 3px;">
                    Diisi oleh Staff: <strong>{{ $skrining->user->name ?? 'Staff Klinik' }}</strong> ({{ strtoupper($skrining->user->role ?? 'Admin') }})
                </div>
                <div style="color: #64748b;">Email Petugas: {{ $skrining->user->email ?? '-' }}</div>
                <div style="color: #64748b;">Waktu Input: {{ $skrining->created_at ? $skrining->created_at->format('d/m/Y H:i') : '-' }} WIB</div>
            </td>
            <td style="width: 40%; text-align: center;">
                <div>Karanganyar, {{ $skrining->tanggal_periksa ? $skrining->tanggal_periksa->format('d F Y') : date('d F Y') }}</div>
                <div style="font-weight: bold; margin-top: 2px;">Tim Medis Pemeriksa,</div>
                <div style="height: 40px;"></div>
                <div style="font-weight: bold; text-decoration: underline;">Klinik Utama Cahaya Surya</div>
                <div style="font-size: 8.5px; color: #64748b;">Dokumen Resmi Hasil Skrining Terverifikasi</div>
            </td>
        </tr>
    </table>

</body>
</html>
