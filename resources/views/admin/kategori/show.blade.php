@extends('layouts.app', [
    'namePage' => 'Detail Kategori',
    'activePage' => 'admin_kategori',
])

@section('title', 'Detail Kategori')

@section('content')
<div class="content">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Detail Kategori</h4>
                    <a href="{{ route('admin.kategori.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fa fa-arrow-left"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4">Nama Kategori</dt>
                        <dd class="col-sm-8">{{ $kategori->ket_kategori }}</dd>

                        <dt class="col-sm-4">Total Aspirasi</dt>
                        <dd class="col-sm-8">{{ $kategori->aspirasi_count ?? $kategori->aspirasi()->count() }}</dd>

                        <dt class="col-sm-4">Dibuat</dt>
                        <dd class="col-sm-8">
                            {{ formatTanggalIndonesia($kategori->created_at) }}
                        </dd>

                        <dt class="col-sm-4">Diperbarui</dt>
                        <dd class="col-sm-8">
                            {{ formatTanggalIndonesia($kategori->updated_at) }}
                        </dd>
                    </dl>

                    @if($kategori->aspirasi->count())
                        <hr>
                        <h5 class="mb-3">Aspirasi Terkait</h5>
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
                                    @foreach($kategori->aspirasi as $aspirasi)
                                        <tr>
                                            <td><small>{{ $aspirasi->id_pelaporan }}</small></td>
                                            <td>{{ $aspirasi->lokasi }}</td>
                                            <td>{!! $aspirasi->status_badge !!}</td>
                                            <td><small>{{ formatTanggalIndonesia($aspirasi->created_at) }}</small></td>
                                            <td class="text-right">
                                                <a href="{{ route('admin.aspirasi.show', $aspirasi->id_aspirasi) }}" class="btn btn-sm btn-primary">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

