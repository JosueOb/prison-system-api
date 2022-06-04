<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdatePasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'password' => [
                'required', 'string', 'confirmed',
                Password::defaults()->mixedCase()->numbers()->symbols(),
            ],
        ];
    }
}
