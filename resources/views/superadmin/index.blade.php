@extends('layouts.admin')
@section('title', 'Kelola Admin — Super Admin')
@section('page-title', 'Kelola Pengguna Admin')
@section('breadcrumb') Super Admin / Kelola Admin @endsection

@section('content')
{{-- Stat Cards --}}
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon si-blue"><i class="bi bi-people-fill"></i></div>
            <div><div class="stat-num">{{ $stats['total_admin'] }}</div><div class="stat-lbl">Total Admin</div></div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon si-green"><i class="bi bi-person-check-fill"></i></div>
            <div><div class="stat-num">{{ $stats['admin_aktif'] }}</div><div class="stat-lbl">Admin Aktif</div></div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon si-red"><i class="bi bi-person-x-fill"></i></div>
            <div><div class="stat-num">{{ $stats['admin_nonaktif'] }}</div><div class="stat-lbl">Admin Nonaktif</div></div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon si-teal"><i class="bi bi-clipboard2-pulse-fill"></i></div>
            <div><div class="stat-num">{{ $stats['total_pasien'] }}</div><div class="stat-lbl">Total Pasien Terdaftar</div></div>
        </div>
    </div>
</div>

{{-- Table Card --}}
<div class="tbl-card">
    <div class="tbl-head">
        <div class="tbl-title"><i class="bi bi-shield-lock-fill me-2"></i>Daftar Akun Petugas & Admin</div>
        <div>
            <a href="{{ route('superadmin.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-person-plus-fill me-1"></i>Tambah Admin Baru
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>No. Telepon / HP</th>
                    <th>Role</th>
                    <th>Status Akun</th>
                    <th>Terdaftar Sejak</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($admins as $i => $u)
                <tr>
                    <td class="text-muted">{{ $i + 1 }}</td>
                    <td>
                        <div class="fw-semibold">{{ $u->name }}</div>
                        @if($u->id === auth()->id())
                        <span class="badge bg-secondary" style="font-size:0.65rem">Akun Anda</span>
                        @endif
                    </td>
                    <td><code>{{ $u->email }}</code></td>
                    <td>{{ $u->no_hp ?? '-' }}</td>
                    <td>
                        <span class="badge {{ $u->role === 'superadmin' ? 'bg-info text-dark' : 'bg-primary' }}">
                            {{ strtoupper($u->role) }}
                        </span>
                    </td>
                    <td>
                        <form method="POST" action="{{ route('superadmin.toggleStatus', $u) }}" class="d-inline">
                            @csrf
                            <button type="submit" class="border-0 bg-transparent p-0" title="Klik untuk ubah status">
                                <span class="{{ $u->status === 'aktif' ? 'badge-aktif' : 'badge-nonaktif' }} cursor-pointer">
                                    <i class="bi {{ $u->status === 'aktif' ? 'bi-check-circle' : 'bi-x-circle' }} me-1"></i>
                                    {{ ucfirst($u->status) }}
                                </span>
                            </button>
                        </form>
                    </td>
                    <td class="small text-muted">{{ $u->created_at ? $u->created_at->format('d M Y') : '-' }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('superadmin.edit', $u) }}" class="btn btn-sm btn-warning text-white" title="Edit">
                                <i class="bi bi-pencil-fill"></i>
                            </a>
                            <form method="POST" action="{{ route('superadmin.destroy', $u) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun {{ addslashes($u->name) }}?')">
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
                    <td colspan="8" class="text-center py-5 text-muted">
                        <i class="bi bi-people display-4 d-block mb-3"></i>
                        Belum ada akun admin tambahan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
