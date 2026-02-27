@extends('layouts.app', [
    'namePage' => 'Tambah Kategori',
    'activePage' => 'admin_kategori',
])

@section('title', 'Tambah Kategori')

@section('content')
<div class="content" style="padding: 20px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Tambah Kategori</h4>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <a href="{{ route('admin.kategori.index') }}" class="btn btn-secondary btn-sm">
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

                    <form action="{{ route('admin.kategori.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="ket_kategori">Nama Kategori</label>
                            <input type="text"
                                   name="ket_kategori"
                                   id="ket_kategori"
                                   class="form-control @error('ket_kategori') is-invalid @enderror"
                                   value="{{ old('ket_kategori') }}"
                                   maxlength="100"
                                   required>
                            @error('ket_kategori')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
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
@endsection

