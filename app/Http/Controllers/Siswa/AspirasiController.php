<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAspirasiRequest;
use App\Models\Aspirasi;
use App\Models\Kategori;
use App\Services\AspirasiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AspirasiController extends Controller
{
    protected AspirasiService $service;

    public function __construct(AspirasiService $service)
    {
        $this->service = $service;
        $this->middleware('siswa');
    }

    /**
     * List aspirasi for the authenticated siswa.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $nis = $user->siswa->nis ?? $request->input('nis');

        $aspirasi = Aspirasi::with('kategori')
            ->where('nis', $nis)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('siswa.aspirasi.index', compact('aspirasi'));
    }

    /**
     * Show the form for creating a new aspirasi.
     */
    public function create()
    {
        $kategori = Kategori::all();
        return view('siswa.aspirasi.create', compact('kategori'));
    }

    /**
     * Store a new aspirasi by siswa.
     */
    public function store(StoreAspirasiRequest $request)
    {
        $user = Auth::user();
        $nis = $user->siswa->nis ?? $request->input('nis');

        $data = $request->validated();
        $data['nis'] = $nis;

        $this->service->storeAspirasi($data, $request->file('foto_bukti'), $user);

        return redirect()->route('siswa.aspirasi.index')->with('success', 'Aspirasi berhasil dikirim.');
    }

    /**
     * Show a single aspirasi for siswa (ownership enforced).
     */
    public function show(Aspirasi $aspirasi)
    {
        $user = Auth::user();
        if ($user->role === 'siswa' && $user->siswa && $user->siswa->nis !== $aspirasi->nis) {
            abort(403);
        }

        return view('siswa.aspirasi.show', compact('aspirasi'));
    }

    /**
     * Show the form for editing the specified aspirasi.
     */
    public function edit(Aspirasi $aspirasi)
    {
        $user = Auth::user();
        
        // Check ownership
        if ($user->siswa->nis !== $aspirasi->nis) {
            abort(403);
        }

        // Check if aspirasi can be edited (only if status is 'Menunggu' and no feedback)
        if ($aspirasi->status !== 'Menunggu' || !empty($aspirasi->feedback) || !empty($aspirasi->progres_perbaikan)) {
            return redirect()->route('siswa.aspirasi.show', $aspirasi)
                ->with('error', 'Aspirasi tidak dapat diedit karena sudah diproses atau ada feedback dari admin.');
        }

        $kategori = Kategori::all();
        return view('siswa.aspirasi.edit', compact('aspirasi', 'kategori'));
    }

    /**
     * Update the specified aspirasi.
     */
    public function update(Request $request, Aspirasi $aspirasi)
    {
        $user = Auth::user();
        
        // Check ownership
        if ($user->siswa->nis !== $aspirasi->nis) {
            abort(403);
        }

        // Check if aspirasi can be updated
        if ($aspirasi->status !== 'Menunggu' || !empty($aspirasi->feedback) || !empty($aspirasi->progres_perbaikan)) {
            return redirect()->route('siswa.aspirasi.show', $aspirasi)
                ->with('error', 'Aspirasi tidak dapat diperbarui karena sudah diproses atau ada feedback dari admin.');
        }

        $request->validate([
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'lokasi' => 'required|string|max:255',
            'keterangan' => 'required|string',
        ]);

        $aspirasi->update([
            'id_kategori' => $request->id_kategori,
            'lokasi' => $request->lokasi,
            'keterangan' => $request->keterangan,
        ]);

        // Handle new photo if uploaded
        if ($request->hasFile('foto_bukti')) {
            $this->service->updateAspirasiPhoto($aspirasi, $request->file('foto_bukti'));
        }

        return redirect()->route('siswa.aspirasi.show', $aspirasi)
            ->with('success', 'Aspirasi berhasil diperbarui.');
    }

    /**
     * Remove the specified aspirasi.
     */
    public function destroy(Aspirasi $aspirasi)
    {
        $user = Auth::user();
        
        // Check ownership
        if ($user->siswa->nis !== $aspirasi->nis) {
            abort(403);
        }

        // Check if aspirasi can be deleted
        if ($aspirasi->status !== 'Menunggu' || !empty($aspirasi->feedback) || !empty($aspirasi->progres_perbaikan)) {
            return redirect()->route('siswa.aspirasi.show', $aspirasi)
                ->with('error', 'Aspirasi tidak dapat dihapus karena sudah diproses atau ada feedback dari admin.');
        }

        // Delete photo if exists
        if ($aspirasi->foto_bukti) {
            $this->service->deleteAspirasiPhoto($aspirasi->foto_bukti);
        }

        $aspirasi->delete();

        return redirect()->route('siswa.aspirasi.index')
            ->with('success', 'Aspirasi berhasil dihapus.');
    }
}
