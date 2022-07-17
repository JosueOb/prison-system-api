<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema()
 */
class LoginRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @OA\Property(
     *     type="string",
     *     property="email",
     *     description="user email",
     *     default="testing@example.com",
     * )
     * @OA\Property(
     *     type="password",
     *     property="password",
     *     description="user password",
     *     default="secret",
     * )
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }
}
