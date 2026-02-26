<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aspirasi;
use App\Models\Kategori;
use App\Models\Siswa;
use App\Http\Requests\StoreAspirasiRequest;
use App\Http\Requests\UpdateAspirasiRequest;
use App\Http\Requests\UpdateAspirasiStatusRequest;
use App\Services\AspirasiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class AspirasiController extends Controller
{
    protected AspirasiService $service;

    public function __construct(AspirasiService $service)
    {
        $this->service = $service;
        $this->middleware('admin');
    }

    /**
     * List all aspirasi with optional filters.
     */
    public function index(Request $request)
    {
        $query = Aspirasi::with(['siswa', 'kategori']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by kategori
        if ($request->filled('id_kategori')) {
            $query->where('id_kategori', $request->id_kategori);
        }

        // Filter by NIS
        if ($request->filled('nis')) {
            $query->where('nis', $request->nis);
        }

        // Filter by search (lokasi atau keterangan)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('lokasi', 'like', "%{$search}%")
                  ->orWhere('keterangan', 'like', "%{$search}%")
                  ->orWhere('id_pelaporan', 'like', "%{$search}%");
            });
        }

        // Filter by date range
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Filter by month
        if ($request->filled('month')) {
            $query->whereMonth('created_at', $request->month);
        }
        if ($request->filled('year')) {
            $query->whereYear('created_at', $request->year);
        }

        $aspirasi = $query->orderBy('created_at', 'desc')->paginate(15);

        // Get data for filters
        $kategoris = Kategori::orderBy('ket_kategori')->get();
        $siswas = Siswa::orderBy('nama')->get();

        return view('admin.aspirasi.index', compact('aspirasi', 'kategoris', 'siswas'));
    }

    /**
     * Show a single aspirasi details.
     */
    public function show(Aspirasi $aspirasi)
    {
        $aspirasi->load(['siswa', 'kategori']);
        return view('admin.aspirasi.show', compact('aspirasi'));
    }

    /**
     * Show the form for creating a new aspirasi.
     */
    public function create()
    {
        $kategori = Kategori::all();
        $siswa = Siswa::with('user')->get();
        return view('admin.aspirasi.create', compact('kategori', 'siswa'));
    }

    /**
     * Store a newly created aspirasi in storage.
     */
    public function store(StoreAspirasiRequest $request)
    {
        $data = $request->validated();
        $data['id_pelaporan'] = generateIdPelaporan();
        
        $aspirasi = $this->service->storeAspirasi($data, $request->file('foto_bukti'), Auth::user());

        return redirect()->route('admin.aspirasi.index')->with('success', 'Aspirasi berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified aspirasi.
     */
    public function edit(Aspirasi $aspirasi)
    {
        $aspirasi->load(['siswa', 'kategori']);
        $kategori = Kategori::all();
        $siswa = Siswa::with('user')->get();
        
        return view('admin.aspirasi.edit', compact('aspirasi', 'kategori', 'siswa'));
    }

    /**
     * Update the specified aspirasi in storage.
     */
    public function update(UpdateAspirasiRequest $request, Aspirasi $aspirasi)
    {
        $data = $request->validated();
        
        $this->service->updateAspirasi($aspirasi, $data, $request->file('foto_bukti'), Auth::user());

        return redirect()->route('admin.aspirasi.index')->with('success', 'Aspirasi berhasil diperbarui.');
    }

    /**
     * Remove the specified aspirasi from storage.
     */
    public function destroy(Aspirasi $aspirasi)
    {
        $this->service->deleteAspirasi($aspirasi, Auth::user());

        return redirect()->route('admin.aspirasi.index')->with('success', 'Aspirasi berhasil dihapus.');
    }

    /**
     * Update status/feedback/progress for an aspirasi.
     */
    public function updateStatus(UpdateAspirasiStatusRequest $request, Aspirasi $aspirasi)
    {
        $this->service->updateStatus(
            $aspirasi,
            $request->input('status'),
            $request->input('feedback'),
            $request->input('progres_perbaikan'),
            Auth::user(),
        );

        return redirect()->back()->with('success', 'Status aspirasi berhasil diperbarui.');
    }

    /**
     * Export aspirasi to Excel or PDF.
     */
    public function export(Request $request)
    {
        $type = $request->get('type', 'excel');
        
        // Build query with same filters as index
        $query = Aspirasi::with(['siswa', 'kategori']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('id_kategori')) {
            $query->where('id_kategori', $request->id_kategori);
        }
        if ($request->filled('nis')) {
            $query->where('nis', $request->nis);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('lokasi', 'like', "%{$search}%")
                  ->orWhere('keterangan', 'like', "%{$search}%")
                  ->orWhere('id_pelaporan', 'like', "%{$search}%");
            });
        }
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        if ($request->filled('month')) {
            $query->whereMonth('created_at', $request->month);
        }
        if ($request->filled('year')) {
            $query->whereYear('created_at', $request->year);
        }

        $aspirasi = $query->orderBy('created_at', 'desc')->get();

        if ($type === 'pdf') {
            return $this->exportToPDF($aspirasi);
        } else {
            return $this->exportToExcel($aspirasi);
        }
    }

    /**
     * Export to Excel.
     */
private function exportToExcel($aspirasi)
{
    // Jika tidak ada data, kembalikan response kosong
    if ($aspirasi->isEmpty()) {
        return redirect()->back()->with('error', 'Tidak ada data untuk diekspor.');
    }

    $data = $aspirasi->map(function ($asp) {
        return [
            'ID Pelaporan'       => $asp->id_pelaporan,
            'NIS'                => $asp->nis,
            'Nama Siswa'         => $asp->siswa->nama ?? '-',
            'Kategori'           => $asp->kategori->ket_kategori ?? '-',
            'Lokasi'             => $asp->lokasi,
            'Keterangan'         => $asp->keterangan,
            'Status'             => $asp->status,
            'Feedback'           => $asp->feedback ?? '-',
            'Progress Perbaikan' => ($asp->progres_perbaikan ?? 0) . '%',
            'Tanggal'            => formatTanggalIndonesia($asp->created_at),
        ];
    })->toArray(); // ← pastikan toArray() dipanggil setelah map

    // Re-index agar key mulai dari 0
    $data = array_values($data);

    $filename = 'Laporan_Aspirasi_' . date('Y-m-d_H-i-s');

    return Excel::download(
        new \App\Exports\FromArrayExport($data, $filename),
        $filename . '.xlsx'
    );
}

    /**
     * Export to PDF.
     */
    private function exportToPDF($aspirasi)
    {
        $data = [
            'aspirasi' => $aspirasi,
            'title' => 'Laporan Aspirasi',
            'date' => date('d/m/Y H:i:s'),
            'filters' => request()->all(),
        ];

        $pdf = PDF::loadView('admin.aspirasi.pdf', $data);
        $filename = 'aspirasi_' . date('Y-m-d_H-i-s') . '.pdf';
        
        return $pdf->download($filename);
    }
}
