<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aspirasi;
use App\Models\Kategori;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Show basic dashboard statistics and data needed for charts.
     */
    public function index()
    {
        $total = Aspirasi::count();

        $statusCounts = Aspirasi::selectRaw('status, COUNT(*) as cnt')
            ->groupBy('status')
            ->pluck('cnt', 'status')
            ->toArray();

        $perKategori = Aspirasi::selectRaw('id_kategori, COUNT(*) as cnt')
            ->groupBy('id_kategori')
            ->get()
            ->mapWithKeys(fn($r) => [$r->id_kategori => $r->cnt])
            ->toArray();

        $kategoriLabels = Kategori::whereIn('id_kategori', array_keys($perKategori))
            ->pluck('ket_kategori', 'id_kategori')
            ->toArray();

        // Debug: Log data yang akan dikirim
        \Log::info('Dashboard Data:', [
            'total' => $total,
            'statusCounts' => $statusCounts,
            'perKategori' => $perKategori,
            'kategoriLabels' => $kategoriLabels
        ]);

        return view('admin.dashboard.index', compact('total', 'statusCounts', 'perKategori', 'kategoriLabels'));
    }
}
