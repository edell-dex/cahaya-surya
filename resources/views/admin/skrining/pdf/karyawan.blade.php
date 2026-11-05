<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Hasil Skrining Karyawan — {{ $skrining->pasien->nama_lengkap }}</title>
    <style>
        @page {
            margin: 22px 28px;
        }
        body {
            font-family: 'Helvetica', Arial, sans-serif;
            color: #1e293b;
            font-size: 10px;
            line-height: 1.3;
        }
        /* Kop Surat Header */
        .kop-table {
            width: 100%;
            border-bottom: 2px solid #0f766e;
            padding-bottom: 6px;
            margin-bottom: 10px;
        }
        .kop-table td {
            vertical-align: middle;
        }
        .kop-title {
            color: #0f766e;
            font-size: 13.5px;
            font-weight: bold;
            margin: 0;
            text-transform: uppercase;
        }
        .kop-sub {
            font-size: 8.5px;
            color: #475569;
            margin-top: 1px;
        }

        /* Section Title (Gaya Gambar 2 & 3: Biru Tua A, B, C, D) */
        .section-title {
            color: #1a3c5e;
            font-size: 11px;
            font-weight: bold;
            border-bottom: 1.5px solid #94a3b8;
            padding-bottom: 3px;
            margin-top: 8px;
            margin-bottom: 7px;
            text-transform: uppercase;
        }

        /* Patient Info Box */
        .patient-box {
            border: 1px solid #cbd5e1;
            border-radius: 5px;
            padding: 8px 12px;
            background-color: #f8fafc;
            margin-bottom: 8px;
        }
        .patient-table {
            width: 100%;
            border-collapse: collapse;
        }
        .patient-table td {
            padding: 2.5px 4px;
            font-size: 10px;
        }

        /* Sub-Header */
        .sub-header {
            font-size: 10px;
            font-weight: bold;
            color: #0f172a;
            margin-top: 6px;
            margin-bottom: 4px;
        }

        /* Table Metabolik */
        .table-medis {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }
        .table-medis th {
            background-color: #f1f5f9;
            color: #1a3c5e;
            border: 1px solid #cbd5e1;
            padding: 5px 8px;
            font-size: 9.5px;
            font-weight: bold;
            text-align: left;
        }
        .table-medis td {
            border: 1px solid #cbd5e1;
            padding: 4.5px 8px;
            font-size: 9.5px;
            vertical-align: middle;
        }

        /* Badges status */
        .badge-normal {
            background-color: #dcfce7;
            color: #166534;
            font-weight: bold;
            font-size: 8.5px;
            padding: 2px 7px;
            border-radius: 3px;
            border: 1px solid #86efac;
            display: inline-block;
        }
        .badge-tinggi {
            background-color: #fee2e2;
            color: #991b1b;
            font-weight: bold;
            font-size: 8.5px;
            padding: 2px 7px;
            border-radius: 3px;
            border: 1px solid #fca5a5;
            display: inline-block;
        }

        /* Subbox Card */
        .subbox {
            border: 1px solid #cbd5e1;
            border-radius: 4px;
            padding: 6px 10px;
            margin-bottom: 6px;
            background-color: #ffffff;
        }

        /* Checkbox styling */
        .box-check {
            display: inline-block;
            width: 10px;
            height: 10px;
            border: 1.2px solid #334155;
            text-align: center;
            line-height: 9px;
            font-size: 8.5px;
            font-weight: bold;
            margin-right: 4px;
            vertical-align: middle;
        }

        /* Kesimpulan box */
        .kesimpulan-box {
            border: 1px solid #cbd5e1;
            border-radius: 4px;
            padding: 8px 12px;
            background-color: #f8fafc;
            margin-bottom: 8px;
        }

        /* Footer staff */
        .footer-table {
            width: 100%;
            margin-top: 10px;
            border-top: 1px solid #cbd5e1;
            padding-top: 6px;
        }
        .footer-table td {
            vertical-align: top;
            font-size: 9px;
        }
    </style>
