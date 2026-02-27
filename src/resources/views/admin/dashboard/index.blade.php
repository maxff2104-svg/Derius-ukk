@extends('layouts.app', [   
    'activePage' => 'admin_dashboard',
])

@section('title', 'Dashboard Admin')

@section('content')
<div class="content" style="padding: 20px;">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="text-dark font-weight-bold mb-1">Dashboard Admin</h2>
            <p class="text-muted">Monitor dan kelola semua aspirasi sarana sekolah</p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $total }}</h4>
                            <p>Total Aspirasi</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fa fa-list fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @foreach($statusCounts as $status => $cnt)
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card text-white
                @if($status == 'Menunggu') bg-warning
                @elseif($status == 'Diproses') bg-info
                @elseif($status == 'Selesai') bg-success
                @else bg-danger @endif">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $cnt }}</h4>
                            <p>{{ $status }}</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fa fa-2x
                                @if($status == 'Menunggu') fa-clock-o
                                @elseif($status == 'Diproses') fa-spinner
                                @elseif($status == 'Selesai') fa-check
                                @else fa-times @endif">
                            </i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Recent Aspirasi -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Aspirasi Terbaru</h5>
                    <a href="{{ route('admin.aspirasi.index') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-list"></i> Lihat Semua
                    </a>
                </div>
                <div class="card-body">
                    @php
                        $recentAspirasi = \App\Models\Aspirasi::with(['siswa', 'kategori'])
                            ->orderBy('created_at', 'desc')
                            ->limit(5)
                            ->get();
                    @endphp

                    @if($recentAspirasi->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Siswa</th>
                                        <th>Kategori</th>
                                        <th>Lokasi</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentAspirasi as $asp)
                                    <tr>
                                        <td><small>{{ $asp->id_pelaporan }}</small></td>
                                        <td>{{ $asp->siswa->nama ?? '-' }}</td>
                                        <td>{{ $asp->kategori->ket_kategori }}</td>
                                        <td>{{ $asp->lokasi }}</td>
                                        <td>{!! statusBadge($asp->status) !!}</td>
                                        <td><small>{{ formatTanggalIndonesia($asp->created_at) }}</small></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted text-center">Belum ada aspirasi</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {

    // Debug: Check if Chart.js is loaded
    if (typeof Chart === 'undefined') {
        console.error('Chart.js is not loaded!');
        return;
    }

    // Debug: Check data
    console.log('Per Kategori Data:', @json($perKategori ?? []));
    console.log('Status Counts Data:', @json($statusCounts ?? []));
    console.log('Kategori Labels:', @json($kategoriLabels ?? []));

    // Kategori Chart - Fixed with getContext and delay
    @if(!empty($perKategori))
    setTimeout(() => {
        try {
            const kategoriCtx = document.getElementById('kategoriChart');
            if (kategoriCtx) {
                new Chart(kategoriCtx.getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: @json(array_values($kategoriLabels)),
                        datasets: [{
                            data: @json(array_values($perKategori)),
                            backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40']
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false
                    }
                });
                console.log('Kategori chart created successfully');
            } else {
                console.error('Kategori chart canvas not found!');
            }
        } catch (error) {
            console.error('Error creating kategori chart:', error);
        }
    }, 100); // 100ms delay
    @endif
});
</script>
@endsection