<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\UpdateProfilePhotoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Show the profile edit form.
     */
    public function edit()
    {
        $user = Auth::user();
        $user->load('siswa'); // Load siswa relationship if exists
        
        return view('profile.edit', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(UpdateProfileRequest $request)
    {
        $user = Auth::user();
        
        $data = $request->validated();
        
        // Update user basic info
        if (isset($data['username'])) {
            $user->username = $data['username'];
        }
        
        // Update password if provided
        if (isset($data['current_password']) && !empty($data['current_password'])) {
            if (!Hash::check($data['current_password'], $user->password)) {
                return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.']);
            }
            
            if (isset($data['password']) && !empty($data['password'])) {
                $user->password = Hash::make($data['password']);
            }
        }
        
        // Update siswa information if user is siswa
        if ($user->isSiswa() && $user->siswa) {
            if (isset($data['nama'])) {
                $user->siswa->nama = $data['nama'];
            }
            if (isset($data['kelas'])) {
                $user->siswa->kelas = $data['kelas'];
            }
            $user->siswa->save();
        }
        
        $user->save();
        
        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Update the user's profile photo.
     */
    public function updatePhoto(UpdateProfilePhotoRequest $request)
    {
        $user = Auth::user();
        
        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            
            // Delete old photo if exists
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }
            
            // Store new photo
            $path = $file->store('profile_photos', 'public');
            $user->profile_photo = $path;
            $user->save();
            
            return back()->with('success', 'Foto profil berhasil diperbarui.');
        }
        
        return back()->withErrors(['profile_photo' => 'Tidak ada file yang diunggah.']);
    }

    /**
     * Remove the user's profile photo.
     */
    public function removePhoto()
    {
        $user = Auth::user();
        
        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
            $user->profile_photo = null;
            $user->save();
            
            return back()->with('success', 'Foto profil berhasil dihapus.');
        }
        
        return back()->with('error', 'Tidak ada foto profil untuk dihapus.');
    }
}