</head>
<body>

    {{-- Kop Surat --}}
    <table class="kop-table">
        <tr>
            <td style="width: 70%;">
                <div class="kop-title">KLINIK UTAMA CAHAYA SURYA</div>
                <div class="kop-sub">Bekerja Sama dengan <strong>Rumah Sakit Mata Solo</strong> &bull; Program Skrining Vaskuler Perusahaan</div>
                <div class="kop-sub">Jl. Raya Solo – Tawangmangu (KM 10,6), Jaten, Karanganyar &bull; Telp: (0271) 495885</div>
            </td>
            <td style="width: 30%; text-align: right;">
                <div style="font-size: 8.5px; color:#64748b;">No. Antrian / ID:</div>
                <div style="font-size: 12px; font-weight: bold; color: #0f766e;">{{ $skrining->pasien->no_antrian }}</div>
            </td>
        </tr>
    </table>

    {{-- A. DATA KARYAWAN (PATIENT INFO) --}}
    <div class="section-title">A. DATA KARYAWAN (PATIENT INFO)</div>
    <div class="patient-box">
        <table class="patient-table">
            <tr>
                <td style="width: 18%; font-weight: bold;">Nama Lengkap</td>
                <td style="width: 34%;">: <strong>{{ $skrining->pasien->nama_lengkap }}</strong></td>
                <td style="width: 18%; font-weight: bold;">ID Karyawan / NIK</td>
                <td style="width: 30%;">: {{ $skrining->pasien->nik }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Perusahaan</td>
                <td>: {{ $skrining->pasien->institusi_nama ?? '-' }}</td>
                <td style="font-weight: bold;">Departemen</td>
                <td>: {{ $skrining->pasien->kelas_unit ?? ($skrining->pasien->pekerjaan ?? 'Staff') }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Usia / Kelamin</td>
                <td>: {{ $skrining->pasien->usia ? $skrining->pasien->usia . ' Tahun' : '-' }} / {{ $skrining->pasien->jenis_kelamin }}</td>
                <td style="font-weight: bold;">Tgl Pemeriksaan</td>
                <td>: {{ $skrining->tanggal_periksa ? $skrining->tanggal_periksa->format('d F Y') : '-' }}</td>
            </tr>
        </table>
    </div>

    {{-- B. HASIL PEMERIKSAAN MEDIS --}}
    <div class="section-title">B. HASIL PEMERIKSAAN MEDIS</div>

    {{-- Alat yang Dipakai --}}
    @if($skrining->alat_dipakai && count($skrining->alat_dipakai))
    <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:4px;padding:7px 10px;margin-bottom:12px;">
        <span style="font-weight:700;font-size:10px;color:#0f766e;">Alat yang Dipakai: </span>
        @foreach($skrining->alat_dipakai as $alat)
        <span style="display:inline-block;background:#0f766e;color:#fff;font-size:9px;font-weight:700;padding:2px 8px;border-radius:4px;margin:2px 3px 2px 0;">{{ $alat }}</span>
        @endforeach
    </div>
    @endif

    {{-- 1. Pemeriksaan Metabolik (EasyTouch GCU) --}}
    <div class="sub-header">1. Pemeriksaan Metabolik (EasyTouch GCU)</div>
    <table class="table-medis">
        <thead>
            <tr>
                <th style="width: 35%;">Parameter</th>
                <th style="width: 25%; text-align: center;">Hasil</th>
                <th style="width: 22%; text-align: center;">Nilai Normal</th>
                <th style="width: 18%; text-align: center;">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="font-weight: bold;">Gula Darah (Sewaktu)</td>
                <td style="text-align: center;">{{ $skrining->gula_darah ? $skrining->gula_darah . ' mg/dL' : '-' }}</td>
                <td style="text-align: center; color: #64748b;">&lt; 140 mg/dL</td>
                <td style="text-align: center;">
                    @if($skrining->status_gula_darah === 'Normal')
                        <span class="badge-normal">Normal</span>
                    @elseif($skrining->status_gula_darah)
                        <span class="badge-tinggi">{{ $skrining->status_gula_darah }}</span>
                    @else - @endif
                </td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Kolesterol Total</td>
                <td style="text-align: center;">{{ $skrining->kolesterol_total ? $skrining->kolesterol_total . ' mg/dL' : '-' }}</td>
                <td style="text-align: center; color: #64748b;">&lt; 200 mg/dL</td>
                <td style="text-align: center;">
                    @if($skrining->status_kolesterol === 'Normal')
                        <span class="badge-normal">Normal</span>
                    @elseif($skrining->status_kolesterol)
                        <span class="badge-tinggi">{{ $skrining->status_kolesterol }}</span>
                    @else - @endif
                </td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Asam Urat</td>
                <td style="text-align: center;">{{ $skrining->asam_urat ? $skrining->asam_urat . ' mg/dL' : '-' }}</td>
                <td style="text-align: center; color: #64748b;">&lt; 7.0 mg/dL</td>
                <td style="text-align: center;">
                    @if($skrining->status_asam_urat === 'Normal')
                        <span class="badge-normal">Normal</span>
                    @elseif($skrining->status_asam_urat)
                        <span class="badge-tinggi">{{ $skrining->status_asam_urat }}</span>
                    @else - @endif
                </td>
            </tr>
        </tbody>
    </table>

    {{-- 2. Skrining Vaskuler (ABI) --}}
    <div class="sub-header">2. Skrining Vaskuler (Ankle Brachial Index / ABI)</div>
    <div class="subbox">
        <table style="width: 100%; font-size: 9.5px;">
            <tr>
                <td style="width: 50%;">Nilai ABI Kanan: <strong>{{ $skrining->abi_kanan ?: '-' }}</strong></td>
                <td style="width: 50%;">Nilai ABI Kiri: <strong>{{ $skrining->abi_kiri ?: '-' }}</strong></td>
            </tr>
            <tr>
                <td colspan="2" style="padding-top: 4px;">
                    <strong>Interpretasi:</strong>
                    &nbsp;&nbsp;
                    <span class="box-check">{{ ($skrining->abi_interpretasi ?? 'Normal') === 'Normal' ? 'X' : '' }}</span> Normal (0.91 - 1.30)
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <span class="box-check">{{ ($skrining->abi_interpretasi ?? '') === 'Borderline' ? 'X' : '' }}</span> Borderline
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <span class="box-check">{{ ($skrining->abi_interpretasi ?? '') === 'Indikasi PAD' ? 'X' : '' }}</span> Indikasi PAD
                </td>
            </tr>
        </table>
    </div>

    {{-- 3. Skrining Jantung (Kardia L6) --}}
    <div class="sub-header">3. Skrining Jantung (Kardia L6)</div>
    <div class="subbox">
        <div style="font-size: 9.5px; margin-bottom: 3px;">
            <strong>Irama Jantung (ECG):</strong>
            &nbsp;&nbsp;
            <span class="box-check">{{ ($skrining->ecg_irama ?? 'Normal Sinus Rhythm') === 'Normal Sinus Rhythm' ? 'X' : '' }}</span> Normal Sinus Rhythm
            &nbsp;&nbsp;&nbsp;&nbsp;
            <span class="box-check">{{ ($skrining->ecg_irama ?? '') === 'Atrial Fibrillation (AFib)' ? 'X' : '' }}</span> Atrial Fibrillation (AFib)
            &nbsp;&nbsp;&nbsp;&nbsp;
            <span class="box-check">{{ ($skrining->ecg_irama ?? '') === 'Lainnya' ? 'X' : '' }}</span> Lainnya
        </div>
        <div style="font-size: 9.5px; margin-bottom: 3px;">
            <strong>Detak Jantung:</strong> {{ $skrining->ecg_detak ? $skrining->ecg_detak . ' BPM (Beats Per Minute)' : '-' }}
        </div>
        <div style="font-size: 9.5px;">
            <strong>Catatan:</strong> {{ $skrining->ecg_catatan ?: 'Tidak ditemukan kelainan irama jantung pada saat pemeriksaan.' }}
        </div>
    </div>

    {{-- 4. Skrining Mata (EyeRobo Fundus Camera) --}}
    <div class="sub-header">4. Skrining Mata (EyeRobo Fundus Camera)</div>
    <div class="subbox">
        <table style="width: 100%; font-size: 9.5px; margin-bottom: 3px;">
            <tr>
                <td style="width: 50%;">
                    <strong>Mata Kanan (OD):</strong>
                    <span class="box-check">{{ ($skrining->mata_od_status ?? 'Normal') === 'Normal' ? 'X' : '' }}</span> Normal
                    <span class="box-check">{{ ($skrining->mata_od_status ?? '') === 'Kelainan' ? 'X' : '' }}</span> Kelainan {{ $skrining->mata_od_keterangan ? '('.$skrining->mata_od_keterangan.')' : '' }}
                </td>
                <td style="width: 50%;">
                    <strong>Mata Kiri (OS):</strong>
                    <span class="box-check">{{ ($skrining->mata_os_status ?? 'Normal') === 'Normal' ? 'X' : '' }}</span> Normal
                    <span class="box-check">{{ ($skrining->mata_os_status ?? '') === 'Kelainan' ? 'X' : '' }}</span> Kelainan {{ $skrining->mata_os_keterangan ? '('.$skrining->mata_os_keterangan.')' : '' }}
                </td>
            </tr>
        </table>
        <div style="font-size: 9.5px;">
            <strong>Temuan Vaskular Retina:</strong> {{ $skrining->mata_vaskular_retina ?: 'Pembuluh darah retina tampak baik, tidak ada tanda-tanda retinopati diabetik atau hipertensi.' }}
        </div>
    </div>

    {{-- 5. Skrining Otak (Evaluasi Risiko Stroke) --}}
    <div class="sub-header">5. Skrining Otak (Evaluasi Risiko Stroke)</div>
    <div class="subbox">
        <div style="font-size: 9.5px; margin-bottom: 3px;">
            <strong>Tingkat Risiko:</strong>
            &nbsp;&nbsp;
            <span class="box-check">{{ ($skrining->otak_risiko ?? 'Rendah') === 'Rendah' ? 'X' : '' }}</span> Rendah (Low)
            &nbsp;&nbsp;&nbsp;&nbsp;
            <span class="box-check">{{ ($skrining->otak_risiko ?? '') === 'Sedang' ? 'X' : '' }}</span> Sedang (Moderate)
            &nbsp;&nbsp;&nbsp;&nbsp;
            <span class="box-check">{{ ($skrining->otak_risiko ?? '') === 'Tinggi' ? 'X' : '' }}</span> Tinggi (High)
        </div>
        <div style="font-size: 9.5px;">
            <strong>Catatan Evaluasi:</strong> {{ $skrining->otak_catatan ?: 'Berdasarkan parameter vaskular (ABI) dan irama jantung, suplai darah ke otak terindikasi aman.' }}
        </div>
    </div>

    {{-- C. INTERPRETASI & KESIMPULAN UMUM --}}
    <div class="section-title">C. INTERPRETASI & KESIMPULAN UMUM</div>
    <div class="kesimpulan-box">
        <div style="font-size: 8.5px; color: #475569; font-style: italic; margin-bottom: 4px;">Diisi oleh dokter pemeriksa berdasarkan integrasi kelima skrining.</div>
        @php
        $selectedKU = $skrining->kesimpulan_umum ?? ['Pemantauan Berkala (Risiko Sedang)'];
        @endphp
        <div style="margin-bottom: 4px; font-size: 9.5px;">
            <span class="box-check">{{ in_array('Kondisi Sehat / Risiko Rendah', $selectedKU) ? 'X' : '' }}</span>
            <strong>Kondisi Sehat / Risiko Rendah:</strong> Parameter metabolisme dan vaskuler dalam batas normal.
        </div>
        <div style="margin-bottom: 4px; font-size: 9.5px;">
            <span class="box-check">{{ in_array('Pemantauan Berkala (Risiko Sedang)', $selectedKU) ? 'X' : '' }}</span>
            <strong>Pemantauan Berkala (Risiko Sedang):</strong> Terdapat parameter yang perlu diperbaiki (Hiperkolesterolemia) melalui modifikasi gaya hidup.
        </div>
        <div style="font-size: 9.5px;">
            <span class="box-check">{{ in_array('Perlu Penanganan Medis Lanjut (Risiko Tinggi)', $selectedKU) ? 'X' : '' }}</span>
            <strong>Perlu Penanganan Medis Lanjut (Risiko Tinggi):</strong> Ditemukan indikasi gangguan yang membutuhkan evaluasi spesialis segera.
        </div>
    </div>

    {{-- D. REKOMENDASI TINDAK LANJUT --}}
    <div class="section-title">D. REKOMENDASI TINDAK LANJUT</div>
    <div class="kesimpulan-box" style="margin-bottom: 6px;">
        <div style="font-weight: bold; font-size: 9.5px; margin-bottom: 4px;">Gaya Hidup & Nutrisi:</div>
        @php
        $selectedGH = $skrining->rekomendasi_gaya_hidup ?? [];
        $ghItems = [
            'Kurangi konsumsi makanan berlemak tinggi, gorengan, dan santan (Diet rendah kolesterol).',
            'Tingkatkan aktivitas fisik/olahraga aerobik minimal 30 menit sehari, 5 kali seminggu.',
            'Perbanyak konsumsi serat dari buah dan sayuran segar.'
        ];
        @endphp
        @foreach($ghItems as $ghi)
        <div style="font-size: 9px; margin-bottom: 2px;">
            <span class="box-check">{{ in_array($ghi, $selectedGH) || empty($selectedGH) ? 'X' : '' }}</span> {{ $ghi }}
        </div>
        @endforeach

        <div style="font-weight: bold; font-size: 9.5px; margin-top: 6px; margin-bottom: 4px;">Rujukan & Konsultasi Medis:</div>
        @php
        $selectedRJ = $skrining->rekomendasi_rujukan ?? [];
        $rjItems = [
            'Konsultasi ke Dokter Spesialis Jantung atau Saraf.',
            'Konsultasi ke Dokter Spesialis Mata di RS Mata Solo.',
            'Cek ulang Kolesterol Total dan Profil Lipid lengkap (LDL, HDL, Trigliserida) 1 bulan ke depan.'
        ];
        @endphp
        @foreach($rjItems as $rji)
        <div style="font-size: 9px; margin-bottom: 2px;">
            <span class="box-check">{{ in_array($rji, $selectedRJ) ? 'X' : '' }}</span> {{ $rji }}
        </div>
        @endforeach
    </div>

    {{-- Footer & Tanda Tangan --}}
    <table class="footer-table">
        <tr>
            <td style="width: 60%;">
                <div style="color: #64748b;">Informasi Pencatatan Sistem:</div>
                <div style="margin-top: 2px;">
                    Diisi oleh Staff: <strong>{{ $skrining->user->name ?? 'Staff Klinik' }}</strong> ({{ strtoupper($skrining->user->role ?? 'Admin') }})
                </div>
                <div style="color: #64748b;">Email Petugas: {{ $skrining->user->email ?? '-' }}</div>
                <div style="color: #64748b;">Waktu Input: {{ $skrining->created_at ? $skrining->created_at->format('d/m/Y H:i') : '-' }} WIB</div>
            </td>
            <td style="width: 40%; text-align: center;">
                <div>Karanganyar, {{ $skrining->tanggal_periksa ? $skrining->tanggal_periksa->format('d F Y') : date('d F Y') }}</div>
                <div style="font-weight: bold; margin-top: 2px;">Dokter / Petugas Pemeriksa,</div>
                <div style="height: 35px;"></div>
                <div style="font-weight: bold; text-decoration: underline;">Klinik Utama Cahaya Surya</div>
                <div style="font-size: 8px; color: #64748b;">E-Report Resmi Skrining Vaskuler & Metabolik</div>
            </td>
        </tr>
    </table>

</body>
</html>
