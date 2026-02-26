@extends('layouts.app', [
    'namePage' => 'Detail Aspirasi',
    'activePage' => 'admin_aspirasi',
])

@section('title', 'Detail Aspirasi')

@section('content')
<div class="content" style="padding: 20px;">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="text-dark font-weight-bold mb-1">Detail Aspirasi</h2>
            <p class="text-muted">ID: {{ $aspirasi->id_pelaporan }}</p>
        </div>
        <div class="col-md-4 text-right">
            <a href="{{ route('admin.aspirasi.index') }}" class="btn btn-secondary">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
            <a href="{{ route('admin.aspirasi.edit', $aspirasi) }}" class="btn btn-warning ms-2">
                <i class="fa fa-edit"></i> Edit
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Informasi Aspirasi</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Siswa:</strong> {{ $aspirasi->siswa->nama ?? '-' }}</p>
                            <p><strong>NIS:</strong> {{ $aspirasi->siswa->nis ?? '-' }}</p>
                            <p><strong>Kelas:</strong> {{ $aspirasi->siswa->kelas ?? '-' }}</p>
                            <p><strong>Kategori:</strong> {{ $aspirasi->kategori->ket_kategori }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Lokasi:</strong> {{ $aspirasi->lokasi }}</p>
                            <p><strong>Status:</strong> {!! $aspirasi->status_badge !!}</p>
                            <p><strong>Dibuat:</strong> {{ formatTanggalIndonesia($aspirasi->created_at) }}</p>
                            @if($aspirasi->updated_at != $aspirasi->created_at)
                                <p><strong>Diperbarui:</strong> {{ formatTanggalIndonesia($aspirasi->updated_at) }}</p>
                            @endif
                        </div>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <p><strong>Keterangan:</strong></p>
                            <p>{{ $aspirasi->keterangan }}</p>
                        </div>
                    </div>
                    
                    @if($aspirasi->feedback)
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <p><strong>Feedback:</strong></p>
                                <div class="alert alert-info">{{ $aspirasi->feedback }}</div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">Status & Progress</h6>
                </div>
                <div class="card-body text-center">
                    <h4>{!! $aspirasi->status_badge !!}</h4>
                    
                    @if($aspirasi->progres_perbaikan > 0)
                        @if($aspirasi->status === 'Selesai')
                            <div class="alert alert-success mt-3">
                                <i class="fa fa-check-circle"></i> <strong>Selesai</strong>
                            </div>
                        @else
                            <div class="progress mt-3" style="height: 25px;">
                                <div class="progress-bar" role="progressbar" style="width: {{ $aspirasi->progres_perbaikan }}%;" aria-valuenow="{{ $aspirasi->progres_perbaikan }}" aria-valuemin="0" aria-valuemax="100">
                                    {{ $aspirasi->progres_perbaikan }}%
                                </div>
                            </div>
                            <small class="text-muted">Progress Perbaikan</small>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Photo Evidence -->
    @if($aspirasi->foto_bukti)
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Foto Bukti</h5>
                    </div>
                    <div class="card-body text-center">
                        <img src="{{ $aspirasi->foto_bukti_url }}" alt="Foto Bukti" class="img-fluid rounded" style="max-height: 400px;">
                    </div>
                </div>
            </div>
        </div>
    @endif
    
    <!-- Update Status Form -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Update Status & Feedback</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.aspirasi.status.update', $aspirasi) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="status" class="form-label">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="Menunggu" {{ $aspirasi->status == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                                        <option value="Diproses" {{ $aspirasi->status == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                                        <option value="Selesai" {{ $aspirasi->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                        <option value="Ditolak" {{ $aspirasi->status == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="progres_perbaikan" class="form-label">Progress (%)</label>
                                    <input type="number" name="progres_perbaikan" id="progres_perbaikan" class="form-control" min="0" max="100" value="{{ old('progres_perbaikan', $aspirasi->progres_perbaikan) }}">
                                    <small class="form-text text-muted">0-100</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="feedback" class="form-label">Feedback</label>
                                    <textarea name="feedback" id="feedback" class="form-control" rows="2" placeholder="Berikan feedback kepada siswa...">{{ old('feedback', $aspirasi->feedback) }}</textarea>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Update Status
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
