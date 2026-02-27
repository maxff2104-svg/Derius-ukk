@extends('layouts.app', [
    'namePage' => 'Buat Aspirasi',
    'activePage' => 'admin_aspirasi',
])

@section('title', 'Buat Aspirasi Baru')

@section('content')
<div class="content" style="padding: 20px;">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="text-dark font-weight-bold mb-1">Buat Aspirasi Baru</h2>
            <p class="text-muted">Tambahkan aspirasi baru atas nama siswa</p>
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
                    <h5 class="card-title mb-0">Form Aspirasi</h5>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.aspirasi.store') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="nis" class="form-label">Siswa <span class="text-danger">*</span></label>
                                    <select class="form-control @error('nis') is-invalid @enderror" id="nis" name="nis" required>
                                        <option value="">-- Pilih Siswa --</option>
                                        @foreach($siswa as $s)
                                            <option value="{{ $s->nis }}" {{ old('nis') == $s->nis ? 'selected' : '' }}>
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
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach($kategori as $k)
                                            <option value="{{ $k->id_kategori }}" {{ old('id_kategori') == $k->id_kategori ? 'selected' : '' }}>
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
                                    <input type="text" class="form-control @error('lokasi') is-invalid @enderror" id="lokasi" name="lokasi" placeholder="Contoh: Laboratorium Komputer Lantai 2" value="{{ old('lokasi') }}" required>
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
                                    <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan" rows="4" placeholder="Jelaskan masalah yang ditemukan secara detail..." required>{{ old('keterangan') }}</textarea>
                                    @error('keterangan')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="foto_bukti" class="form-label">Foto Bukti <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control @error('foto_bukti') is-invalid @enderror" id="foto_bukti" name="foto_bukti" accept="image/*" required>
                                    <small class="form-text text-muted">Format: JPG, JPEG, PNG. Maksimal: 2MB</small>
                                    @error('foto_bukti')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Simpan Aspirasi
                                </button>
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
                    <h6 class="card-title mb-0">Petunjuk</h6>
                </div>
                <div class="card-body">
                    <h6><i class="fa fa-info-circle"></i> Cara Mengisi Form</h6>
                    <ol class="small">
                        <li><strong>Siswa:</strong> Pilih siswa yang membuat aspirasi</li>
                        <li><strong>Kategori:</strong> Pilih jenis sarana yang bermasalah</li>
                        <li><strong>Lokasi:</strong> Sebutkan lokasi pasti masalah</li>
                        <li><strong>Keterangan:</strong> Jelaskan masalah secara detail</li>
                        <li><strong>Foto Bukti:</strong> Upload foto yang menunjukkan masalah</li>
                    </ol>
                    
                    <h6 class="mt-3"><i class="fa fa-lightbulb"></i> Tips</h6>
                    <ul class="small">
                        <li>Ambil foto yang jelas dan fokus pada masalah</li>
                        <li>Jelaskan kapan masalah terjadi</li>
                        <li>Sebutkan dampak dari masalah tersebut</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
