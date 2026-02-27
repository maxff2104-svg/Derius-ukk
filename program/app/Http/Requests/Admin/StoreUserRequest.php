<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        $rules = [
            'username' => ['required', 'string', 'max:50', 'unique:users,username'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', 'in:admin,siswa'],
        ];

        // If role is siswa, add siswa-specific fields
        if ($this->input('role') === 'siswa') {
            $rules['nis'] = ['required', 'string', 'max:20', 'unique:siswa,nis'];
            $rules['nama'] = ['required', 'string', 'max:100'];
            $rules['kelas'] = ['required', 'string', 'max:50'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'nis.required' => 'NIS wajib diisi.',
            'nis.unique' => 'NIS sudah terdaftar.',
            'nama.required' => 'Nama siswa wajib diisi.',
            'kelas.required' => 'Kelas wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
        ];
    }
}

