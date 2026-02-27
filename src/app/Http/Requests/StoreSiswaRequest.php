<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSiswaRequest extends FormRequest
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
        return [
            'nis' => 'required|string|max:20|unique:siswa,nis|unique:users,username',
            'nama' => 'required|string|max:100',
            'kelas' => 'required|string|max:20',
            'password' => 'required|string|min:6',
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
            'nis.required' => 'NIS harus diisi.',
            'nis.unique' => 'NIS sudah digunakan.',
            'nis.max' => 'NIS maksimal 20 karakter.',
            'nama.required' => 'Nama harus diisi.',
            'nama.max' => 'Nama maksimal 100 karakter.',
            'kelas.required' => 'Kelas harus diisi.',
            'kelas.max' => 'Kelas maksimal 20 karakter.',
            'password.required' => 'Password harus diisi.',
            'password.min' => 'Password minimal 6 karakter.',
        ];
    }
}
