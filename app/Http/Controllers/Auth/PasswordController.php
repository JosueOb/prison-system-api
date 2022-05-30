<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPasswordRequest;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\{JsonResponse, Request};
use Illuminate\Support\Facades\{Hash, Password};

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

    public function restore(ResetPasswordRequest $request): JsonResponse
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

    public function redirectReset(Request $request): JsonResponse
    {
        $frontend_url = env('APP_FRONTEND_URL');
        $token = $request->route('token');
        $email = $request->email;
        $url = "$frontend_url/?token=$token&email=$email";
        return $this->sendResponse(message: 'Successful redirection', result: ['url' => $url]);
        /*TODO: Uncomment when the frontend is running*/
        //return redirect()->away($url);
    }
}
