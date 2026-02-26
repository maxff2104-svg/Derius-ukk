@extends('layouts.app', [
    'namePage' => 'Aspirasi Saya',
    'activePage' => 'siswa_aspirasi',
])

@section('content')
<div class="content" style="padding-top: 80px;">
    <div class="container-fluid">

        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-md-8">
                <h1 class="text-dark font-weight-bold mb-1">Histori Aspirasi Saya</h1>
                <p class="text-muted">Kelola dan lacak semua aspirasi Anda di sini</p>
            </div>
            <div class="col-md-4 text-right d-flex align-items-center justify-content-end">
                <a href="#form" class="btn btn-primary btn-lg">
                    <i class="now-ui-icons ui-1_simple-add"></i> Buat Aspirasi Baru
                </a>
            </div>
        </div>

        <!-- Aspirasi List Card -->
        <div class="card mb-5">
            <div class="card-header">
                <h5 class="card-title mb-0">Daftar Aspirasi</h5>
            </div>
            <div class="card-body">
                @if($aspirasi->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID Pelaporan</th>
                                    <th>Kategori</th>
                                    <th>Lokasi</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                    <th class="text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($aspirasi as $a)
                                    <tr>
                                        <td><small class="text-muted font-weight-bold">{{ $a->id_pelaporan }}</small></td>
                                        <td><span class="badge badge-info">{{ $a->kategori->ket_kategori ?? $a->id_kategori }}</span></td>
                                        <td>{{ $a->lokasi }}</td>
                                        <td>{!! statusBadge($a->status) !!}</td>
                                        <td>{{ formatTanggalIndonesia($a->created_at) }}</td>
                                        <td class="text-right">
                                            <a href="{{ route('siswa.aspirasi.show', $a) }}" class="btn btn-sm btn-info">
                                                <i class="now-ui-icons ui-1_zoom-bold"></i> Lihat
                                            </a>
                                            @if($a->status === 'Menunggu' && empty($a->feedback) && empty($a->progres_perbaikan))
                                                <a href="{{ route('siswa.aspirasi.edit', $a) }}" class="btn btn-sm btn-warning">
                                                    <i class="now-ui-icons ui-2_settings-90"></i> Edit
                                                </a>
                                                <form action="{{ route('siswa.aspirasi.destroy', $a) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" 
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus aspirasi ini?')">
                                                        <i class="now-ui-icons ui-1_simple-remove"></i> Hapus
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center mt-4">
                        {{ $aspirasi->links() }}
                    </div>
                @else
                    <div class="alert alert-info text-center py-5" role="alert">
                        <i class="now-ui-icons ui-2_favourite-28" style="font-size: 48px;"></i>
                        <p class="mt-3 mb-0">Anda belum membuat aspirasi apapun. <a href="#form">Buat aspirasi sekarang</a></p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Form Create Aspirasi Card -->
        <div class="card mb-5" id="form">
            <div class="card-header">
                <h5 class="card-title mb-0">Buat Aspirasi Baru</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('siswa.aspirasi.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="id_kategori" class="font-weight-bold">
                                Kategori <span class="text-danger">*</span>
                            </label>
                            <select name="id_kategori" id="id_kategori"
                                class="form-control form-control-lg @error('id_kategori') is-invalid @enderror"
                                required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach(\App\Models\Kategori::all() as $k)
                                    <option value="{{ $k->id_kategori }}"
                                        {{ old('id_kategori') == $k->id_kategori ? 'selected' : '' }}>
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
                                value="{{ old('lokasi') }}" required>
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
                            required>{{ old('keterangan') }}</textarea>
                        <small class="form-text text-muted mt-1 d-block">Semakin detail, semakin cepat kami respons</small>
                        @error('keterangan')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- ======================== FOTO BUKTI (FIXED) ======================== --}}
                    <div class="mb-4">
                        <label class="font-weight-bold d-block">Foto Bukti</label>
                        <small class="form-text text-muted d-block mb-2">
                            Format: JPG, JPEG, PNG &nbsp;|&nbsp; Ukuran maksimal: 2MB
                        </small>

                        {{-- Custom file upload area --}}
                        <label for="foto_bukti" id="foto-label"
                            class="d-flex flex-column align-items-center justify-content-center
                                   w-100 border rounded"
                            style="min-height: 130px; cursor: pointer; border: 2px dashed #ccc !important;
                                   background: #f9f9f9; transition: border-color 0.2s;">

                            <i class="now-ui-icons arrows-1_cloud-upload-94"
                               style="font-size: 36px; color: #aaa;" id="foto-icon"></i>
                            <span class="mt-2 text-muted" id="foto-text">
                                Klik untuk pilih foto, atau seret ke sini
                            </span>
                            <span class="badge badge-success mt-2 d-none" id="foto-name-badge"></span>

                            <input type="file" name="foto_bukti" id="foto_bukti"
                                   accept="image/jpg,image/jpeg,image/png"
                                   class="d-none @error('foto_bukti') is-invalid @enderror"
                                   onchange="previewFoto(this)">
                        </label>

                        {{-- Preview gambar --}}
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
                    {{-- ================================================================= --}}

                    <div class="form-group text-center pt-3">
                        <button type="submit" class="btn btn-primary btn-lg px-5">
                            <i class="now-ui-icons ui-1_send"></i> Kirim Aspirasi
                        </button>
                        <a href="#"
                           class="btn btn-secondary btn-lg px-5 ml-3"
                           onclick="window.scrollTo({top: 0, behavior: 'smooth'}); return false;">
                            Kembali ke Atas
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
        document.getElementById('foto-text').textContent = 'Klik untuk pilih foto, atau seret ke sini';
        document.getElementById('foto-icon').style.color = '#aaa';
        document.getElementById('foto-label').style.borderColor = '#ccc';
    }
</script>
@endsection