<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $user = $this->user();
        
        return [
            'username' => 'required|string|max:50|unique:users,username,' . $user->id,
            'nama' => 'nullable|string|max:100|required_if:role,siswa',
            'kelas' => 'nullable|string|max:20|required_if:role,siswa',
            'current_password' => 'nullable|required_with:password|string',
            'password' => 'nullable|string|min:8|confirmed',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'username.required' => 'Username harus diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'nama.required_if' => 'Nama harus diisi untuk siswa.',
            'kelas.required_if' => 'Kelas harus diisi untuk siswa.',
            'current_password.required_with' => 'Password saat ini harus diisi untuk mengubah password.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
            'password.min' => 'Password minimal 8 karakter.',
        ];
    }
}
