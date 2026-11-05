@extends('layouts.admin')
@section('title', 'Data Pasien')
@section('page-title', 'Data Pasien')
@section('breadcrumb') Data Pasien @endsection

@section('content')
{{-- Stat Cards --}}
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <a href="{{ route('admin.pasien.index', ['tanggal' => date('Y-m-d')]) }}" class="text-decoration-none text-reset d-block" title="Klik untuk filter pasien hari ini">
            <div class="stat-card position-relative" style="{{ request('tanggal') == date('Y-m-d') ? 'box-shadow: 0 0 0 2px #0d6efd, 0 4px 12px rgba(13,110,253,0.12);' : '' }}">
                <div class="stat-icon si-blue"><i class="bi bi-calendar-day-fill"></i></div>
                <div>
                    <div class="stat-num">{{ $stats['total_hari_ini'] }}</div>
                    <div class="stat-lbl">Pasien Hari Ini</div>
                </div>
                @if(request('tanggal') == date('Y-m-d'))
                    <span class="badge bg-primary text-white position-absolute top-0 end-0 m-2" style="font-size:0.6rem">Aktif</span>
                @endif
            </div>
        </a>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon si-teal"><i class="bi bi-calendar-month-fill"></i></div>
            <div><div class="stat-num">{{ $stats['total_bulan_ini'] }}</div><div class="stat-lbl">Pasien Bulan Ini</div></div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <a href="{{ route('admin.pasien.index') }}" class="text-decoration-none text-reset d-block" title="Lihat semua pasien">
            <div class="stat-card position-relative" style="{{ !request()->hasAny(['search','tipe','status','poli','tanggal']) ? 'box-shadow: 0 0 0 2px #16a34a, 0 4px 12px rgba(22,163,74,0.12);' : '' }}">
                <div class="stat-icon si-green"><i class="bi bi-people-fill"></i></div>
                <div><div class="stat-num">{{ $stats['total_all'] }}</div><div class="stat-lbl">Total Pasien</div></div>
            </div>
        </a>
    </div>
    <div class="col-sm-6 col-xl-3">
        <a href="{{ route('admin.pasien.index', ['status' => 'Menunggu']) }}" class="text-decoration-none text-reset d-block" title="Klik untuk filter menunggu verifikasi">
            <div class="stat-card position-relative" style="{{ request('status') == 'Menunggu' ? 'box-shadow: 0 0 0 2px #d97706, 0 4px 12px rgba(217,119,6,0.12);' : '' }}">
                <div class="stat-icon si-yellow"><i class="bi bi-hourglass-split"></i></div>
                <div><div class="stat-num">{{ $stats['menunggu'] }}</div><div class="stat-lbl">Menunggu Verifikasi</div></div>
                @if(request('status') == 'Menunggu')
                    <span class="badge bg-warning text-dark position-absolute top-0 end-0 m-2" style="font-size:0.6rem">Aktif</span>
                @endif
            </div>
        </a>
    </div>
</div>

