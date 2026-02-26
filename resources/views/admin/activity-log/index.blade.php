@extends('layouts.app', [
    'namePage' => 'Activity Log',
    'activePage' => 'activity_log',
])

@section('title', 'Activity Log')

@section('content')
<div class="content" style="padding: 20px;">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="text-dark font-weight-bold mb-1">Activity Log</h2>
            <p class="text-muted">Monitor semua aktivitas pengguna dalam sistem</p>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">Filter Activity Log</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.activity-log.index') }}">
                <div class="row">
                    <div class="col-md-3">
                        <label for="start_date">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="end_date">Tanggal Selesai</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" value="{{ request('end_date') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="model_type">Model Type</label>
                        <select class="form-control" id="model_type" name="model_type">
                            <option value="">Semua Model</option>
                            @foreach($modelTypes as $type)
                                <option value="{{ $type }}" {{ request('model_type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="user_id">User</label>
                        <select class="form-control" id="user_id" name="user_id">
                            <option value="">Semua User</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>{{ $user->username }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>&nbsp;</label>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-filter"></i> Filter
                            </button>
                            <a href="{{ route('admin.activity-log.index') }}" class="btn btn-secondary">
                                <i class="fa fa-refresh"></i> Reset
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Activity Logs Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Daftar Activity Log</h5>
        </div>
        <div class="card-body">
            @if($activityLogs->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover" id="activityLogTable">
                        <thead>
                            <tr>
                                <th>Tanggal & Waktu</th>
                                <th>User</th>
                                <th>Model Type</th>
                                <th>Model ID</th>
                                <th>Action</th>
                                <th>Description</th>
                                <th>IP Address</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($activityLogs as $log)
                            <tr>
                                <td>
                                    <small>{{ formatTanggalIndonesia($log->created_at) }}</small><br>
                                    <small class="text-muted">{{ $log->created_at->format('H:i:s') }}</small>
                                </td>
                                <td>
                                    @if($log->user)
                                        <span class="badge badge-info">{{ $log->user->username }}</span>
                                    @else
                                        <span class="badge badge-secondary">System</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-primary">{{ $log->model_type }}</span>
                                </td>
                                <td>
                                    <code>{{ $log->model_id }}</code>
                                </td>
                                <td>
                                    <span class="badge 
                                        @if($log->action == 'created') badge-success
                                        @elseif($log->action == 'updated') badge-warning
                                        @elseif($log->action == 'deleted') badge-danger
                                        @else badge-secondary @endif">
                                        {{ ucfirst($log->action) }}
                                    </span>
                                </td>
                                <td>
                                    <small>{{ Str::limit($log->description, 100) }}</small>
                                </td>
                                <td>
                                    <small class="text-muted">{{ $log->ip_address }}</small>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div>
                        <small class="text-muted">
                            Menampilkan {{ $activityLogs->firstItem() }} - {{ $activityLogs->lastItem() }} 
                            dari {{ $activityLogs->total() }} data
                        </small>
                    </div>
                    <div>
                        {{ $activityLogs->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fa fa-list-alt fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Tidak ada activity log yang ditemukan</p>
                    <small class="text-muted">Coba ubah filter atau tunggu ada aktivitas baru</small>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function exportToExcel() {
    const startDate = document.getElementById('start_date').value;
    const endDate = document.getElementById('end_date').value;
    const modelType = document.getElementById('model_type').value;
    
    let url = '{{ route("admin.activity-log.export") }}?type=excel';
    if (startDate) url += '&start_date=' + startDate;
    if (endDate) url += '&end_date=' + endDate;
    if (modelType) url += '&model_type=' + modelType;
    
    window.open(url, '_blank');
}

function exportToPDF() {
    const startDate = document.getElementById('start_date').value;
    const endDate = document.getElementById('end_date').value;
    const modelType = document.getElementById('model_type').value;
    
    let url = '{{ route("admin.activity-log.export") }}?type=pdf';
    if (startDate) url += '&start_date=' + startDate;
    if (endDate) url += '&end_date=' + endDate;
    if (modelType) url += '&model_type=' + modelType;
    
    window.open(url, '_blank');
}
</script>
@endsection
