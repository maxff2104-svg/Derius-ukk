@extends('layouts.app', [
    'class' => 'sidebar-mini ',
    'namePage' => 'User Profile',
    'activePage' => 'profile',
    'activeNav' => '',
])

@section('content')
  <div class="panel-header panel-header-sm">
  </div>
  <div class="content">
    <div class="row">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">
            <h5 class="title">Edit Profil</h5>
          </div>
          <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Profile Photo Section -->
            <div class="text-center mb-4">
                <img src="{{ $user->profile_photo_url }}" alt="Profile Photo" class="rounded-circle" width="120" height="120" style="object-fit: cover; border: 3px solid #007bff;">
                <div class="mt-2">
                    <h6>{{ $user->role === 'admin' ? $user->username : ($user->siswa->nama ?? $user->username) }}</h6>
                    <span class="badge bg-primary">{{ ucfirst($user->role) }}</span>
                </div>
            </div>

            <!-- Profile Photo Upload Form -->
            <div class="mb-4">
                <h6>Ubah Foto Profil</h6>
                <form action="{{ route('profile.photo.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-8">
                            <input type="file" name="profile_photo" class="form-control @error('profile_photo') is-invalid @enderror" accept="image/*">
                            @error('profile_photo')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary btn-sm">Upload Foto</button>
                            @if ($user->profile_photo)
                                <a href="{{ route('profile.photo.remove') }}" class="btn btn-danger btn-sm ms-1" onclick="return confirm('Hapus foto profil?')">Hapus</a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>

            <form method="post" action="{{ route('profile.update') }}" autocomplete="off">
              @csrf
              @method('put')
              <div class="row">
                <div class="col-md-7 pr-1">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username', $user->username) }}" required>
                        @error('username')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
              </div>

              @if ($user->isSiswa() && $user->siswa)
                <div class="row">
                    <div class="col-md-7 pr-1">
                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $user->siswa->nama) }}" required>
                            @error('nama')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-7 pr-1">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas" class="form-control @error('kelas') is-invalid @enderror" value="{{ old('kelas', $user->siswa->kelas) }}" required>
                            @error('kelas')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-7 pr-1">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="{{ $user->siswa->nis }}" readonly>
                        </div>
                    </div>
                </div>
              @endif

              <div class="card-footer ">
                <button type="submit" class="btn btn-primary btn-round">Simpan Perubahan</button>
              </div>
            </form>
          </div>
          
          <div class="card-header">
            <h5 class="title">Ubah Password</h5>
          </div>
          <div class="card-body">
            <form method="post" action="{{ route('profile.update') }}" autocomplete="off">
              @csrf
              @method('put')
              <div class="row">
                <div class="col-md-7 pr-1">
                  <div class="form-group">
                    <label>Password Saat Ini</label>
                    <input class="form-control @error('current_password') is-invalid @enderror" name="current_password" placeholder="Password Saat Ini" type="password">
                    @error('current_password')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-7 pr-1">
                  <div class="form-group">
                    <label>Password Baru <small class="text-muted">(min. 8 karakter)</small></label>
                    <input class="form-control @error('password') is-invalid @enderror" placeholder="Minimal 8 karakter" type="password" name="password" minlength="8">
                    @error('password')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                  </div>
                </div>
            </div>
            <div class="row">
              <div class="col-md-7 pr-1">
                <div class="form-group">
                  <label>Konfirmasi Password Baru</label>
                  <input class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Ulangi password baru" type="password" name="password_confirmation" minlength="8">
                  @error('password_confirmation')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
              </div>
            </div>
            <div class="card-footer ">
              <button type="submit" class="btn btn-primary btn-round">Ubah Password</button>
            </div>
          </form>
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