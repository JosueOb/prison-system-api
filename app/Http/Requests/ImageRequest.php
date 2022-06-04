<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'image' => ['required', 'image', 'mimes:jpg,png,jpeg', 'max:512'],//max image size is 512 kb
        ];
    }
}
