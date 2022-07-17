<?php

namespace App\Http\Requests\Account;

use App\Rules\{Alpha, HomePhoneNumber, PhoneNumber, Username};
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileRequest extends FormRequest
{

    public function rules(): array
    {
        $allowed_date_range = config('user.allowed_date_range');

        return [
            'first_name' => ['required', 'string', new Alpha, 'min:3', 'max:35'],
            'last_name' => ['required', 'string', new Alpha, 'min:3', 'max:35'],
            'username' => ['required', 'string', new Username, 'min:5', 'max:20',
                Rule::unique('users')->ignore($this->user()->id),
            ],
            'birthdate' => ['nullable', 'string', 'date_format:Y-m-d',
                "after_or_equal:{$allowed_date_range['max']}",
                "before_or_equal:{$allowed_date_range['min']}",
            ],
            'phone_number' => ['required', 'numeric', new PhoneNumber, 'digits:10'],
            'home_phone_number' => ['nullable', 'numeric', new HomePhoneNumber, 'digits:9'],
            'address' => ['required', 'string', 'min:5', 'max:50'],
        ];
    }
}
