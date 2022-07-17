<?php

namespace App\Http\Requests\Spaces;

use App\Rules\Alpha;
use Illuminate\Foundation\Http\FormRequest;

class WardRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', new Alpha, 'min:3', 'max:45'],
            'location' => ['required', 'string', new Alpha, 'min:3', 'max:45'],
            'description' => ['nullable', 'string', new Alpha, 'min:5', 'max:255'],
        ];
    }
}
