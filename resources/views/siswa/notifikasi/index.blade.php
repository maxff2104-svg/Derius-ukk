@extends('layouts.app', [
    'namePage' => 'Notifikasi',
    'activePage' => 'siswa_notifikasi',
])

@section('title', 'Notifikasi')

@section('content')
<div class="content" style="padding: 20px;">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="text-dark font-weight-bold mb-1">Notifikasi</h2>
            <p class="text-muted">Pemberitahuan terkait aspirasi Anda</p>
        </div>
        <div class="col-md-4 text-right">
        @if($unreadCount > 0)
    <form action="{{ route('siswa.notifikasi.markAllRead') }}" method="POST" style="display:inline;">
        @csrf
        @method('PUT')
        <button type="submit" class="btn btn-sm btn-info">
            <i class="fa fa-check-double"></i> Tandai Semua Dibaca
        </button>
    </form>
@endif
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-pills">
                        <li class="nav-item">
                            <a class="nav-link {{ request('status') != 'read' ? 'active' : '' }}" 
                               href="{{ route('siswa.notifikasi.index') }}">
                                <i class="fa fa-bell"></i> 
                                Semua 
                                @if($unreadCount > 0)
                                    <span class="badge badge-danger">{{ $unreadCount }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request('status') == 'unread' ? 'active' : '' }}" 
                               href="{{ route('siswa.notifikasi.index', ['status' => 'unread']) }}">
                                <i class="fa fa-envelope"></i> 
                                Belum Dibaca 
                                @if($unreadCount > 0)
                                    <span class="badge badge-warning">{{ $unreadCount }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request('status') == 'read' ? 'active' : '' }}" 
                               href="{{ route('siswa.notifikasi.index', ['status' => 'read']) }}">
                                <i class="fa fa-check-circle"></i> Sudah Dibaca
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Notifications List -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        Daftar Notifikasi 
                        @if(request('status') == 'unread')
                            (Belum Dibaca: {{ $unreadCount }})
                        @elseif(request('status') == 'read')
                            (Sudah Dibaca)
                        @else
                            (Semua: {{ $notifikasi->total() }})
                        @endif
                    </h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($notifikasi->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="text-primary">
                                    <tr>
                                        <th>Status</th>
                                        <th>Judul</th>
                                        <th>Pesan</th>
                                        <th>Tanggal</th>
                                        <th class="text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($notifikasi as $notif)
                                    <tr class="{{ $notif->is_read ? '' : 'table-warning' }}">
                                        <td>
                                            @if($notif->is_read)
                                                <span class="badge badge-success">Dibaca</span>
                                            @else
                                                <span class="badge badge-warning">Belum Dibaca</span>
                                            @endif
                                        </td>
                                        <td>
                                        <span class="badge badge-{{ $notif->tipe == 'success' ? 'success' : ($notif->tipe == 'danger' ? 'danger' : ($notif->tipe == 'warning' ? 'warning' : 'info')) }}">
                                                {{ $notif->judul }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-truncate d-inline-block" style="max-width: 300px;" title="{{ $notif->pesan }}">
                                                {{ Illuminate\Support\Str::limit($notif->pesan, 100) }}
                                            </span>
                                        </td>
                                        <td><small>{{ formatTanggalIndonesia($notif->created_at) }}</small></td>
                                        <td class="text-right">
                                            <div class="btn-group">
                                            @if(!$notif->is_read)
  <form action="{{ route('siswa.notifikasi.markRead', $notif->id) }}" 
        method="POST" style="display:inline;">
    @csrf
    @method('PUT')
    <button type="submit" class="btn btn-sm btn-info" title="Tandai Dibaca">
      <i class="fa fa-check"></i>
    </button>
  </form>
@endif
                                                
                                                @if($notif->aspirasi_id)
                                                    <a href="{{ route('siswa.aspirasi.show', $notif->aspirasi_id) }}" 
                                                       class="btn btn-sm btn-primary" title="Lihat Aspirasi">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                @endif
                                                
                                                <form action="{{ route('siswa.notifikasi.destroy', $notif->id) }}" 
                                                      method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" 
                                                            onclick="return confirm('Hapus notifikasi ini?')" 
                                                            title="Hapus">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <div class="text-muted">
                                Menampilkan {{ $notifikasi->firstItem() }} - {{ $notifikasi->lastItem() }} dari {{ $notifikasi->total() }} data
                            </div>
                            {{ $notifikasi->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fa fa-bell-slash fa-3x text-muted mb-3"></i>
                            <h4 class="text-muted">Tidak Ada Notifikasi</h4>
                            <p class="text-muted">Belum ada notifikasi untuk Anda.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.table-warning {
    background-color: #fff3cd;
}
.badge-danger {
    background-color: #dc3545;
}
.badge-warning {
    background-color: #ffc107;
    color: #212529;
}
.badge-info {
    background-color: #17a2b8;
}
.badge-success {
    background-color: #28a745;
}
.nav-pills .nav-link {
    border-radius: 0.375rem;
    margin-right: 0.5rem;
}
.nav-pills .nav-link.active {
    background-color: #007bff;
    border-color: #007bff;
}
</style>
@endpush

@push('scripts')
<script>
// Auto-refresh notifications every 30 seconds
setInterval(function() {
    fetch('{{ route("siswa.notifikasi.unreadCount") }}')
        .then(response => response.json())
        .then(data => {
            // Update notification count in navbar if exists
            const notificationBadge = document.querySelector('.notification-badge');
            if (notificationBadge) {
                if (data.count > 0) {
                    notificationBadge.textContent = data.count;
                    notificationBadge.style.display = 'inline-block';
                } else {
                    notificationBadge.style.display = 'none';
                }
            }
        });
}, 30000);
</script>
@endpush
