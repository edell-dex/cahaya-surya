<?php

namespace App\Http\Controllers;

use App\Models\HasilSkrining;
use App\Models\Pasien;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HasilSkriningController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin,superadmin']);
    }

    /**
     * Halaman utama: daftar hasil skrining + form pencarian pasien
     */
    public function index(Request $request)
    {
        $query = HasilSkrining::with(['pasien', 'user'])->latest();

        if ($search = $request->get('search')) {
            $query->whereHas('pasien', function ($q) use ($search) {
                $q->where('no_antrian', 'like', "%{$search}%")
                  ->orWhere('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        if ($tipe = $request->get('tipe')) {
            $query->where('tipe', $tipe);
        }

        $hasilList = $query->paginate(15)->withQueryString();

        return view('admin.skrining.index', compact('hasilList'));
    }

    /**
     * API: Cari pasien berdasarkan no_antrian untuk autofill
     */
    public function cariPasien(Request $request)
    {
        $noAntrian = trim($request->get('no_antrian', ''));

        if (empty($noAntrian)) {
            return response()->json(['success' => false, 'message' => 'Kode antrian wajib diisi.']);
        }

        $pasien = Pasien::where('no_antrian', $noAntrian)->first();

        if (!$pasien) {
            return response()->json(['success' => false, 'message' => 'Kode antrian tidak ditemukan.']);
        }

        // Hitung usia
        $usia = $pasien->tanggal_lahir ? $pasien->tanggal_lahir->age . ' Tahun' : '-';
        $ttl  = ($pasien->tempat_lahir ?? '-') . ', ' . ($pasien->tanggal_lahir ? $pasien->tanggal_lahir->format('d/m/Y') : '-');

        return response()->json([
            'success' => true,
            'pasien' => [
                'id'             => $pasien->id,
                'no_antrian'     => $pasien->no_antrian,
                'nama_lengkap'   => $pasien->nama_lengkap,
                'nik'            => $pasien->nik,
                'tipe'           => $pasien->tipe_pendaftaran,
                'jenis_kelamin'  => $pasien->jenis_kelamin,
                'usia'           => $usia,
                'ttl'            => $ttl,
                'tanggal_lahir'  => $pasien->tanggal_lahir?->format('Y-m-d'),
                'kategori'       => $pasien->kategori_peserta ?? $pasien->pekerjaan ?? '-',
                'institusi'      => $pasien->institusi_nama ?? '-',
                'kelas_unit'     => $pasien->kelas_unit ?? '-',
                'pekerjaan'      => $pasien->pekerjaan ?? '-',
            ],
        ]);
    }

    /**
     * Form input hasil skrining (auto-route berdasarkan tipe pasien)
     */
    public function create(Request $request)
    {
        $pasienId = $request->get('pasien_id');
        $pasien = null;

        if ($pasienId) {
            $pasien = Pasien::findOrFail($pasienId);
        }

        return view('admin.skrining.create', compact('pasien'));
    }

    /**
     * Simpan hasil skrining
     */
    public function store(Request $request)
    {
        $tipe = $request->input('tipe');

        // Validasi dasar
        $rules = [
            'pasien_id'       => 'required|exists:pasien,id',
            'tipe'            => 'required|in:sekolah,perusahaan',
            'tanggal_periksa' => 'required|date',
        ];

        if ($tipe === 'sekolah') {
            $rules += [
                'catatan_dokter' => 'nullable|string|max:2000',
            ];
        } else {
            $rules += [
                'gula_darah'      => 'nullable|numeric|min:0|max:9999',
                'kolesterol_total' => 'nullable|numeric|min:0|max:9999',
                'asam_urat'       => 'nullable|numeric|min:0|max:99',
                'abi_kanan'       => 'nullable|numeric|min:0|max:9.99',
                'abi_kiri'        => 'nullable|numeric|min:0|max:9.99',
                'ecg_detak'       => 'nullable|integer|min:0|max:999',
            ];
        }

        $request->validate($rules);

        $data = [
            'pasien_id'       => $request->pasien_id,
            'user_id'         => Auth::id(),
            'tipe'            => $tipe,
            'tanggal_periksa' => $request->tanggal_periksa,
            'alat_dipakai'    => $request->input('alat_dipakai', []),
        ];

        if ($tipe === 'sekolah') {
            $data += [
                'refraksi_od_spheris'  => $request->refraksi_od_spheris,
                'refraksi_od_cylinder' => $request->refraksi_od_cylinder,
                'refraksi_od_axis'     => $request->refraksi_od_axis,
                'refraksi_os_spheris'  => $request->refraksi_os_spheris,
                'refraksi_os_cylinder' => $request->refraksi_os_cylinder,
                'refraksi_os_axis'     => $request->refraksi_os_axis,
                'tio_od'               => $request->tio_od ?: null,
                'tio_os'               => $request->tio_os ?: null,
                'buta_warna'           => $request->buta_warna,
                'retina_ai_catatan'    => $request->retina_ai_catatan,
                'catatan_dokter'       => $request->catatan_dokter,
            ];
        } else {
            $data += [
                'gula_darah'             => $request->gula_darah ?: null,
                'kolesterol_total'       => $request->kolesterol_total ?: null,
                'asam_urat'              => $request->asam_urat ?: null,
                'abi_kanan'              => $request->abi_kanan ?: null,
                'abi_kiri'               => $request->abi_kiri ?: null,
                'abi_interpretasi'       => $request->abi_interpretasi,
                'ecg_irama'              => $request->ecg_irama,
                'ecg_detak'              => $request->ecg_detak ?: null,
                'ecg_catatan'            => $request->ecg_catatan,
                'mata_od_status'         => $request->mata_od_status,
                'mata_od_keterangan'     => $request->mata_od_keterangan,
                'mata_os_status'         => $request->mata_os_status,
                'mata_os_keterangan'     => $request->mata_os_keterangan,
                'mata_vaskular_retina'   => $request->mata_vaskular_retina,
                'otak_risiko'            => $request->otak_risiko,
                'otak_catatan'           => $request->otak_catatan,
                'kesimpulan_umum'        => $request->input('kesimpulan_umum', []),
                'rekomendasi_gaya_hidup' => $request->input('rekomendasi_gaya_hidup', []),
                'rekomendasi_rujukan'    => $request->input('rekomendasi_rujukan', []),
            ];
        }

        $hasil = HasilSkrining::create($data);

        // Update status pasien menjadi Diverifikasi
        Pasien::where('id', $request->pasien_id)->update(['status_verifikasi' => 'Diverifikasi']);

        return redirect()->route('admin.skrining.show', $hasil)
                         ->with('success', 'Hasil skrining berhasil disimpan. Status pasien diperbarui menjadi Diverifikasi.');
    }

    /**
     * Tampilkan detail hasil skrining
     */
    public function show(HasilSkrining $skrining)
    {
        $skrining->load(['pasien', 'user']);
        return view('admin.skrining.show', compact('skrining'));
    }

    /**
     * Download PDF hasil skrining
     */
    public function downloadPdf(HasilSkrining $skrining)
    {
        try {
            $this->bootstrapDompdf();

            $skrining->load(['pasien', 'user']);

            // Pastikan direktori storage/fonts ada untuk cache font DomPDF
            $fontDir = storage_path('fonts');
            if (!is_dir($fontDir)) {
                @mkdir($fontDir, 0775, true);
            }

            $view = $skrining->tipe === 'sekolah'
                ? 'admin.skrining.pdf.siswa'
                : 'admin.skrining.pdf.karyawan';

            $tgl = $skrining->tanggal_periksa ? $skrining->tanggal_periksa->format('Ymd') : date('Ymd');
            $namaFile = 'EReport-' . ($skrining->pasien->no_antrian ?? 'pasien') . '-' . $tgl . '.pdf';

            $pdf = Pdf::loadView($view, compact('skrining'))
                       ->setPaper('a4', 'portrait')
                       ->setOptions([
                           'dpi'                  => 150,
                           'defaultFont'          => 'sans-serif',
                           'isHtml5ParserEnabled' => true,
                           'isRemoteEnabled'      => false,
                           'fontDir'              => $fontDir,
                           'fontCache'            => $fontDir,
                           'tempDir'              => sys_get_temp_dir(),
                           'chroot'               => realpath(base_path()),
                       ]);

            return $pdf->download($namaFile);
        } catch (\Throwable $e) {
            \Log::error('PDF Generation Error: ' . $e->getMessage(), [
                'exception' => $e,
            ]);

            return back()->with('error', 'Gagal membuat PDF: ' . $e->getMessage());
        }
    }

    /**
     * Fallback loader jika vendor di hosting diupload manual tanpa dump-autoload composer
     */
    private function bootstrapDompdf(): void
    {
        if (!class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            $map = [
                'Barryvdh\\DomPDF\\' => base_path('vendor/barryvdh/laravel-dompdf/src/'),
                'Dompdf\\'           => base_path('vendor/dompdf/dompdf/src/'),
                'FontLib\\'          => base_path('vendor/dompdf/php-font-lib/src/FontLib/'),
                'Svg\\'              => base_path('vendor/dompdf/php-svg-lib/src/Svg/'),
                'Masterminds\\'      => base_path('vendor/masterminds/html5/src/'),
                'Sabberworm\\CSS\\'  => base_path('vendor/sabberworm/php-css-parser/src/'),
            ];

            spl_autoload_register(function ($class) use ($map) {
                foreach ($map as $prefix => $baseDir) {
                    $len = strlen($prefix);
                    if (strncmp($prefix, $class, $len) === 0) {
                        $relativeClass = substr($class, $len);
                        $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';
                        if (file_exists($file)) {
                            require_once $file;
                            return true;
                        }
                    }
                }
                return false;
            });
        }

        if (!app()->bound('dompdf.wrapper')) {
            if (class_exists(\Barryvdh\DomPDF\ServiceProvider::class)) {
                app()->register(\Barryvdh\DomPDF\ServiceProvider::class);
            }
        }

        if (!class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            $cek = [
                'vendor/barryvdh/laravel-dompdf' => base_path('vendor/barryvdh/laravel-dompdf/src/Facade/Pdf.php'),
                'vendor/dompdf/dompdf'           => base_path('vendor/dompdf/dompdf/src/Dompdf.php'),
            ];
            $hilang = [];
            foreach ($cek as $name => $path) {
                if (!file_exists($path)) {
                    $hilang[] = $name;
                }
            }
            if (!empty($hilang)) {
                throw new \Exception("Folder library belum ditemukan di hosting: " . implode(' & ', $hilang) . ". Pastikan Anda telah mengupload folder vendor/barryvdh dan vendor/dompdf ke folder vendor hosting.");
            }
        }
    }
}
