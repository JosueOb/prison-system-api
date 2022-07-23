<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:5', 'max:45'],
            'description' => ['required', 'string', 'min:5', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:512'], //max image size is 512 kb
        ];
    }
}
