<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPasswordRequest;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class PasswordController extends Controller
{
    public function resendLink(Request $request): JsonResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? $this->sendResponse(__($status))
            : $this->sendResponse(
                message: 'Link reset failure.',
                errors: ['email' => __($status)],
                code: 422
            );
    }

    public function reset(ResetPasswordRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $status = Password::reset($validated, function ($user, $password) {
            $user->password = Hash::make($password);
            $user->save();
            event(new PasswordReset($user));
        });

        return $status == Password::PASSWORD_RESET
            ? $this->sendResponse(__($status))
            : $this->sendResponse(
                message: 'Reset password failure.',
                errors: ['email' => __($status)],
                code: 422
            );
    }
}
