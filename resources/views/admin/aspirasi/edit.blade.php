@extends('layouts.app', [
    'namePage' => 'Edit Aspirasi',
    'activePage' => 'admin_aspirasi',
])

@section('title', 'Edit Aspirasi')

@section('content')
<div class="content" style="padding: 20px;">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="text-dark font-weight-bold mb-1">Edit Aspirasi</h2>
            <p class="text-muted">ID: {{ $aspirasi->id_pelaporan }}</p>
        </div>
        <div class="col-md-4 text-right">
            <a href="{{ route('admin.aspirasi.index') }}" class="btn btn-secondary">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Form -->
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Edit Data Aspirasi</h5>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.aspirasi.update', $aspirasi) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="nis" class="form-label">Siswa <span class="text-danger">*</span></label>
                                    <select class="form-control @error('nis') is-invalid @enderror" id="nis" name="nis" required>
                                        @foreach($siswa as $s)
                                            <option value="{{ $s->nis }}" {{ old('nis', $aspirasi->nis) == $s->nis ? 'selected' : '' }}>
                                                {{ $s->nama }} ({{ $s->nis }}) - {{ $s->kelas }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('nis')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="id_kategori" class="form-label">Kategori <span class="text-danger">*</span></label>
                                    <select class="form-control @error('id_kategori') is-invalid @enderror" id="id_kategori" name="id_kategori" required>
                                        @foreach($kategori as $k)
                                            <option value="{{ $k->id_kategori }}" {{ old('id_kategori', $aspirasi->id_kategori) == $k->id_kategori ? 'selected' : '' }}>
                                                {{ $k->ket_kategori }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_kategori')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="lokasi" class="form-label">Lokasi <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('lokasi') is-invalid @enderror" id="lokasi" name="lokasi" placeholder="Contoh: Laboratorium Komputer Lantai 2" value="{{ old('lokasi', $aspirasi->lokasi) }}" required>
                                    @error('lokasi')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="keterangan" class="form-label">Keterangan <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan" rows="4" placeholder="Jelaskan masalah yang ditemukan secara detail..." required>{{ old('keterangan', $aspirasi->keterangan) }}</textarea>
                                    @error('keterangan')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="foto_bukti" class="form-label">Foto Bukti</label>
                                    <input type="file" class="form-control @error('foto_bukti') is-invalid @enderror" id="foto_bukti" name="foto_bukti" accept="image/*">
                                    <small class="form-text text-muted">Format: JPG, JPEG, PNG. Maksimal: 2MB. Kosongkan jika tidak ingin mengubah foto.</small>
                                    
                                    @if($aspirasi->foto_bukti)
                                        <div class="mt-2">
                                            <label class="form-label">Foto Saat Ini:</label>
                                            <div>
                                                <img src="{{ $aspirasi->foto_bukti_url }}" alt="Foto Bukti" class="img-thumbnail" style="max-height: 150px;">
                                            </div>
                                        </div>
                                    @endif
                                    
                                    @error('foto_bukti')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Simpan Perubahan
                                </button>
                                <a href="{{ route('admin.aspirasi.show', $aspirasi) }}" class="btn btn-info ms-2">
                                    <i class="fa fa-eye"></i> Lihat Detail
                                </a>
                                <a href="{{ route('admin.aspirasi.index') }}" class="btn btn-secondary ms-2">
                                    <i class="fa fa-times"></i> Batal
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">Info Aspirasi</h6>
                </div>
                <div class="card-body">
                    <p><strong>Status:</strong> {!! $aspirasi->status_badge !!}</p>
                    <p><strong>Dibuat:</strong> {{ formatTanggalIndonesia($aspirasi->created_at) }}</p>
                    @if($aspirasi->updated_at != $aspirasi->created_at)
                        <p><strong>Diperbarui:</strong> {{ formatTanggalIndonesia($aspirasi->updated_at) }}</p>
                    @endif
                    @if($aspirasi->feedback)
                        <p><strong>Feedback:</strong></p>
                        <div class="alert alert-info">{{ $aspirasi->feedback }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
