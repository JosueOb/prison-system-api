<?php

namespace App\Http\Requests\Spaces;

use App\Rules\{Alpha, JailType};
use Illuminate\Foundation\Http\FormRequest;

class JailRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', new Alpha, 'min:3', 'max:45'],
            'code' => ['required', 'string', 'alpha_dash', 'min:5', 'max:45'],
            'type' => ['required', 'string', new JailType],
            'capacity' => ['required', 'string', 'numeric', 'digits:1', 'min:2', 'max:5'],
            'ward_id' => ['required', 'string', 'numeric', 'exists:wards,id'],
            'description' => ['nullable', 'string', new Alpha, 'min:5', 'max:255'],
        ];
    }
}
