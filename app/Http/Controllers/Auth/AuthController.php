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

    /**
     * @OA\Post(
     *     path="/login",
     *     tags={"Auth"},
     *     summary="Login",
     *     operationId="user.login",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 ref="#/components/schemas/LoginRequest",
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful authentication."
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="User is already authenticated."
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="The provided credentials are incorrect."
     *     ),
     * )
     */
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

        return $this->sendResponse(message: 'The provided credentials are incorrect.', code: 404);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $request->user()->tokens()->delete();

        return $this->sendResponse(message: 'Logged out');
    }
}