{{-- Table Card --}}
<div class="tbl-card">
    {{-- Card Header: Judul & Action Buttons --}}
    <div class="tbl-head d-flex justify-content-between align-items-center flex-wrap gap-2 py-3 px-3">
        <div class="d-flex align-items-center gap-2">
            <div class="tbl-title mb-0"><i class="bi bi-clipboard2-pulse me-2"></i>Daftar Pasien</div>
            <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-2 py-1">
                {{ $pasiens->total() }} Pasien
            </span>
        </div>

        {{-- Action: Download Excel --}}
        <div class="btn-group shadow-sm">
            <a href="{{ route('admin.pasien.export', array_merge(request()->query(), ['format' => 'xlsx'])) }}" class="btn btn-success btn-sm px-3 d-inline-flex align-items-center gap-2" title="Download data pasien (sesuai filter aktif) ke file Excel">
                <i class="bi bi-file-earmark-excel-fill"></i>
                <span class="fw-medium">Download Excel</span>
            </a>
            <button type="button" class="btn btn-success btn-sm dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false" title="Pilihan format ekspor">
                <span class="visually-hidden">Toggle Format</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 py-2">
                <li>
                    <a class="dropdown-item small py-2 d-flex align-items-center gap-2" href="{{ route('admin.pasien.export', array_merge(request()->query(), ['format' => 'xlsx'])) }}">
                        <i class="bi bi-file-earmark-excel-fill text-success fs-6"></i>
                        <div>
                            <div class="fw-semibold">Microsoft Excel (.xlsx)</div>
                            <div class="text-muted" style="font-size:0.75rem">Format standar spreadsheet</div>
                        </div>
                    </a>
                </li>
                <li><hr class="dropdown-divider my-1"></li>
                <li>
                    <a class="dropdown-item small py-2 d-flex align-items-center gap-2" href="{{ route('admin.pasien.export', array_merge(request()->query(), ['format' => 'csv'])) }}">
                        <i class="bi bi-filetype-csv text-secondary fs-6"></i>
                        <div>
                            <div class="fw-semibold">File CSV (.csv)</div>
                            <div class="text-muted" style="font-size:0.75rem">Format teks pemisah titik-koma (UTF-8)</div>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    {{-- Filter Toolbar: Form Filter Rapi Terpisah --}}
    <div class="p-3 border-bottom bg-light bg-opacity-50">
        <form method="GET" action="{{ route('admin.pasien.index') }}" class="row g-2 align-items-center">
            <div class="col-12 col-md-4 col-xl-3">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-white text-muted border-end-0"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control border-start-0" name="search" value="{{ request('search') }}" placeholder="Cari nama, NIK, antrian...">
                </div>
            </div>
            <div class="col-6 col-md-3 col-xl-2">
                <select class="form-select form-select-sm" name="tipe">
                    <option value="">Semua Program</option>
                    <option value="sekolah" {{ request('tipe')=='sekolah'?'selected':'' }}>Sekolah</option>
                    <option value="perusahaan" {{ request('tipe')=='perusahaan'?'selected':'' }}>Perusahaan</option>
                </select>
            </div>
            <div class="col-6 col-md-3 col-xl-2">
                <select class="form-select form-select-sm" name="status">
                    <option value="">Semua Status</option>
                    <option value="Menunggu" {{ request('status')=='Menunggu'?'selected':'' }}>Menunggu</option>
                    <option value="Diverifikasi" {{ request('status')=='Diverifikasi'?'selected':'' }}>Diverifikasi</option>
                    <option value="Ditolak" {{ request('status')=='Ditolak'?'selected':'' }}>Ditolak</option>
                </select>
            </div>
            <div class="col-6 col-md-3 col-xl-2">
                <input type="date" class="form-control form-control-sm" name="tanggal" value="{{ request('tanggal') }}" title="Filter Tanggal Daftar">
            </div>
            <div class="col-6 col-md-3 col-xl-3 d-flex gap-2">
                <button class="btn btn-primary btn-sm px-3 flex-fill flex-md-grow-0" type="submit">
                    <i class="bi bi-funnel-fill me-1"></i>Filter
                </button>
                @if(request()->hasAny(['search','tipe','status','poli','tanggal']))
                <a href="{{ route('admin.pasien.index') }}" class="btn btn-outline-secondary btn-sm px-3" title="Reset filter">
                    <i class="bi bi-arrow-counterclockwise me-1"></i>Reset
                </a>
                @endif
            </div>
        </form>

        {{-- Strip Keterangan Filter Aktif --}}
        @if(request()->hasAny(['search','tipe','status','poli','tanggal']))
        <div class="d-flex align-items-center gap-2 flex-wrap mt-2 pt-2 border-top">
            <small class="text-muted fw-semibold"><i class="bi bi-funnel me-1"></i>Filter Aktif:</small>
            @if(request('tanggal') == date('Y-m-d'))
                <span class="badge bg-primary-subtle text-primary border border-primary-subtle py-1 px-2">
                    <i class="bi bi-calendar-check me-1"></i>Hari Ini ({{ date('d/m/Y') }})
                </span>
            @elseif(request('tanggal'))
                <span class="badge bg-secondary-subtle text-secondary border py-1 px-2">
                    <i class="bi bi-calendar-event me-1"></i>{{ \Carbon\Carbon::parse(request('tanggal'))->format('d/m/Y') }}
                </span>
            @endif

            @if(request('status'))
                <span class="badge bg-warning-subtle text-warning-emphasis border py-1 px-2">
                    Status: {{ request('status') }}
                </span>
            @endif

            @if(request('tipe'))
                <span class="badge bg-info-subtle text-info-emphasis border py-1 px-2">
                    Program: {{ ucfirst(request('tipe')) }}
                </span>
            @endif

            @if(request('search'))
                <span class="badge bg-white text-dark border py-1 px-2">
                    "{{ request('search') }}"
                </span>
            @endif

            <small class="text-success fw-medium ms-auto">
                <i class="bi bi-check-circle-fill me-1"></i>{{ $pasiens->total() }} data terpilih untuk di-download
            </small>
        </div>
        @endif
    </div>

    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>No. Antrian</th>
                    <th>Program</th>
                    <th>Nama Pasien</th>
                    <th>Institusi / Unit</th>
                    <th>NIK</th>
                    <th>Pemeriksaan</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pasiens as $i => $p)
                <tr>
                    <td class="text-muted">{{ $pasiens->firstItem() + $i }}</td>
                    <td><code class="text-primary fw-bold">{{ $p->no_antrian }}</code></td>
                    <td>
                        @if($p->tipe_pendaftaran === 'sekolah')
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle" style="font-size:0.7rem">
                            <i class="bi bi-mortarboard-fill me-1"></i>Sekolah
                        </span>
                        @else
                        <span class="badge text-teal border" style="background:#ccfbf1;color:#0f766e;border-color:#14b8a6;font-size:0.7rem">
                            <i class="bi bi-building-fill me-1"></i>Perusahaan
                        </span>
                        @endif
                    </td>
                    <td>
                        <div class="fw-semibold">{{ $p->nama_lengkap }}</div>
                        <small class="text-muted">{{ $p->no_telepon }}</small>
                    </td>
                    <td>
                        <div class="small fw-medium">{{ $p->institusi_nama ?? '-' }}</div>
                        <small class="text-muted">{{ $p->kelas_unit ?? ($p->kategori_peserta ?? '') }}</small>
                    </td>
                    <td class="text-muted small">{{ $p->nik }}</td>
                    <td><span class="small">{{ $p->poli_tujuan }}</span></td>
                    <td>
                        <span class="{{ $p->status_badge_class }} status-badge">{{ $p->status_verifikasi }}</span>
                    </td>
                    <td class="small text-muted">{{ $p->tanggal_daftar_format }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.skrining.create', ['pasien_id' => $p->id]) }}" class="btn btn-sm btn-success text-white" title="Input Hasil Skrining">
                                <i class="bi bi-clipboard2-pulse-fill"></i>
                            </a>
                            <a href="{{ route('admin.pasien.show', $p) }}" class="btn btn-sm btn-info text-white" title="Detail">
                                <i class="bi bi-eye-fill"></i>
                            </a>
                            <a href="{{ route('admin.pasien.edit', $p) }}" class="btn btn-sm btn-warning text-white" title="Edit">
                                <i class="bi bi-pencil-fill"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.pasien.destroy', $p) }}" onsubmit="return confirm('Yakin hapus data pasien {{ addslashes($p->nama_lengkap) }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-5 text-muted">
                        <i class="bi bi-inbox display-4 d-block mb-3"></i>
                        Tidak ada data pasien ditemukan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($pasiens->hasPages())
    <div class="px-3 py-3 border-top d-flex justify-content-between align-items-center">
        <div class="small text-muted">
            Menampilkan {{ $pasiens->firstItem() ?? 0 }} - {{ $pasiens->lastItem() ?? 0 }} dari {{ $pasiens->total() }} data
        </div>
        <div>
            {{ $pasiens->links('pagination::bootstrap-5') }}
        </div>
    </div>
    @endif
</div>
@endsection
