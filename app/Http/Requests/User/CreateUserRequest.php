<?php

namespace App\Http\Requests\User;

use App\Rules\{Alpha, PhoneNumber, Username};
use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', new Alpha, 'min:3', 'max:35'],
            'last_name' => ['required', 'string', new Alpha, 'min:3', 'max:35'],
            'username' => ['required', 'string', new Username, 'min:5', 'max:20', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone_number' => ['required', 'numeric', new PhoneNumber, 'digits:10'],
            'address' => ['required', 'string', 'min:5', 'max:50'],
        ];
    }
}
