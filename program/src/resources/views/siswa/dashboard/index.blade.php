@extends('layouts.app', [
    'class' => 'sidebar-mini ',
    'namePage' => 'Dashboard Siswa',
    'activePage' => 'dashboard',
    'activeNav' => '',
])

@section('title', 'Dashboard Siswa')

@section('content')
  <div class="panel-header panel-header-sm">
  </div>
  <div class="content">
    <div class="row">
      <!-- Welcome Card -->
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h5 class="title">Selamat Datang, {{ $siswa->nama }}!</h5>
            <p class="category">NIS: {{ $siswa->nis }} | Kelas: {{ $siswa->kelas }}</p>
          </div>
          <div class="card-body">
            <p class="text-muted">Sistem Pengaduan Sarana Sekolah</p>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <!-- Statistics Cards -->
      <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
          <div class="card-body">
            <div class="row">
              <div class="col-5 col-md-4">
                <div class="icon-big text-center icon-warning">
                  <i class="nc-icon nc-paper text-warning"></i>
                </div>
              </div>
              <div class="col-7 col-md-8">
                <div class="numbers">
                  <p class="card-category">Total Aspirasi</p>
                  <h3 class="card-title">{{ $totalAspirasi }}</h3>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer">
            <hr>
            <div class="stats">
              <i class="fa fa-refresh"></i> Total pengaduan Anda
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
          <div class="card-body">
            <div class="row">
              <div class="col-5 col-md-4">
                <div class="icon-big text-center icon-info">
                  <i class="nc-icon nc-time-alarm text-info"></i>
                </div>
              </div>
              <div class="col-7 col-md-8">
                <div class="numbers">
                  <p class="card-category">Menunggu</p>
                  <h3 class="card-title">{{ $pendingAspirasi }}</h3>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer">
            <hr>
            <div class="stats">
              <i class="fa fa-clock-o"></i> Sedang diproses
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
          <div class="card-body">
            <div class="row">
              <div class="col-5 col-md-4">
                <div class="icon-big text-center icon-success">
                  <i class="nc-icon nc-check-2 text-success"></i>
                </div>
              </div>
              <div class="col-7 col-md-8">
                <div class="numbers">
                  <p class="card-category">Selesai</p>
                  <h3 class="card-title">{{ $completedAspirasi }}</h3>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer">
            <hr>
            <div class="stats">
              <i class="fa fa-check"></i> Sudah diselesaikan
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
          <div class="card-body">
            <div class="row">
              <div class="col-5 col-md-4">
                <div class="icon-big text-center icon-danger">
                  <i class="nc-icon nc-simple-remove text-danger"></i>
                </div>
              </div>
              <div class="col-7 col-md-8">
                <div class="numbers">
                  <p class="card-category">Ditolak</p>
                  <h3 class="card-title">{{ $rejectedAspirasi }}</h3>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer">
            <hr>
            <div class="stats">
              <i class="fa fa-times"></i> Pengaduan ditolak
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- BARIS PERTAMA: Notifikasi Counter + Notifikasi Terbaru -->
    <div class="row">
      <!-- Notifications Counter Card -->
      <div class="col-lg-2 col-md-3 col-sm-6">
        <div class="card card-stats">
          <div class="card-body">
            <div class="row">
              <div class="col-5 col-md-4">
                <div class="icon text-center icon-info">
                  <i class="nc-icon nc-bell-53 text-info"></i>
                </div>
              </div>
              <div class="col-7 col-md-8">
                <div class="numbers">
                  <p class="card-category">Notifikasi</p>
                  <h3 class="card-title">
                    <a href="{{ route('siswa.notifikasi.index') }}" class="text-decoration-none">
                      {{ $unreadCount }}
                      @if($unreadCount > 0)
                        <span class="badge badge-danger ml-1">{{ $unreadCount }}</span>
                      @endif
                    </a>
                  </h3>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer">
            <hr>
            <div class="stats">
              <i class="fa fa-bell"></i> 
              @if($unreadCount > 0)
                <a href="{{ route('siswa.notifikasi.index', ['status' => 'unread']) }}" class="text-warning">
                  Belum Dibaca
                </a>
              @else
                <span class="text-muted">Semua Dibaca</span>
              @endif
            </div>
          </div>
        </div>
      </div>
      
      <!-- Recent Notifications Card -->
      <div class="col-lg-10 col-md-9 col-sm-12">
        <div class="card" style="max-height: 300px; overflow-y: auto;">
          <div class="card-header">
            <h5 class="title">Notifikasi Terbaru</h5>
          </div>
          <div class="card-body">
            @php
              $recentNotifications = \App\Models\Notifikasi::where('user_id', Auth::id())
                  ->with('aspirasi')
                  ->orderBy('created_at', 'desc')
                  ->limit(3)
                  ->get();
            @endphp
            @if($recentNotifications->count() > 0)
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
                    @foreach($recentNotifications as $notif)
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
                          {{ Illuminate\Support\Str::limit($notif->pesan, 60) }}
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
            @else
              <div class="text-center py-4">
                <i class="fa fa-bell-slash fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">Tidak Ada Notifikasi</h4>
                <p class="text-muted">Belum ada notifikasi untuk Anda.</p>
              </div>
            @endif
            <div class="text-center mt-3">
              <a href="{{ route('siswa.notifikasi.index') }}" class="btn btn-primary">
                <i class="fa fa-list"></i> Lihat Semua Notifikasi
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- BARIS KEDUA: Aspirasi Terbaru (full width) -->
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h5 class="title">Aspirasi Terbaru</h5>
          </div>
          <div class="card-body">
            @if($recentAspirasi->count() > 0)
              <div class="table-responsive">
                <table class="table table-hover">
                  <thead class="text-primary">
                    <tr>
                      <th>ID</th>
                      <th>Lokasi</th>
                      <th>Status</th>
                      <th>Tanggal</th>
                      <th class="text-right">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($recentAspirasi as $aspirasi)
                    <tr>
                      <td><small>{{ $aspirasi->id_pelaporan }}</small></td>
                      <td>{{ $aspirasi->lokasi }}</td>
                      <td>{!! $aspirasi->status_badge !!}</td>
                      <td><small>{{ formatTanggalIndonesia($aspirasi->created_at) }}</small></td>
                      <td class="text-right">
                        <a href="{{ route('siswa.aspirasi.show', $aspirasi->id_aspirasi) }}" class="btn btn-sm btn-primary">
                          <i class="fa fa-eye"></i>
                        </a>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            @else
              <div class="text-center py-4">
                <i class="fa fa-inbox fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Belum Ada Aspirasi</h5>
                <p class="text-muted">Anda belum mengajukan aspirasi apapun.</p>
                <a href="{{ route('siswa.aspirasi.create') }}" class="btn btn-primary">
                  <i class="fa fa-plus"></i> Buat Aspirasi Pertama
                </a>
              </div>
            @endif
          </div>
          <div class="card-footer">
            <hr>
            <div class="stats">
              <i class="fa fa-history"></i> Lihat semua aspirasi Anda di halaman Aspirasi
            </div>
            <div class="pull-right">
              <a href="{{ route('siswa.aspirasi.index') }}" class="btn btn-primary btn-round">
                Lihat Semua Aspirasi
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h5 class="title">Aksi Cepat</h5>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-4">
                <a href="{{ route('siswa.aspirasi.create') }}" class="btn btn-primary btn-block">
                  <i class="fa fa-plus"></i> Buat Aspirasi Baru
                </a>
              </div>
              <div class="col-md-4">
                <a href="{{ route('siswa.aspirasi.index') }}" class="btn btn-info btn-block">
                  <i class="fa fa-list"></i> Lihat Semua Aspirasi
                </a>
              </div>
              <div class="col-md-4">
                <a href="{{ route('profile.edit') }}" class="btn btn-warning btn-block">
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