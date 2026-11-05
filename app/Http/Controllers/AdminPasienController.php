<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Services\SimpleXlsxExporter;
use Illuminate\Http\Request;

class AdminPasienController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin,superadmin']);
    }

    /**
     * Query builder dengan filter pencarian dan tanggal/status/program
     */
    private function buildFilteredQuery(Request $request)
    {
        $query = Pasien::query();

        // Search
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%")
                  ->orWhere('no_antrian', 'like', "%{$search}%")
                  ->orWhere('no_telepon', 'like', "%{$search}%")
                  ->orWhere('institusi_nama', 'like', "%{$search}%");
            });
        }

        // Filter tipe (sekolah / perusahaan)
        if ($tipe = $request->get('tipe')) {
            $query->where('tipe_pendaftaran', $tipe);
        }

        // Filter status
        if ($status = $request->get('status')) {
            $query->where('status_verifikasi', $status);
        }

        // Filter poli
        if ($poli = $request->get('poli')) {
            $query->where('poli_tujuan', $poli);
        }

        // Filter tanggal
        if ($tanggal = $request->get('tanggal')) {
            $query->whereDate('tanggal_daftar', $tanggal);
        }

        return $query;
    }

    // Daftar semua pasien
    public function index(Request $request)
    {
        $query = $this->buildFilteredQuery($request);

        $pasiens = $query->latest()->paginate(10)->withQueryString();

        // Stats
        $stats = [
            'total_hari_ini'   => Pasien::whereDate('tanggal_daftar', today())->count(),
            'total_bulan_ini'  => Pasien::whereMonth('tanggal_daftar', now()->month)->whereYear('tanggal_daftar', now()->year)->count(),
            'total_all'        => Pasien::count(),
            'menunggu'         => Pasien::where('status_verifikasi', 'Menunggu')->count(),
        ];

        return view('admin.pasien.index', compact('pasiens', 'stats'));
    }

    /**
     * Export data pasien sesuai filter aktif ke Excel (.xlsx) atau CSV
     */
    public function export(Request $request)
    {
        $query = $this->buildFilteredQuery($request);
        $pasiens = $query->orderBy('tanggal_daftar', 'desc')->get();

        $headers = [
            'No',
            'No. Antrian',
            'Tanggal Daftar',
            'Program',
            'Nama Lengkap',
            'NIK',
            'Tempat, Tanggal Lahir',
            'Jenis Kelamin',
            'No. HP / WhatsApp',
            'Email',
            'Institusi / Perusahaan',
            'Kelas / Unit / Kategori',
            'Pemeriksaan / Poli',
            'Status Verifikasi',
            'Catatan Admin',
        ];

        $columnWidths = [
            6,   // No
            16,  // No Antrian
            16,  // Tanggal
            14,  // Program
            26,  // Nama
            20,  // NIK
            24,  // TTL
            15,  // JK
            18,  // No HP
            22,  // Email
            25,  // Institusi
            22,  // Kelas/Unit
            22,  // Poli
            18,  // Status
            25,  // Catatan
        ];

        $rows = [];
        foreach ($pasiens as $i => $p) {
            $ttl = trim(($p->tempat_lahir ?? '') . ($p->tanggal_lahir ? ', ' . $p->tanggal_lahir->format('d/m/Y') : ''));
            $rows[] = [
                $i + 1,
                $p->no_antrian,
                $p->tanggal_daftar ? $p->tanggal_daftar->format('d/m/Y') : '-',
                ucfirst($p->tipe_pendaftaran ?? '-'),
                $p->nama_lengkap,
                "'" . $p->nik, // Prefix quote to ensure Excel preserves leading zeroes and 16-digit string
                $ttl ?: '-',
                $p->jenis_kelamin,
                $p->no_telepon,
                $p->email_peserta ?? '-',
                $p->institusi_nama ?? '-',
                $p->kelas_unit ?? ($p->kategori_peserta ?? '-'),
                $p->poli_tujuan,
                $p->status_verifikasi,
                $p->catatan_admin ?? '-',
            ];
        }

        // Tentukan nama file yang informatif berdasarkan filter
        $fileParts = ['data-pasien'];
        if ($tgl = $request->get('tanggal')) {
            $fileParts[] = $tgl;
        } elseif ($request->get('search')) {
            $fileParts[] = 'cari';
        }
        if ($st = $request->get('status')) {
            $fileParts[] = strtolower($st);
        }
        if ($tp = $request->get('tipe')) {
            $fileParts[] = $tp;
        }
        $fileParts[] = date('Ymd_His');
        $filename = implode('_', $fileParts);

        if ($request->get('format') === 'csv') {
            return SimpleXlsxExporter::downloadCsv($filename . '.csv', $headers, $rows);
        }

        return SimpleXlsxExporter::download($filename . '.xlsx', $headers, $rows, $columnWidths);
    }

    // Detail pasien
    public function show(Pasien $pasien)
    {
        return view('admin.pasien.detail', compact('pasien'));
    }

    // Form edit
    public function edit(Pasien $pasien)
    {
        return view('admin.pasien.edit', compact('pasien'));
    }

    // Update pasien
    public function update(Request $request, Pasien $pasien)
    {
        $validated = $request->validate([
            'nama_lengkap'   => 'required|string|max:150',
            'nik'            => 'required|digits:16',
            'tempat_lahir'   => 'nullable|string|max:100',
            'tanggal_lahir'  => 'nullable|date',
            'jenis_kelamin'  => 'required|in:Laki-laki,Perempuan',
            'no_telepon'     => 'required|string|max:20',
            'email_peserta'  => 'nullable|email|max:100',
            'institusi_nama' => 'nullable|string|max:150',
            'kelas_unit'     => 'nullable|string|max:100',
            'pekerjaan'      => 'nullable|string|max:100',
            'pendidikan'     => 'nullable|string',
            'alamat'         => 'nullable|string',
        ]);

        $pasien->update($validated);

        return redirect()->route('admin.pasien.index')
                         ->with('success', 'Data pasien berhasil diperbarui.');
    }

    // Update hanya status verifikasi (AJAX/quick action)
    public function updateStatus(Request $request, Pasien $pasien)
    {
        $request->validate([
            'status_verifikasi' => 'required|in:Menunggu,Diverifikasi,Ditolak',
            'catatan_admin'     => 'nullable|string',
        ]);

        $pasien->update([
            'status_verifikasi' => $request->status_verifikasi,
            'catatan_admin'     => $request->catatan_admin,
        ]);

        return response()->json(['success' => true, 'message' => 'Status berhasil diperbarui.']);
    }

    // Hapus pasien
    public function destroy(Pasien $pasien)
    {
        $pasien->delete();
        return redirect()->route('admin.pasien.index')
                         ->with('success', 'Data pasien berhasil dihapus.');
    }
}
