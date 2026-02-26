<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notifikasi;

class DashboardController extends Controller
{
    /**
     * Show the siswa dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        $siswa = $user->siswa;
        
        if (!$siswa) {
            return redirect()->route('profile.edit')->with('error', 'Data siswa tidak lengkap. Silakan lengkapi profil Anda.');
        }
        
        // Get aspirasi statistics
        $totalAspirasi = $siswa->aspirasi()->count();
        $pendingAspirasi = $siswa->aspirasi()->where('status', 'Menunggu')->count();
        $processedAspirasi = $siswa->aspirasi()->where('status', 'Diproses')->count();
        $completedAspirasi = $siswa->aspirasi()->where('status', 'Selesai')->count();
        $rejectedAspirasi = $siswa->aspirasi()->where('status', 'Ditolak')->count();
        
        // Get recent aspirasi
        $recentAspirasi = $siswa->aspirasi()
            ->with('kategori')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Get notification data
        $unreadCount = Notifikasi::where('user_id', $user->id)
            ->where('is_read', false)
            ->count();
        
        return view('siswa.dashboard.index', compact(
            'siswa',
            'totalAspirasi',
            'pendingAspirasi',
            'processedAspirasi',
            'completedAspirasi',
            'rejectedAspirasi',
            'recentAspirasi',
            'unreadCount'
        ));
    }
}
