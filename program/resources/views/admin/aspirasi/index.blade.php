@extends('layouts.app', [
    'namePage' => 'Daftar Aspirasi',
    'activePage' => 'admin_aspirasi',
])

@section('title', 'Daftar Aspirasi')

@section('content')
<div class="content" style="padding: 20px;">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="text-dark font-weight-bold mb-1">Daftar Aspirasi</h2>
            <p class="text-muted">Kelola semua aspirasi sarana sekolah</p>
        </div>
        <div class="col-md-4 text-right">
            <a href="{{ route('admin.aspirasi.create') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> Tambah Aspirasi
            </a>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Filter Aspirasi</h5>
                </div>
                <div class="card-body">
                    <form id="filterForm" method="GET" action="{{ route('admin.aspirasi.index') }}">
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="search">Cari</label>
                                <input type="text" name="search" class="form-control" placeholder="ID, lokasi, keterangan..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2">
                                <label for="status">Status</label>
                                <select name="status" class="form-control">
                                    <option value="">Semua Status</option>
                                    <option value="Menunggu" {{ request('status') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                                    <option value="Diproses" {{ request('status') == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                                    <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                    <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="id_kategori">Kategori</label>
                                <select name="id_kategori" class="form-control">
                                    <option value="">Semua Kategori</option>
                                    @foreach($kategoris as $k)
                                        <option value="{{ $k->id_kategori }}" {{ request('id_kategori') == $k->id_kategori ? 'selected' : '' }}>
                                            {{ $k->ket_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="nis">NIS</label>
                                <input type="text" name="nis" class="form-control" placeholder="NIS siswa..." value="{{ request('nis') }}">
                            </div>
                            <div class="col-md-3">
                                <label>&nbsp;</label>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-info">
                                        <i class="fa fa-search"></i> Cari
                                    </button>
                                    <a href="{{ route('admin.aspirasi.index') }}" class="btn btn-secondary">
                                        <i class="fa fa-refresh"></i> Reset
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <label for="start_date">Tanggal Mulai</label>
                                <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                            </div>
                            <div class="col-md-2">
                                <label for="end_date">Tanggal Selesai</label>
                                <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                            </div>
                            <div class="col-md-2">
                                <label for="month">Bulan</label>
                                <select name="month" class="form-control">
                                    <option value="">Semua Bulan</option>
                                    @for($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}" {{ request('month') == $i ? 'selected' : '' }}>
                                            {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="year">Tahun</label>
                                <select name="year" class="form-control">
                                    <option value="">Semua Tahun</option>
                                    @for($i = date('Y'); $i >= date('Y') - 5; $i--)
                                        <option value="{{ $i }}" {{ request('year') == $i ? 'selected' : '' }}>
                                            {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>&nbsp;</label>
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-success" id="btnExportExcel">
                                        <i class="fa fa-file-excel-o"></i> Export Excel
                                    </button>
                                    <button type="button" class="btn btn-danger" id="btnExportPDF">
                                        <i class="fa fa-file-pdf-o"></i> Export PDF
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Data Aspirasi ({{ $aspirasi->total() }})</h5>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($aspirasi->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="text-primary">
                                    <tr>
                                        <th>ID</th>
                                        <th>Siswa</th>
                                        <th>Kategori</th>
                                        <th>Lokasi</th>
                                        <th>Keterangan</th>
                                        <th>Status</th>
                                        <th>Progress</th>
                                        <th>Tanggal</th>
                                        <th class="text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($aspirasi as $item)
                                    <tr>
                                        <td><small>{{ $item->id_pelaporan }}</small></td>
                                        <td>{{ $item->siswa->nama ?? '-' }}</td>
                                        <td>{{ $item->kategori->ket_kategori }}</td>
                                        <td>{{ $item->lokasi }}</td>
                                        <td>
                                            <span class="text-truncate d-inline-block" style="max-width: 150px;" title="{{ $item->keterangan }}">
                                                {{ \Illuminate\Support\Str::limit($item->keterangan, 30) }}
                                            </span>
                                        </td>
                                        <td>{!! $item->status_badge !!}</td>
                                        <td>
                                            @if($item->progres_perbaikan > 0)
                                                @if($item->status === 'Selesai')
                                                    <span class="badge badge-success">Selesai</span>
                                                @else
                                                    <div class="progress" style="height: 20px;">
                                                        <div class="progress-bar" role="progressbar"
                                                            style="width: {{ $item->progres_perbaikan }}%;"
                                                            aria-valuenow="{{ $item->progres_perbaikan }}"
                                                            aria-valuemin="0"
                                                            aria-valuemax="100">
                                                            {{ $item->progres_perbaikan }}%
                                                        </div>
                                                    </div>
                                                @endif
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td><small>{{ formatTanggalIndonesia($item->created_at) }}</small></td>
                                        <td class="text-right">
                                            <div class="btn-group">
                                                <a href="{{ route('admin.aspirasi.show', $item) }}" class="btn btn-sm btn-info" title="Detail">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.aspirasi.edit', $item) }}" class="btn btn-sm btn-warning" title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.aspirasi.destroy', $item) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus aspirasi ini?')" title="Hapus">
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
                                Menampilkan {{ $aspirasi->firstItem() }} - {{ $aspirasi->lastItem() }} dari {{ $aspirasi->total() }} data
                            </div>
                            {{ $aspirasi->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fa fa-inbox fa-3x text-muted mb-3"></i>
                            <h4 class="text-muted">Belum Ada Aspirasi</h4>
                            <p class="text-muted">Belum ada data aspirasi yang tersimpan.</p>
                            <a href="{{ route('admin.aspirasi.create') }}" class="btn btn-primary">
                                <i class="fa fa-plus"></i> Tambah Aspirasi Pertama
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Script diletakkan di dalam @section('content') agar pasti termuat setelah DOM siap --}}
<script>
    (function () {
        function getExportUrl(type) {
            var form = document.getElementById('filterForm');
            var formData = new FormData(form);
            var url = '{{ route("admin.aspirasi.export") }}?type=' + type;
            for (var pair of formData.entries()) {
                if (pair[1]) {
                    url += '&' + pair[0] + '=' + encodeURIComponent(pair[1]);
                }
            }
            return url;
        }

        document.getElementById('btnExportExcel').addEventListener('click', function () {
            window.open(getExportUrl('excel'), '_blank');
        });

        document.getElementById('btnExportPDF').addEventListener('click', function () {
            window.open(getExportUrl('pdf'), '_blank');
        });
    })();
</script>

@endsection