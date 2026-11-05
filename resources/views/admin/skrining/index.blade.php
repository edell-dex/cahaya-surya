@extends('layouts.admin')
@section('title', 'Hasil Skrining')
@section('page-title', 'Hasil Skrining Pasien')
@section('breadcrumb')
    <span>Hasil Skrining</span>
@endsection

@section('content')
{{-- Quick Entry Card with Auto-Fill by Kode Antrian --}}
<div class="card border-0 shadow-sm mb-4" style="border-radius:14px;overflow:hidden;">
    <div style="background:linear-gradient(135deg,#0f766e,#0d9488);color:#fff;padding:16px 20px;" class="d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-qr-code-scan fs-5"></i>
            <span class="fw-bold">Input Hasil Skrining Baru (Auto-Fill Pasien)</span>
        </div>
        <span class="badge bg-white text-dark small"><i class="bi bi-person-check me-1"></i>Staff: {{ auth()->user()->name }}</span>
    </div>
    <div class="card-body p-4">
        <div class="row align-items-start g-3">
            <div class="col-lg-6">
                <label class="form-label fw-semibold small">Masukkan Kode Antrian / Unik Pasien <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="bi bi-upc-scan text-teal"></i></span>
                    <input type="text" class="form-control form-control-lg" id="inputKode" placeholder="Contoh: SEK-20261019-001 / CORP-20261019-001" autocomplete="off" style="text-transform:uppercase;letter-spacing:1px;font-weight:600;">
                    <button class="btn btn-primary px-4 fw-semibold" id="btnCari" type="button">
                        <i class="bi bi-search me-1"></i>Cari Pasien
                    </button>
                </div>
                <div class="form-text small text-muted mt-2">
                    <i class="bi bi-lightbulb me-1"></i>Ketik atau scan kode antrian pasien, data identitas akan otomatis terisi dan template formulir yang sesuai (Siswa atau Karyawan) akan otomatis terbuka.
                </div>
                <div id="cariInfo" class="mt-2"></div>
            </div>

            <div class="col-lg-6" id="pasienPreviewBox" style="display:none;">
                <div class="border rounded-3 p-3 bg-light shadow-sm" id="pasienPreview">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div style="width:48px;height:48px;border-radius:50%;background:linear-gradient(135deg,#1a3c5e,#2557a7);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:1.2rem;" id="prevAvatar"></div>
                        <div class="flex-grow-1">
                            <div class="fw-bold fs-6 text-dark" id="prevNama"></div>
                            <div class="text-muted small"><code class="text-primary fw-bold" id="prevKode"></code> &bull; NIK: <span id="prevNik"></span></div>
                        </div>
                        <span class="badge" id="prevTipeBadge" style="font-size:0.8rem;padding:6px 12px;"></span>
                    </div>
                    <div class="row g-2 small border-top pt-2">
                        <div class="col-6"><span class="text-muted">Institusi/Perusahaan:</span> <strong id="prevInstitusi" class="d-block text-truncate"></strong></div>
                        <div class="col-6"><span class="text-muted">Kelas/Divisi:</span> <strong id="prevKelas" class="d-block text-truncate"></strong></div>
                        <div class="col-6"><span class="text-muted">Usia & Jenis Kelamin:</span> <strong id="prevUsia" class="d-block"></strong></div>
                        <div class="col-6"><span class="text-muted">Template Form:</span> <strong id="prevTemplate" class="text-success d-block"></strong></div>
                    </div>
                    <a href="#" id="btnInputHasil" class="btn btn-success w-100 mt-3 fw-bold py-2 shadow-sm">
                        <i class="bi bi-clipboard2-check me-2"></i>Buka Form Input Skrining
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Riwayat Hasil Skrining Table --}}
<div class="tbl-card">
    <div class="tbl-head">
        <div class="tbl-title"><i class="bi bi-clock-history me-1 text-teal"></i>Riwayat Hasil Skrining Tersimpan</div>
        <form method="GET" class="d-flex gap-2 flex-wrap">
            <input type="text" class="form-control form-control-sm" name="search" value="{{ request('search') }}" placeholder="Cari nama / kode antrian..." style="max-width:220px;">
            <select name="tipe" class="form-select form-select-sm" style="max-width:150px;">
                <option value="">Semua Tipe</option>
                <option value="sekolah" {{ request('tipe')=='sekolah'?'selected':'' }}>Sekolah (Siswa)</option>
                <option value="perusahaan" {{ request('tipe')=='perusahaan'?'selected':'' }}>Perusahaan (Karyawan)</option>
            </select>
            <button class="btn btn-primary btn-sm"><i class="bi bi-search"></i></button>
            <a href="{{ route('admin.skrining.index') }}" class="btn btn-outline-secondary btn-sm">Reset</a>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th style="width:50px;">#</th>
                    <th>Kode Antrian</th>
                    <th>Nama Pasien</th>
                    <th>Kategori / Lembaga</th>
                    <th>Tgl Periksa</th>
                    <th>Diisi Oleh Staff</th>
                    <th style="width:130px;" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($hasilList as $h)
                <tr>
                    <td class="text-muted small">{{ $hasilList->firstItem() + $loop->index }}</td>
                    <td><code class="fw-bold text-primary">{{ $h->pasien->no_antrian ?? '-' }}</code></td>
                    <td>
                        <div class="fw-semibold text-dark">{{ $h->pasien->nama_lengkap ?? '-' }}</div>
                        <small class="text-muted">NIK: {{ $h->pasien->nik ?? '-' }}</small>
                    </td>
                    <td>
                        @if($h->tipe === 'sekolah')
                            <span class="badge bg-primary mb-1"><i class="bi bi-mortarboard-fill me-1"></i>Siswa (Mata)</span>
                        @else
                            <span class="badge" style="background:#0d9488"><i class="bi bi-building-fill me-1"></i>Karyawan (Vaskuler)</span>
                        @endif
                        <div class="small text-muted text-truncate" style="max-width:200px;">{{ $h->pasien->institusi_nama ?? '-' }}</div>
                    </td>
                    <td>
                        <div class="fw-medium">{{ $h->tanggal_periksa ? $h->tanggal_periksa->format('d/m/Y') : '-' }}</div>
                        <small class="text-muted">{{ $h->created_at ? $h->created_at->format('H:i') : '' }} WIB</small>
                    </td>
                    <td>
                        <div class="fw-medium text-dark"><i class="bi bi-person-fill text-secondary me-1"></i>{{ $h->user->name ?? '-' }}</div>
                        <small class="text-muted">{{ $h->user->email ?? '-' }}</small>
                    </td>
                    <td class="text-center">
                        <div class="btn-group btn-group-sm">
                            <a href="{{ route('admin.skrining.show', $h) }}" class="btn btn-outline-primary" title="Lihat Form Lengkap">
                                <i class="bi bi-eye-fill"></i>
                            </a>
                            <a href="{{ route('admin.skrining.pdf', $h) }}" class="btn btn-outline-danger" title="Download PDF E-Report">
                                <i class="bi bi-file-earmark-pdf-fill"></i> PDF
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-5">
                        <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary opacity-50"></i>
                        <div class="fw-semibold">Belum ada data hasil skrining.</div>
                        <small class="text-muted">Gunakan form di atas untuk memasukkan hasil skrining dengan kode antrian pasien.</small>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($hasilList->hasPages())
    <div class="p-3 border-top">{{ $hasilList->links() }}</div>
    @endif
