@extends('layouts.app', [
    'namePage' => 'Edit Aspirasi',
    'activePage' => 'siswa_aspirasi',
])

@section('content')
<div class="content" style="padding-top: 80px;">
    <div class="container-fluid">

        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-md-8">
                <h1 class="text-dark font-weight-bold mb-1">Edit Aspirasi</h1>
                <p class="text-muted">Perbarui aspirasi Anda yang masih menunggu proses</p>
            </div>
            <div class="col-md-4 text-right d-flex align-items-center justify-content-end">
                <a href="{{ route('siswa.aspirasi.index') }}" class="btn btn-secondary">
                    <i class="now-ui-icons arrows-1_minimal-left"></i> Kembali
                </a>
            </div>
        </div>

        <!-- Edit Form Card -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    Edit Aspirasi #{{ $aspirasi->id_pelaporan }}
                </h5>
                <small class="text-muted">
                    Dibuat pada: {{ formatTanggalIndonesia($aspirasi->created_at) }}
                </small>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('siswa.aspirasi.update', $aspirasi) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="id_kategori" class="font-weight-bold">
                                Kategori <span class="text-danger">*</span>
                            </label>
                            <select name="id_kategori" id="id_kategori"
                                class="form-control form-control-lg @error('id_kategori') is-invalid @enderror"
                                required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($kategori as $k)
                                    <option value="{{ $k->id_kategori }}"
                                        {{ old('id_kategori', $aspirasi->id_kategori) == $k->id_kategori ? 'selected' : '' }}>
                                        {{ $k->ket_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_kategori')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-4">
                            <label for="lokasi" class="font-weight-bold">
                                Lokasi <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="lokasi" id="lokasi"
                                class="form-control form-control-lg @error('lokasi') is-invalid @enderror"
                                placeholder="Contoh: Toilet lantai 2, Lab Komputer"
                                value="{{ old('lokasi', $aspirasi->lokasi) }}" required>
                            @error('lokasi')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="keterangan" class="font-weight-bold">
                            Keterangan/Deskripsi <span class="text-danger">*</span>
                        </label>
                        <textarea name="keterangan" id="keterangan"
                            class="form-control form-control-lg @error('keterangan') is-invalid @enderror"
                            rows="5"
                            placeholder="Jelaskan detail masalah atau aspirasi Anda dengan lengkap..."
                            required>{{ old('keterangan', $aspirasi->keterangan) }}</textarea>
                        <small class="form-text text-muted mt-1 d-block">Semakin detail, semakin cepat kami respons</small>
                        @error('keterangan')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Foto Bukti Section -->
                    <div class="mb-4">
                        <label class="font-weight-bold d-block">Foto Bukti (Opsional)</label>
                        <small class="form-text text-muted d-block mb-2">
                            Upload foto baru untuk mengganti foto lama. Format: JPG, JPEG, PNG &nbsp;|&nbsp; Ukuran maksimal: 2MB
                        </small>

                        @if($aspirasi->foto_bukti)
                            <div class="mb-3">
                                <label class="text-muted">Foto Saat Ini:</label><br>
                                <img src="{{ asset('storage/' . $aspirasi->foto_bukti) }}" 
                                     alt="Foto Bukti" 
                                     class="rounded shadow-sm"
                                     style="max-height: 200px; max-width: 300px; object-fit: cover;">
                            </div>
                        @endif

                        <!-- Custom file upload area -->
                        <label for="foto_bukti" id="foto-label"
                            class="d-flex flex-column align-items-center justify-content-center
                                   w-100 border rounded"
                            style="min-height: 130px; cursor: pointer; border: 2px dashed #ccc !important;
                                   background: #f9f9f9; transition: border-color 0.2s;">

                            <i class="now-ui-icons arrows-1_cloud-upload-94"
                               style="font-size: 36px; color: #aaa;" id="foto-icon"></i>
                            <span class="mt-2 text-muted" id="foto-text">
                                Klik untuk pilih foto baru, atau seret ke sini
                            </span>
                            <span class="badge badge-success mt-2 d-none" id="foto-name-badge"></span>

                            <input type="file" name="foto_bukti" id="foto_bukti"
                                   accept="image/jpg,image/jpeg,image/png"
                                   class="d-none @error('foto_bukti') is-invalid @enderror"
                                   onchange="previewFoto(this)">
                        </label>

                        <!-- Preview gambar -->
                        <div id="foto-preview-wrap" class="mt-3 d-none text-center">
                            <img id="foto-preview" src="#" alt="Preview"
                                 class="rounded shadow-sm"
                                 style="max-height: 200px; max-width: 100%; object-fit: cover;">
                            <br>
                            <button type="button" class="btn btn-sm btn-outline-danger mt-2"
                                    onclick="hapusFoto()">
                                <i class="now-ui-icons ui-1_simple-remove"></i> Hapus Foto
                            </button>
                        </div>

                        @error('foto_bukti')
                            <div class="text-danger mt-1"><small>{{ $message }}</small></div>
                        @enderror
                    </div>

                    <!-- Status Info -->
                    <div class="alert alert-info">
                        <i class="now-ui-icons ui-1_info-circle"></i>
                        <strong>Info:</strong> Aspirasi hanya dapat diedit selama status masih "Menunggu" dan belum ada feedback dari admin.
                    </div>

                    <div class="form-group text-center pt-3">
                        <button type="submit" class="btn btn-primary btn-lg px-5">
                            <i class="now-ui-icons ui-1_check"></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('siswa.aspirasi.show', $aspirasi) }}"
                           class="btn btn-secondary btn-lg px-5 ml-3">
                            <i class="now-ui-icons ui-1_simple-remove"></i> Batal
                        </a>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>

{{-- Script preview foto --}}
<script>
    /**
     * Tampilkan preview gambar dan nama file saat dipilih
     * @param {HTMLInputElement} input
     */
    function previewFoto(input) {
        const file = input.files[0];
        if (!file) return;

        // Tampilkan nama file di badge
        const badge = document.getElementById('foto-name-badge');
        badge.textContent = file.name;
        badge.classList.remove('d-none');

        // Ubah teks label
        document.getElementById('foto-text').textContent = 'File dipilih:';
        document.getElementById('foto-icon').style.color = '#f96332'; // warna primer tema

        // Tampilkan preview gambar
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('foto-preview');
            preview.src = e.target.result;
            document.getElementById('foto-preview-wrap').classList.remove('d-none');
        };
        reader.readAsDataURL(file);

        // Highlight border
        document.getElementById('foto-label').style.borderColor = '#f96332';
    }

    /**
     * Reset input foto dan preview
     */
    function hapusFoto() {
        document.getElementById('foto_bukti').value = '';
        document.getElementById('foto-preview-wrap').classList.add('d-none');
        document.getElementById('foto-preview').src = '#';
        document.getElementById('foto-name-badge').classList.add('d-none');
        document.getElementById('foto-text').textContent = 'Klik untuk pilih foto baru, atau seret ke sini';
        document.getElementById('foto-icon').style.color = '#aaa';
        document.getElementById('foto-label').style.borderColor = '#ccc';
    }
</script>
@endsection
