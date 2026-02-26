<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            margin: 10px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .filters {
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
        }
        .filters strong {
            display: inline-block;
            width: 100px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            table-layout: fixed;
        }
        .table th {
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            padding: 5px;
            text-align: left;
            font-weight: bold;
            font-size: 9px;
        }
        .table td {
            border: 1px solid #ddd;
            padding: 4px;
            font-size: 9px;
            word-wrap: break-word;
            vertical-align: top;
        }
        .table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .badge {
            padding: 1px 4px;
            border-radius: 2px;
            font-size: 8px;
            font-weight: bold;
            white-space: nowrap;
            display: inline-block;
        }
        .badge-warning { background-color: #ffc107; color: black; }
        .badge-info { background-color: #17a2b8; color: white; }
        .badge-success { background-color: #28a745; color: white; }
        .badge-danger { background-color: #dc3545; color: white; }
        .footer {
            margin-top: 30px;
            border-top: 1px solid #ddd;
            padding-top: 20px;
            text-align: center;
            color: #666;
            font-size: 10px;
        }
        .text-truncate {
            max-width: 150px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN ASPIRASI SARANA SEKOLAH</h1>
        <p>Dicetak pada: {{ $date }}</p>
    </div>

    @if(!empty($filters))
    <div class="filters">
        <strong>Filter:</strong>
        @if(!empty($filters['search'])) <span>Cari: {{ $filters['search'] }}</span> @endif
        @if(!empty($filters['status'])) <span>Status: {{ $filters['status'] }}</span> @endif
        @if(!empty($filters['id_kategori'])) <span>Kategori: {{ $filters['id_kategori'] }}</span> @endif
        @if(!empty($filters['start_date'])) <span>Tanggal: {{ $filters['start_date'] }} - {{ $filters['end_date'] ?? 'sekarang' }}</span> @endif
    </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 10%">ID Pelaporan</th>
                <th style="width: 8%">NIS</th>
                <th style="width: 15%">Nama Siswa</th>
                <th style="width: 12%">Kategori</th>
                <th style="width: 10%">Lokasi</th>
                <th style="width: 15%">Keterangan</th>
                <th style="width: 10%">Status</th>
                <th style="width: 10%">Feedback</th>
                <th style="width: 7%">Progress</th>
                <th style="width: 8%">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach($aspirasi as $asp)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $asp->id_pelaporan }}</td>
                <td>{{ $asp->nis }}</td>
                <td>{{ $asp->siswa->nama ?? '-' }}</td>
                <td>{{ $asp->kategori->ket_kategori }}</td>
                <td>{{ $asp->lokasi }}</td>
                <td>
                    {{ $asp->keterangan }}
                </td>
                <td>
                    <span class="badge 
                        @if($asp->status == 'Menunggu') badge-warning
                        @elseif($asp->status == 'Diproses') badge-info
                        @elseif($asp->status == 'Selesai') badge-success
                        @else badge-danger @endif">
                        {{ $asp->status }}
                    </span>
                </td>
                <td>
                    {{ $asp->feedback ?? '-' }}
                </td>
                <td>{{ $asp->progres_perbaikan ?? 0 }}%</td>
                <td>{{ formatTanggalIndonesia($asp->created_at) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Total Data: {{ $aspirasi->count() }} aspirasi</p>
        <p>Laporan ini dicetak secara otomatis oleh sistem</p>
    </div>
</body>
</html>