</div>
@endsection

@push('scripts')
<script>
const CARI_URL   = '{{ route("admin.skrining.cariPasien") }}';
const CREATE_URL = '{{ route("admin.skrining.create") }}';
const CSRF       = '{{ csrf_token() }}';

const inputKode     = document.getElementById('inputKode');
const btnCari       = document.getElementById('btnCari');
const cariInfo      = document.getElementById('cariInfo');
const previewBox    = document.getElementById('pasienPreviewBox');
const btnInputHasil = document.getElementById('btnInputHasil');

function cariPasien() {
    const kode = inputKode.value.trim().toUpperCase();
    if (!kode) {
        cariInfo.innerHTML = '<div class="alert alert-warning border-0 py-2 small mt-2"><i class="bi bi-exclamation-triangle me-1"></i>Silakan masukkan kode antrian pasien.</div>';
        return;
    }

    btnCari.disabled = true;
    btnCari.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Mencari...';
    cariInfo.innerHTML = '';
    previewBox.style.display = 'none';

    fetch(CARI_URL + '?no_antrian=' + encodeURIComponent(kode), {
        headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' }
    })
    .then(r => r.json())
    .then(data => {
        btnCari.disabled = false;
        btnCari.innerHTML = '<i class="bi bi-search me-1"></i>Cari Pasien';

        if (!data.success) {
            cariInfo.innerHTML = `<div class="alert alert-danger border-0 py-2 small mt-2"><i class="bi bi-x-circle me-1"></i>${data.message}</div>`;
            return;
        }

        const p = data.pasien;
        document.getElementById('prevAvatar').textContent    = p.nama_lengkap.charAt(0).toUpperCase();
        document.getElementById('prevNama').textContent       = p.nama_lengkap;
        document.getElementById('prevKode').textContent       = p.no_antrian;
        document.getElementById('prevNik').textContent        = p.nik;
        document.getElementById('prevInstitusi').textContent  = p.institusi;
        document.getElementById('prevKelas').textContent      = p.kelas_unit;
        document.getElementById('prevUsia').textContent       = (p.usia || '-') + ' / ' + (p.jenis_kelamin || '-');
        document.getElementById('prevTemplate').textContent   = p.tipe === 'sekolah' ? 'Template Siswa.pdf (Mata)' : 'Template Karyawan.pdf (Vaskuler)';

        const badge = document.getElementById('prevTipeBadge');
        if (p.tipe === 'sekolah') {
            badge.textContent = 'Siswa (Mata)';
            badge.className = 'badge bg-primary';
        } else {
            badge.textContent = 'Karyawan (Vaskuler)';
            badge.className = 'badge';
            badge.style.backgroundColor = '#0d9488';
            badge.style.color = '#fff';
        }

        btnInputHasil.href = CREATE_URL + '?pasien_id=' + p.id;
        previewBox.style.display = 'block';
    })
    .catch(() => {
        btnCari.disabled = false;
        btnCari.innerHTML = '<i class="bi bi-search me-1"></i>Cari Pasien';
        cariInfo.innerHTML = '<div class="alert alert-danger border-0 py-2 small mt-2"><i class="bi bi-exclamation-circle me-1"></i>Gagal menghubungi server. Silakan coba lagi.</div>';
    });
}

btnCari.addEventListener('click', cariPasien);
inputKode.addEventListener('keydown', e => { if (e.key === 'Enter') cariPasien(); });
inputKode.addEventListener('input', () => { inputKode.value = inputKode.value.toUpperCase(); });
</script>
@endpush
