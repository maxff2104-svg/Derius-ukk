@extends('layouts.app', [
    'class' => 'sidebar-mini ',
    'namePage' => 'Buat Aspirasi',
    'activePage' => 'aspirasi',
    'activeNav' => '',
])

@section('title', 'Buat Aspirasi Baru')

@section('content')
  <div class="panel-header panel-header-sm">
  </div>
  <div class="content">
    <div class="row">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">
            <h5 class="title">Buat Aspirasi Baru</h5>
            <p class="category">Laporkan masalah sarana sekolah yang Anda temukan</p>
          </div>
          <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('siswa.aspirasi.store') }}" enctype="multipart/form-data">
              @csrf
              
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="id_kategori" class="control-label">Kategori <span class="text-danger">*</span></label>
                    <select class="form-control @error('id_kategori') is-invalid @enderror" id="id_kategori" name="id_kategori" required>
                      <option value="">-- Pilih Kategori --</option>
                      @foreach($kategori as $kat)
                        <option value="{{ $kat->id_kategori }}" {{ old('id_kategori') == $kat->id_kategori ? 'selected' : '' }}>
                          {{ $kat->ket_kategori }}
                        </option>
                      @endforeach
                    </select>
                    @error('id_kategori')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="lokasi" class="control-label">Lokasi <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('lokasi') is-invalid @enderror" id="lokasi" name="lokasi" placeholder="Contoh: Laboratorium Komputer Lantai 2" value="{{ old('lokasi') }}" required>
                    @error('lokasi')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="keterangan" class="control-label">Keterangan <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan" rows="4" placeholder="Jelaskan masalah yang Anda temukan secara detail..." required>{{ old('keterangan') }}</textarea>
                    @error('keterangan')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="foto_bukti" class="control-label">Foto Bukti <span class="text-danger">*</span></label>
                    <input type="file" class="form-control @error('foto_bukti') is-invalid @enderror" id="foto_bukti" name="foto_bukti" accept="image/*" required>
                    <small class="form-text text-muted">Format: JPG, JPEG, PNG. Maksimal: 2MB</small>
                    @error('foto_bukti')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                  </div>
                </div>
              </div>

              <div class="card-footer">
                <a href="{{ route('siswa.dashboard') }}" class="btn btn-secondary">
                  <i class="fa fa-arrow-left"></i> Kembali
                </a>
                <button type="submit" class="btn btn-primary pull-right">
                  <i class="fa fa-send"></i> Kirim Aspirasi
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
      
      <div class="col-md-4">
        <div class="card">
          <div class="card-header">
            <h5 class="title">Petunjuk</h5>
          </div>
          <div class="card-body">
            <h6><i class="fa fa-info-circle"></i> Cara Mengisi Form</h6>
            <ol>
              <li><strong>Kategori:</strong> Pilih jenis sarana yang bermasalah</li>
              <li><strong>Lokasi:</strong> Sebutkan lokasi pasti masalah tersebut</li>
              <li><strong>Keterangan:</strong> Jelaskan masalah secara detail dan jelas</li>
              <li><strong>Foto Bukti:</strong> Upload foto yang menunjukkan masalah tersebut</li>
            </ol>
            
            <h6><i class="fa fa-lightbulb"></i> Tips</h6>
            <ul>
              <li>Ambil foto yang jelas dan fokus pada masalah</li>
              <li>Jelaskan kapan masalah tersebut terjadi</li>
              <li>Sebutkan dampak dari masalah tersebut</li>
            </ul>
          </div>
        </div>

        <div class="card">
          <div class="card-header">
            <h5 class="title">Status Aspirasi</h5>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-12">
                <span class="badge badge-warning">Menunggu</span> - Aspirasi sedang ditinjau
              </div>
              <div class="col-12 mt-2">
                <span class="badge badge-info">Diproses</span> - Sedang dalam perbaikan
              </div>
              <div class="col-12 mt-2">
                <span class="badge badge-success">Selesai</span> - Masalah telah diselesaikan
              </div>
              <div class="col-12 mt-2">
                <span class="badge badge-danger">Ditolak</span> - Aspirasi tidak dapat diproses
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);
});
</script>
@endsection
