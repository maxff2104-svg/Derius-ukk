@extends('layouts.app', [
    'namePage' => 'Edit Kategori',
    'activePage' => 'admin_kategori',
])

@section('title', 'Edit Kategori')

@section('content')
<div class="content" style="padding: 20px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Edit Kategori</h4>
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

                    <form action="{{ route('admin.kategori.update', $kategori->id_kategori) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="ket_kategori">Nama Kategori</label>
                            <input type="text"
                                   name="ket_kategori"
                                   id="ket_kategori"
                                   class="form-control @error('ket_kategori') is-invalid @enderror"
                                   value="{{ old('ket_kategori', $kategori->ket_kategori) }}"
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

