@extends('layouts.app', [
    'namePage' => 'Manajemen User',
    'activePage' => 'admin_users',
])

@section('title', 'Manajemen User')

@section('content')
<div class="content" style="padding: 20px;">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="text-dark font-weight-bold mb-1">Manajemen User</h2>
            <p class="text-muted">Kelola akun admin dan siswa</p>
        </div>
        <div class="col-md-4 text-right">
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> Tambah User
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if($users->count())
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="text-primary">
                                    <tr>
                                        <th>#</th>
                                        <th>Username</th>
                                        <th>Role</th>
                                        <th>Dibuat</th>
                                        <th class="text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $index => $user)
                                        <tr>
                                            <td>{{ $users->firstItem() + $index }}</td>
                                            <td>{{ $user->username }}</td>
                                            <td>
                                                <span class="badge badge-{{ $user->role === 'admin' ? 'primary' : 'info' }}">
                                                    {{ ucfirst($user->role) }}
                                                </span>
                                            </td>
                                            <td><small>{{ formatTanggalIndonesia($user->created_at) }}</small></td>
                                            <td class="text-right">
                                                <div class="btn-group">
                                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-info">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                                onclick="return confirm('Hapus user ini?')">
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

                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="text-muted">
                                Menampilkan {{ $users->firstItem() }} - {{ $users->lastItem() }} dari {{ $users->total() }} user
                            </div>
                            {{ $users->links() }}
                        </div>
                    @else
                        <p class="text-center text-muted mb-0">Belum ada user.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

