<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\User;
use App\Models\Siswa;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();

        DB::beginTransaction();
        try {
            // Create user
            $user = User::create([
                'username' => $data['username'],
                'password' => bcrypt($data['password']),
                'role' => $data['role'],
            ]);

            // If role is siswa, create siswa record
            if ($data['role'] === 'siswa') {
                Siswa::create([
                    'nis' => $data['nis'],
                    'nama' => $data['nama'],
                    'kelas' => $data['kelas'],
                    'user_id' => $user->id,
                ]);
            }

            DB::commit();

            return redirect()
                ->route('admin.users.index')
                ->with('success', 'User berhasil ditambahkan' . ($data['role'] === 'siswa' ? ' dan data siswa telah dibuat.' : '.'));
        } catch (\Exception $e) {
            DB::rollback();
            return back()
                ->with('error', 'Terjadi kesalahan saat menambahkan user: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();

        if (empty($data['password'])) {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User berhasil dihapus.');
    }
}

