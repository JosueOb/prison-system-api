<?php

namespace App\Http\Requests\User;

use App\Rules\{Alpha, PhoneNumber, Username};
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{

    public function rules(): array
    {
        $user = $this->route('user');
        return [
            'first_name' => ['required', 'string', new Alpha, 'min:3', 'max:35'],
            'last_name' => ['required', 'string', new Alpha, 'min:3', 'max:35'],
            'username' => ['required', 'string', new Username, 'min:5', 'max:20',
                Rule::unique('users')->ignore($user),
            ],
            'email' => ['required', 'string', 'email', 'max:255',
                Rule::unique('users')->ignore($user),
            ],
            'phone_number' => ['required', 'numeric', new PhoneNumber, 'digits:10'],
            'address' => ['required', 'string', 'min:5', 'max:50'],
        ];
    }
}
