@extends('layouts.app')

@section('title', 'Activity Log - Siswa')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            <i class="nc-icon nc-time-alarm"></i>
                            Activity Log Saya
                        </h4>
                        <p class="card-category">Riwayat aktivitas yang telah Anda lakukan</p>
                    </div>
                    <div class="card-body">
                        <!-- Filter Form -->
                        <form method="GET" action="{{ route('siswa.activity-log.index') }}" class="mb-4">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="start_date">Tanggal Mulai</label>
                                    <input type="date" id="start_date" name="start_date" 
                                           class="form-control" value="{{ request('start_date') }}">
                                </div>
                                <div class="col-md-3">
                                    <label for="end_date">Tanggal Selesai</label>
                                    <input type="date" id="end_date" name="end_date" 
                                           class="form-control" value="{{ request('end_date') }}">
                                </div>
                                <div class="col-md-3">
                                    <label for="model_type">Tipe Aktivitas</label>
                                    <select id="model_type" name="model_type" class="form-control">
                                        <option value="">Semua</option>
                                        @foreach($modelTypes as $type)
                                            <option value="{{ $type }}" {{ request('model_type') == $type ? 'selected' : '' }}>
                                                {{ $type }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label>&nbsp;</label><br>
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i class="fa fa-filter"></i> Filter
                                    </button>
                                    <a href="{{ route('siswa.activity-log.index') }}" class="btn btn-secondary btn-sm">
                                        <i class="fa fa-refresh"></i> Reset
                                    </a>
                                </div>
                            </div>
                        </form>

                        <!-- Activity Logs Table -->
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="text-primary">
                                    <tr>
                                        <th>Tanggal & Waktu</th>
                                        <th>Aktivitas</th>
                                        <th>Model</th>
                                        <th>Deskripsi</th>
                                        <th>IP Address</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($activityLogs as $log)
                                        <tr>
                                            <td>
                                                <small>{{ formatTanggalIndonesia($log->created_at) }}</small><br>
                                                <small class="text-muted">{{ $log->created_at->format('H:i:s') }}</small>
                                            </td>
                                            <td>
                                                <span class="badge badge-{{ 
                                                    $log->action == 'create' ? 'success' : 
                                                    ($log->action == 'update' ? 'primary' : 
                                                    ($log->action == 'delete' ? 'danger' : 
                                                    ($log->action == 'view' ? 'secondary' : 
                                                    ($log->action == 'login' ? 'info' : 'warning')))) }}">
                                                    {{ ucfirst($log->action) }}
                                                </span>
                                            </td>
                                            <td>
                                                <small>{{ $log->model_type }}</small>
                                                @if($log->model_id)
                                                    <br><small class="text-muted">#{{ $log->model_id }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                <small>{{ $log->description ?? '-' }}</small>
                                            </td>
                                            <td>
                                                <small class="text-muted">{{ $log->ip_address ?? '-' }}</small>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">
                                                <i class="fa fa-info-circle"></i> 
                                                Tidak ada aktivitas yang ditemukan
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($activityLogs->hasPages())
                            <div class="d-flex justify-content-center">
                                {{ $activityLogs->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.badge-create { background-color: #28a745; }
.badge-update { background-color: #007bff; }
.badge-delete { background-color: #dc3545; }
.badge-view { background-color: #6c757d; }
.badge-login { background-color: #17a2b8; }
.badge-logout { background-color: #ffc107; color: #000; }
</style>
@endpush

@push('scripts')
<script>
// Auto-submit form when date changes
document.getElementById('start_date').addEventListener('change', function() {
    this.form.submit();
});

document.getElementById('end_date').addEventListener('change', function() {
    this.form.submit();
});

document.getElementById('model_type').addEventListener('change', function() {
    this.form.submit();
});
</script>
@endpush
