<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateKategoriRequest extends FormRequest
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
        $kategori = $this->route('kategori');
        
        return [
            'ket_kategori' => 'required|string|max:100|unique:kategori,ket_kategori,' . $kategori->id_kategori . ',id_kategori',
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
            'ket_kategori.required' => 'Kategori harus diisi.',
            'ket_kategori.unique' => 'Kategori sudah ada.',
            'ket_kategori.max' => 'Kategori maksimal 100 karakter.',
        ];
    }
}
