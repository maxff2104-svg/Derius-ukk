@extends('layouts.app', [
    'namePage' => 'Kategori (Debug)',
    'activePage' => 'admin_kategori',
])

@section('title', 'Manajemen Kategori - Debug')

@section('content')
<div class="content" style="padding: 20px;">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Daftar Kategori </h4>
                </div>
                <div class="card-body">
                    <div class="mb-3 text-right">
                        <a href="{{ route('admin.kategori.create') }}" class="btn btn-primary btn-sm">
                            <i class="fa fa-plus"></i> Tambah Kategori
                        </a>
                    </div>
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    {{-- BUG: pakai $kategories padahal controller mengirim $kategori --}}
                    @if(isset($kategori
                    ) && $kategori->count())
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="text-primary">
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Kategori</th>
                                        <th>Tanggal Dibuat</th>
                                        <th class="text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($kategories as $index => $item)
                                        <tr>
                                            <td>{{ $kategories->firstItem() + $index }}</td>
                                            <td>{{ $item->ket_kategori }}</td>
                                            <td><small>{{ formatTanggalIndonesia($item->created_at) }}</small></td>
                                            <td class="text-right">
                                                <a href="{{ route('admin.kategori.edit', $item->id_kategori) }}" class="btn btn-sm btn-info">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.kategori.destroy', $item->id_kategori) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus kategori ini?')">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if(method_exists($kategories, 'links'))
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div class="text-muted">
                                    Menampilkan {{ $kategories->firstItem() }} - {{ $kategories->lastItem() }} dari {{ $kategories->total() }} data
                                </div>
                                {{ $kategories->links() }}
                            </div>
                        @endif
                    @else
                        <p class="text-center text-muted mb-0">Belum ada data kategori.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

