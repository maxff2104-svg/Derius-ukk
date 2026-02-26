@extends('layouts.app', [
    'namePage' => 'Edit User',
    'activePage' => 'admin_users',
])

@section('title', 'Edit User')

@section('content')
<div class="content" style="padding: 20px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Edit User</h4>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fa fa-arrow-left"></i> Kembali
                        </a>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.users.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text"
                                   name="username"
                                   id="username"
                                   class="form-control @error('username') is-invalid @enderror"
                                   value="{{ old('username', $user->username) }}"
                                   maxlength="50"
                                   required>
                            @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password">Password (kosongkan jika tidak diubah) <small class="text-muted">(min. 8 karakter)</small></label>
                            <input type="password"
                                   name="password"
                                   id="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   minlength="8"
                                   placeholder="Minimal 8 karakter">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="role">Role</label>
                            <select name="role"
                                    id="role"
                                    class="form-control @error('role') is-invalid @enderror"
                                    required>
                                <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="siswa" {{ old('role', $user->role) === 'siswa' ? 'selected' : '' }}>Siswa</option>
                            </select>
                            @error('role')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

