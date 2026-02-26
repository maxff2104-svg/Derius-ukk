<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\User;
use App\Http\Requests\StoreSiswaRequest;
use App\Http\Requests\UpdateSiswaRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $siswa = Siswa::with(['user', 'aspirasi'])->orderBy('nama')->paginate(15);
        return view('admin.siswa.index', compact('siswa'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.siswa.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSiswaRequest $request)
    {
        $data = $request->validated();
        
        // Create user account
        $user = User::create([
            'username' => $data['nis'],
            'password' => Hash::make($data['password']),
            'role' => 'siswa',
        ]);
        
        // Create siswa record
        Siswa::create([
            'nis' => $data['nis'],
            'nama' => $data['nama'],
            'kelas' => $data['kelas'],
            'user_id' => $user->id,
        ]);
        
        return redirect()->route('admin.siswa.index')->with('success', 'Siswa berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Siswa $siswa)
    {
        $siswa->load(['user', 'aspirasi' => function($query) {
            $query->with('kategori')->orderBy('created_at', 'desc');
        }]);
        return view('admin.siswa.show', compact('siswa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Siswa $siswa)
    {
        $siswa->load('user');
        return view('admin.siswa.edit', compact('siswa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSiswaRequest $request, Siswa $siswa)
    {
        $data = $request->validated();
        
        // Update siswa record
        $siswa->update([
            'nama' => $data['nama'],
            'kelas' => $data['kelas'],
        ]);
        
        // Update user account if needed
        if (isset($data['password']) && !empty($data['password'])) {
            $siswa->user->update([
                'password' => Hash::make($data['password']),
            ]);
        }
        
        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Siswa $siswa)
    {
        // Check if siswa has aspirasi
        if ($siswa->aspirasi()->count() > 0) {
            return back()->with('error', 'Siswa tidak dapat dihapus karena masih memiliki aspirasi.');
        }
        
        // Delete user account
        $siswa->user->delete();
        
        return redirect()->route('admin.siswa.index')->with('success', 'Siswa berhasil dihapus.');
    }
}
