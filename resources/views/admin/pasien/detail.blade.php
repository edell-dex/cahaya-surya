@extends('layouts.admin')
@section('title', 'Detail Pasien — '.$pasien->nama_lengkap)
@section('page-title', 'Detail Pasien')
@section('breadcrumb')
    <a href="{{ route('admin.pasien.index') }}">Data Pasien</a>
    <i class="bi bi-chevron-right" style="font-size:.7rem"></i> Detail
@endsection

@push('styles')
<style>
/* Clean Card Styling for Detail */
.card-clean {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,.03);
    overflow: hidden;
    margin-bottom: 20px;
}
.card-clean-hdr {
    padding: 12px 20px;
    display: flex;
    align-items: center;
    gap: 8px;
    border-radius: 11px 11px 0 0;
}
.card-clean-hdr.blue {
    background: linear-gradient(135deg, #1a3c5e 0%, #2557a7 100%);
    color: #fff;
}
.card-clean-hdr.purple {
    background: linear-gradient(135deg, #7c3aed 0%, #9333ea 100%);
    color: #fff;
}
.card-clean-hdr.green {
    background: linear-gradient(135deg, #16a34a 0%, #22c55e 100%);
    color: #fff;
}
.card-clean-hdr .hdr-title {
    font-size: .92rem;
    font-weight: 700;
    color: #fff;
    margin: 0;
}
.card-clean-hdr i {
    font-size: 1.05rem;
    color: #fff;
}

.info-item {
    padding: 9px 0;
    border-bottom: 1px dashed #f1f5f9;
}
.info-item:last-child {
    border-bottom: none;
}
.info-lbl {
    font-size: .72rem;
    font-weight: 700;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: .04em;
    margin-bottom: 2px;
}
.info-val {
    font-size: .88rem;
    font-weight: 600;
    color: #1e293b;
}
.keluhan-box {
    background: #f8fafc;
    border-left: 3px solid #7c3aed;
    border-radius: 6px;
    padding: 12px 14px;
    font-size: .84rem;
    color: #334155;
    line-height: 1.5;
}
</style>
@endpush

@section('content')
{{-- Action Bar --}}
<div class="d-flex justify-content-between align-items-center mb-4 no-print">
    <a href="{{ route('admin.pasien.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Kembali
    </a>
    <div class="d-flex gap-2">
        @if($pasien->hasilSkrining)
            <a href="{{ route('admin.skrining.show', $pasien->hasilSkrining) }}" class="btn btn-info btn-sm text-white">
                <i class="bi bi-file-medical-fill me-1"></i>Lihat E-Report
            </a>
            <a href="{{ route('admin.skrining.pdf', $pasien->hasilSkrining) }}" class="btn btn-danger btn-sm">
                <i class="bi bi-file-earmark-pdf-fill me-1"></i>Download PDF
            </a>
        @else
            <a href="{{ route('admin.skrining.create', ['pasien_id' => $pasien->id]) }}" class="btn btn-success btn-sm">
                <i class="bi bi-clipboard2-plus-fill me-1"></i>Input Hasil Skrining
            </a>
        @endif
        <button onclick="window.print()" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-printer me-1"></i>Cetak
        </button>
        <a href="{{ route('admin.pasien.edit', $pasien) }}" class="btn btn-warning btn-sm text-white">
            <i class="bi bi-pencil me-1"></i>Edit Data
        </a>
    </div>
</div>

{{-- Top Summary Header --}}
<div class="card-clean mb-4">
    <div class="p-4">
        <div class="row align-items-center g-3">
            <div class="col-md-3 text-center border-end-md">
                <div style="width:72px;height:72px;border-radius:50%;background:linear-gradient(135deg,#1a3c5e,#2557a7);display:flex;align-items:center;justify-content:center;font-size:1.8rem;font-weight:700;color:#fff;margin:0 auto;">
                    {{ strtoupper(substr($pasien->nama_lengkap,0,1)) }}
                </div>
                <div class="mt-2 fw-bold text-dark">{{ $pasien->nama_lengkap }}</div>
                <div class="mt-1"><span class="{{ $pasien->status_badge_class }}">{{ $pasien->status_verifikasi }}</span></div>
            </div>
            <div class="col-md-9">
                <div class="row g-3 ps-md-2">
                    <div class="col-sm-6 col-md-4">
                        <div class="info-lbl">Program Skrining</div>
                        <div class="info-val">
                            @if($pasien->tipe_pendaftaran === 'sekolah')
                            <span class="badge bg-primary"><i class="bi bi-mortarboard-fill me-1"></i>Sekolah (Mata)</span>
                            @else
                            <span class="badge" style="background:#0d9488"><i class="bi bi-building-fill me-1"></i>Perusahaan (Vaskuler)</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="info-lbl">No. Antrian</div>
                        <div class="info-val"><code class="text-primary fw-bold fs-6">{{ $pasien->no_antrian }}</code></div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="info-lbl">Tanggal Daftar</div>
                        <div class="info-val">{{ $pasien->tanggal_daftar_format }}</div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="info-lbl">Institusi / Lembaga</div>
                        <div class="info-val fw-semibold">{{ $pasien->institusi_nama ?? '-' }}</div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="info-lbl">Kelas / Unit / Divisi</div>
                        <div class="info-val">{{ $pasien->kelas_unit ?? ($pasien->kategori_peserta ?? '-') }}</div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="info-lbl">Pemeriksaan / Poli</div>
                        <div class="info-val text-primary">{{ $pasien->poli_tujuan }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- 3 Main Boxes Layout --}}
<div class="row g-4">
    {{-- BOX 1: DATA DIRI PASIEN (LEFT COLUMN) --}}
    <div class="col-lg-6">
        <div class="card-clean h-100 mb-0">
            <div class="card-clean-hdr blue">
                <i class="bi bi-person-fill"></i>
                <h6 class="hdr-title">Data Diri</h6>
            </div>
            <div class="p-4">
                <div class="row g-3">
                    <div class="col-sm-6 info-item">
                        <div class="info-lbl">Nama Lengkap</div>
                        <div class="info-val">{{ $pasien->nama_lengkap }}</div>
                    </div>
                    <div class="col-sm-6 info-item">
                        <div class="info-lbl">Jenis Kelamin</div>
                        <div class="info-val">{{ $pasien->jenis_kelamin }}</div>
                    </div>
                    <div class="col-sm-6 info-item">
                        <div class="info-lbl">NIK / ID Pegawai</div>
                        <div class="info-val">{{ $pasien->nik }}</div>
                    </div>
                    <div class="col-sm-6 info-item">
                        <div class="info-lbl">No. WhatsApp / HP</div>
                        <div class="info-val">{{ $pasien->no_telepon ?? '-' }}</div>
                    </div>
                    <div class="col-sm-6 info-item">
                        <div class="info-lbl">Tempat, Tanggal Lahir</div>
                        <div class="info-val">{{ $pasien->tempat_lahir ?? '-' }}, {{ $pasien->tanggal_lahir ? $pasien->tanggal_lahir->format('d/m/Y') : '-' }}</div>
                    </div>
                    <div class="col-sm-6 info-item">
                        <div class="info-lbl">Usia</div>
                        <div class="info-val">{{ $pasien->usia ? $pasien->usia.' tahun' : '-' }}</div>
                    </div>
                    <div class="col-sm-6 info-item">
                        <div class="info-lbl">Pekerjaan / Jabatan</div>
                        <div class="info-val">{{ $pasien->pekerjaan ?? '-' }}</div>
                    </div>
                    <div class="col-sm-6 info-item">
                        <div class="info-lbl">Pendidikan Terakhir</div>
                        <div class="info-val">{{ $pasien->pendidikan ?? '-' }}</div>
                    </div>
                    <div class="col-12 info-item">
                        <div class="info-lbl">Email (E-Report)</div>
                        <div class="info-val">{{ $pasien->email_peserta ?? '-' }}</div>
                    </div>
                    <div class="col-12 info-item">
                        <div class="info-lbl">Alamat Domisili</div>
                        <div class="info-val">{{ $pasien->alamat ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- RIGHT COLUMN: BOX 2 & BOX 3 --}}
    <div class="col-lg-6 d-flex flex-column gap-4">
        {{-- BOX 2: RIWAYAT KESEHATAN & KELUHAN --}}
        <div class="card-clean mb-0">
            <div class="card-clean-hdr purple">
                <i class="bi bi-file-medical-fill"></i>
                <h6 class="hdr-title">Riwayat & Keluhan</h6>
            </div>
            <div class="p-4">
                <div class="mb-3">
                    <div class="info-lbl mb-2">Riwayat Kesehatan / Penyakit Pribadi</div>
                    @forelse($pasien->riwayat_penyakit_array as $rp)
                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1 me-1 mb-1">
                        <i class="bi bi-dot"></i>{{ $rp }}
                    </span>
                    @empty
                    <span class="text-muted small">Tidak ada riwayat penyakit yang dilaporkan</span>
                    @endforelse
                </div>

                @if(!empty($pasien->riwayat_keluarga_array))
                <div class="mb-3">
                    <div class="info-lbl mb-2">Riwayat Penyakit Keluarga</div>
                    @foreach($pasien->riwayat_keluarga_array as $rk)
                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2 py-1 me-1 mb-1">
                        <i class="bi bi-dot"></i>{{ $rk }}
                    </span>
                    @endforeach
                </div>
                @endif

                <div>
                    <div class="info-lbl mb-2">Keluhan / Gejala Utama</div>
                    @if($pasien->keluhan_utama)
                    <div class="keluhan-box">
                        <i class="bi bi-quote me-1 text-muted"></i>{{ $pasien->keluhan_utama }}
                    </div>
                    @else
                    <span class="text-muted small">Tidak ada keluhan khusus</span>
                    @endif
                </div>
            </div>
        </div>

        {{-- BOX 3: TINDAKAN & VERIFIKASI ADMIN --}}
        <div class="card-clean mb-0 no-print">
            <div class="card-clean-hdr green">
                <i class="bi bi-check2-circle"></i>
                <h6 class="hdr-title">Tindakan Admin</h6>
            </div>
            <div class="p-4">
                <form id="statusForm">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold small text-muted text-uppercase mb-1">Status Verifikasi Pasien</label>
                        <select class="form-select form-select-sm" id="statusVerifikasi">
                            @foreach(['Menunggu','Diverifikasi','Ditolak'] as $s)
                            <option value="{{ $s }}" {{ $pasien->status_verifikasi==$s?'selected':'' }}>{{ $s }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small text-muted text-uppercase mb-1">Catatan Admin</label>
                        <textarea class="form-control form-control-sm" id="catatanAdmin" rows="2" placeholder="Tuliskan catatan verifikasi atau arahan untuk pasien...">{{ $pasien->catatan_admin }}</textarea>
                    </div>
                    <button type="button" class="btn btn-primary w-100 py-2 fw-semibold" onclick="updateStatus()">
                        <i class="bi bi-check-circle-fill me-2"></i>Simpan Status
                    </button>
                </form>
                <div id="statusMsg" class="mt-2"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function updateStatus() {
    const status  = document.getElementById('statusVerifikasi').value;
    const catatan = document.getElementById('catatanAdmin').value;
    const btn = event.target;
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';

    fetch('{{ route("admin.pasien.updateStatus", $pasien) }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ status_verifikasi: status, catatan_admin: catatan })
    })
    .then(r => r.json())
    .then(data => {
        const msg = document.getElementById('statusMsg');
        msg.innerHTML = `<div class="alert alert-${data.success ? 'success' : 'danger'} border-0 py-2 small mt-2">${data.message}</div>`;
        btn.disabled = false;
        btn.innerHTML = '<i class="bi bi-check-circle-fill me-2"></i>Simpan Status';
        if (data.success) setTimeout(() => { msg.innerHTML = ''; }, 3000);
    })
    .catch(() => {
        btn.disabled = false;
        btn.innerHTML = '<i class="bi bi-check-circle-fill me-2"></i>Simpan Status';
        document.getElementById('statusMsg').innerHTML = '<div class="alert alert-danger border-0 py-2 small mt-2">Terjadi kesalahan. Coba lagi.</div>';
    });
}
</script>
@endpush
