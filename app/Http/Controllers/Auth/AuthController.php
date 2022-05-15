<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        if (Auth::check()) {
            return $this->sendResponse(message: 'User is already authenticated.', code: 403);
        }

        $validated = $request->validated();
        if (Auth::attempt([
            'email' => $validated['email'],
            'password' => $validated['password'],
            'state' => true,
        ])) {
            $request->session()->regenerate();
            $user = Auth::user();
            $token = $user->createToken('auth-token')->plainTextToken;
            return $this->sendResponse(message: 'Successful authentication.', result: [
                'user' => new UserResource($user),
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);
        }

        return $this->sendResponse(message: 'The provided credentials are incorrect.');
    }

    public function logout(Request $request): JsonResponse
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $request->user()->tokens()->delete();

        return $this->sendResponse(message: 'Logged out');
    }
}
