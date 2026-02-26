<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        $userId = $this->route('user')->id ?? null;

        return [
            'username' => [
                'required',
                'string',
                'max:50',
                Rule::unique('users', 'username')->ignore($userId),
            ],
            'password' => ['nullable', 'string', 'min:8'],
            'role' => ['required', 'in:admin,siswa'],
        ];
    }

    public function messages(): array
    {
        return [
            'password.min' => 'Password minimal 8 karakter.',
        ];
    }
}

