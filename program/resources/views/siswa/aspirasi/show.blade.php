@extends('layouts.app', [
    'namePage' => 'Detail Aspirasi',
    'activePage' => 'siswa_aspirasi',
])

@section('title', 'Detail Aspirasi')

@section('content')
<div class="content" style="padding: 20px;">
    <div class="row mb-4" style="margin-top: 10px;">
        <div class="col-md-8">
            <h2 class="text-dark font-weight-bold mb-1">Aspirasi {{ $aspirasi->id_pelaporan }}</h2>
            <p class="text-muted">Lihat detail dan progress aspirasi Anda</p>
        </div>
        <div class="col-md-4 text-right">
            <a href="{{ route('siswa.aspirasi.index') }}" class="btn btn-secondary">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Informasi Aspirasi</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Kategori:</strong> {{ $aspirasi->kategori->ket_kategori }}</p>
                            <p><strong>Lokasi:</strong> {{ $aspirasi->lokasi }}</p>
                            <p><strong>Status:</strong> {!! $aspirasi->status_badge !!}</p>
                            <p><strong>Dibuat:</strong> {{ formatTanggalIndonesia($aspirasi->created_at) }}</p>
                            @if($aspirasi->updated_at != $aspirasi->created_at)
                                <p><strong>Diperbarui:</strong> {{ formatTanggalIndonesia($aspirasi->updated_at) }}</p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            @if($aspirasi->progres_perbaikan > 0)
                                <p><strong>Progress Perbaikan:</strong></p>
                                <div class="progress" style="height: 25px;">
                                    <div class="progress-bar" role="progressbar"
                                         style="width: {{ $aspirasi->progres_perbaikan }}%;"
                                         aria-valuenow="{{ $aspirasi->progres_perbaikan }}"
                                         aria-valuemin="0" aria-valuemax="100">
                                        {{ $aspirasi->progres_perbaikan }}%
                                    </div>
                                </div>
                                <small class="text-muted">{{ $aspirasi->progres_perbaikan }}% selesai</small>
                            @endif
                        </div>
                    </div>

                    <!-- Keterangan — FIX: warna teks hitam -->
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <p><strong>Keterangan:</strong></p>
                            <div class="p-3 rounded" style="background-color: #f5f5f5; border: 1px solid #ddd; color: #333333;">
                                {{ $aspirasi->keterangan }}
                            </div>
                        </div>
                    </div>

                    <!-- Feedback Section — FIX: teks lebih center & rapi -->
                    @if($aspirasi->feedback)
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="card border-info">
                                    <div class="card-header bg-info text-white d-flex align-items-center justify-content-center">
                                        <h6 class="card-title mb-3">
                                            <i class="fa fa-comment"></i> Feedback dari Admin
                                        </h6>
                                    </div>
                                    <div class="card-body text-center">
                                        <p class="mb-1" style="color: #333; font-size: 15px;">
                                            {{ $aspirasi->feedback }}
                                        </p>
                                        <small class="text-muted">
                                            <i class="fa fa-clock-o"></i>
                                            {{ $aspirasi->updated_at->format('d M Y H:i') }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="card border-warning">
                                    <div class="card-header bg-warning text-white text-center">
                                        <h6 class="card-title mb-0">
                                            <i class="fa fa-info-circle"></i> Status
                                        </h6>
                                    </div>
                                    <div class="card-body text-center">
                                        <p class="mb-0" style="color: #333;">
                                            <i class="fa fa-hourglass-half"></i>
                                            <strong>Belum ada feedback dari admin.</strong><br>
                                            <small class="text-muted">Feedback akan muncul setelah admin memproses aspirasi Anda.</small>
                                        </p>
                                    </div>
                                </div>
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
                    <div class="mt-3">
                        @if($aspirasi->isPending())
                            <div class="alert alert-warning">
                                <i class="fa fa-clock-o"></i><br>
                                <small>Sedang ditinjau</small>
                            </div>
                        @elseif($aspirasi->isProcessing())
                            <div class="alert alert-info">
                                <i class="fa fa-spinner fa-spin"></i><br>
                                <small>Sedang diproses</small>
                            </div>
                        @elseif($aspirasi->isCompleted())
                            <div class="alert alert-success">
                                <i class="fa fa-check-circle"></i><br>
                                <small>Selesai</small>
                            </div>
                        @elseif($aspirasi->isRejected())
                            <div class="alert alert-danger">
                                <i class="fa fa-times-circle"></i><br>
                                <small>Ditolak</small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($aspirasi->foto_bukti)
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Foto Bukti</h5>
                    </div>
                    <div class="card-body text-center">
                        <img src="{{ $aspirasi->foto_bukti_url }}" alt="Foto Bukti"
                             class="img-fluid rounded" style="max-height: 400px;">
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <a href="{{ route('siswa.aspirasi.index') }}" class="btn btn-primary">
                                <i class="fa fa-plus"></i> Buat Aspirasi Baru
                            </a>
                            <a href="{{ route('siswa.aspirasi.index') }}" class="btn btn-info">
                                <i class="fa fa-list"></i> Lihat Semua Aspirasi
                            </a>
                        </div>
                        <div>
                            <a href="{{ route('profile.edit') }}" class="btn btn-secondary">
                                <i class="fa fa-user"></i> Edit Profil
                            </a>
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
    setTimeout(function() {
        document.querySelectorAll('.alert-dismissible').forEach(function(alert) {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);
});
</script>
@endsection