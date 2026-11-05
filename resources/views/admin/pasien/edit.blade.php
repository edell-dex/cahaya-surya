@extends('layouts.admin')
@section('title', 'Edit Pasien — '.$pasien->nama_lengkap)
@section('page-title', 'Edit Data Pasien')
@section('breadcrumb')
    <a href="{{ route('admin.pasien.index') }}">Data Pasien</a>
    <i class="bi bi-chevron-right" style="font-size:.7rem"></i> Edit
@endsection

@section('content')
<div class="mb-4 no-print">
    <a href="{{ route('admin.pasien.show', $pasien) }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Kembali ke Detail
    </a>
</div>

<form method="POST" action="{{ route('admin.pasien.update', $pasien) }}">
    @csrf @method('PUT')

    {{-- Data Diri --}}
    <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-hdr-blue"><i class="bi bi-person-fill me-2"></i>Data Diri Pasien</div>
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label required">Nama Lengkap</label>
                    <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" name="nama_lengkap" value="{{ old('nama_lengkap', $pasien->nama_lengkap) }}" required>
                    @error('nama_lengkap')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label required">NIK</label>
                    <input type="text" class="form-control @error('nik') is-invalid @enderror" name="nik" value="{{ old('nik', $pasien->nik) }}" maxlength="16" required>
                    @error('nik')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Tempat Lahir</label>
                    <input type="text" class="form-control" name="tempat_lahir" value="{{ old('tempat_lahir', $pasien->tempat_lahir) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Tanggal Lahir</label>
                    <input type="date" class="form-control" name="tanggal_lahir" value="{{ old('tanggal_lahir', $pasien->tanggal_lahir?->format('Y-m-d')) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label required">Jenis Kelamin</label>
                    <select class="form-select" name="jenis_kelamin" required>
                        <option value="Laki-laki" {{ old('jenis_kelamin',$pasien->jenis_kelamin)=='Laki-laki'?'selected':'' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('jenis_kelamin',$pasien->jenis_kelamin)=='Perempuan'?'selected':'' }}>Perempuan</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">No. Telepon</label>
                    <input type="text" class="form-control" name="no_telepon" value="{{ old('no_telepon', $pasien->no_telepon) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Institusi / Perusahaan / Sekolah</label>
                    <input type="text" class="form-control" name="institusi_nama" value="{{ old('institusi_nama', $pasien->institusi_nama) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Kelas / Divisi / Unit</label>
                    <input type="text" class="form-control" name="kelas_unit" value="{{ old('kelas_unit', $pasien->kelas_unit) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Email E-Report</label>
                    <input type="email" class="form-control" name="email_peserta" value="{{ old('email_peserta', $pasien->email_peserta) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Pendidikan Terakhir</label>
                    <select class="form-select" name="pendidikan">
                        @foreach(['Tidak Sekolah','SD','SMP','SMA/SMK','D1/D2/D3','S1','S2/S3'] as $p)
                        <option value="{{ $p }}" {{ old('pendidikan',$pasien->pendidikan)==$p?'selected':'' }}>{{ $p }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Pekerjaan</label>
                    <input type="text" class="form-control" name="pekerjaan" value="{{ old('pekerjaan', $pasien->pekerjaan) }}">
                </div>
                <div class="col-12">
                    <label class="form-label">Alamat Lengkap</label>
                    <textarea class="form-control" name="alamat" rows="2">{{ old('alamat', $pasien->alamat) }}</textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between">
        <a href="{{ route('admin.pasien.show', $pasien) }}" class="btn btn-outline-secondary px-4">
            <i class="bi bi-x me-1"></i>Batal
        </a>
        <button type="submit" class="btn btn-primary px-5">
            <i class="bi bi-save me-1"></i>Simpan Perubahan
        </button>
    </div>
</form>
@endsection
