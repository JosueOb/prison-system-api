<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    private array $discarded_role_names = ['prisoner'];

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
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Content."
     *     ),
     * )
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $user = User::where('email', $validated['email'])->first();

        if (!$user ||
            !$user->state ||
            in_array($user->role->slug, $this->discarded_role_names) ||
            !Hash::check($validated['password'], $user->password)
        ) {
            return $this->sendResponse(message: 'The provided credentials are incorrect.', code: 404);
        }

        if (!$user->tokens->isEmpty()) {
            return $this->sendResponse(message: 'User is already authenticated.', code: 403);
        }

        $token = $user->createToken('auth-token')->plainTextToken;

        return $this->sendResponse(message: 'Successful authentication.', result: [
            'user' => new UserResource($user),
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    /**
     * @OA\Post(
     *     path="/logout",
     *     tags={"Auth"},
     *     summary="Logout",
     *     operationId="user.logout",
     *     security={{ "sanctum":{""} }},
     *     @OA\Response(
     *         response=200,
     *         description="Logged out."
     *     ),
     *      @OA\Response(
     *         response=401,
     *         description="Unauthorized."
     *     ),
     * )
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();
        return $this->sendResponse(message: 'Logged out.');
    }
}
