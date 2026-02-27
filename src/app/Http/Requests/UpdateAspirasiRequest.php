<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAspirasiRequest extends FormRequest
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
            'nis' => 'required|exists:siswa,nis',
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'lokasi' => 'required|string|max:150',
            'keterangan' => 'required|string',
            'foto_bukti' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
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
            'nis.required' => 'NIS siswa harus dipilih.',
            'nis.exists' => 'NIS siswa tidak valid.',
            'id_kategori.required' => 'Kategori harus dipilih.',
            'id_kategori.exists' => 'Kategori tidak valid.',
            'lokasi.required' => 'Lokasi harus diisi.',
            'lokasi.max' => 'Lokasi maksimal 150 karakter.',
            'keterangan.required' => 'Keterangan harus diisi.',
            'foto_bukti.image' => 'File harus berupa gambar.',
            'foto_bukti.mimes' => 'Format file harus jpg, jpeg, atau png.',
            'foto_bukti.max' => 'Ukuran file maksimal 2MB.',
        ];
    }
}
