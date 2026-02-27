<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateAspirasiStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        // assume authorization is handled by middleware (admin)
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'status' => ['required', 'in:Menunggu,Diproses,Selesai,Ditolak'],
            'feedback' => ['nullable', 'string'],
            'progres_perbaikan' => ['nullable', 'integer', 'min:0', 'max:100'],
        ];
    }
}
