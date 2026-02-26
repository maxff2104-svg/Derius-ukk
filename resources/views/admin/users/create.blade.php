@extends('layouts.app', [
    'namePage' => 'Tambah User',
    'activePage' => 'admin_users',
])

@section('title', 'Tambah User')

@section('content')
<div class="content" style="padding: 20px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Tambah User</h4>
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

                    <form action="{{ route('admin.users.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text"
                                   name="username"
                                   id="username"
                                   class="form-control @error('username') is-invalid @enderror"
                                   value="{{ old('username') }}"
                                   maxlength="50"
                                   required>
                            @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password">Password <small class="text-muted">(min. 8 karakter)</small></label>
                            <input type="password"
                                   name="password"
                                   id="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   minlength="8"
                                   placeholder="Minimal 8 karakter"
                                   required>
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
                                <option value="">Pilih Role</option>
                                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="siswa" {{ old('role') === 'siswa' ? 'selected' : '' }}>Siswa</option>
                            </select>
                            @error('role')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Siswa Fields - Only show when role is siswa -->
                        <div id="siswa-fields" style="display: none !important; margin-top: 20px;">
                            <div class="alert alert-info">
                                <i class="fa fa-info-circle"></i> 
                                Field berikut hanya untuk role Siswa
                            </div>

                            <div class="form-group">
                                <label for="nis">NIS</label>
                                <input type="text"
                                       name="nis"
                                       id="nis"
                                       class="form-control @error('nis') is-invalid @enderror"
                                       value="{{ old('nis') }}"
                                       maxlength="20"
                                       placeholder="Nomor Induk Siswa">
                                @error('nis')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="nama">Nama Siswa</label>
                                <input type="text"
                                       name="nama"
                                       id="nama"
                                       class="form-control @error('nama') is-invalid @enderror"
                                       value="{{ old('nama') }}"
                                       maxlength="100"
                                       placeholder="Nama lengkap siswa">
                                @error('nama')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="kelas">Kelas</label>
                                <input type="text"
                                       name="kelas"
                                       id="kelas"
                                       class="form-control @error('kelas') is-invalid @enderror"
                                       value="{{ old('kelas') }}"
                                       maxlength="50"
                                       placeholder="Contoh: XII RPL 1">
                                @error('kelas')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@push('js')
<script>
// jQuery approach
$(document).ready(function() {
    $('#role').on('change', function() {
        if ($(this).val() === 'siswa') {
            $('#siswa-fields').slideDown();
        } else {
            $('#siswa-fields').slideUp();
        }
    });
    
    // Initial check
    if ($('#role').val() === 'siswa') {
        $('#siswa-fields').show();
    }
});

// Vanilla JavaScript fallback
document.addEventListener('DOMContentLoaded', function() {
    const roleSelect = document.getElementById('role');
    const siswaFields = document.getElementById('siswa-fields');
    
    console.log('Role select:', roleSelect);
    console.log('Siswa fields:', siswaFields);
    
    function toggleSiswaFields() {
        console.log('Current role value:', roleSelect ? roleSelect.value : 'not found');
        if (roleSelect && roleSelect.value === 'siswa') {
            siswaFields.style.display = 'block';
            console.log('Showing siswa fields');
        } else {
            siswaFields.style.display = 'none';
            console.log('Hiding siswa fields');
        }
    }
    
    // Initial check
    if (roleSelect) {
        toggleSiswaFields();
        
        // Listen for changes
        roleSelect.addEventListener('change', function() {
            console.log('Role changed to:', roleSelect.value);
            toggleSiswaFields();
        });
    }
});
</script>
@endpush

