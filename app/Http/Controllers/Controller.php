<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;


/**
 * @OA\OpenApi(
 *     @OA\Server(
 *         url="/api/"
 *     ),
 *     @OA\Info(
 *         title="Prison System API",
 *         description="Prison management - Backend",
 *         version="1.0.0",
 *     ),
 * )
 *
 * @OA\Tag(
 *     name="Auth",
 *     description="Authentication routes"
 * )
 *
 * @OA\SecurityScheme(
 *     scheme="Bearer",
 *     securityScheme="Bearer",
 *     type="apiKey",
 *     in="header",
 *     name="Authorization",
 *)
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function sendResponse(
        string $message, mixed $result = [], mixed $errors = [], int $code = 200
    ): JsonResponse
    {
        $response = [
            'message' => $message,
        ];

        if (!empty($result)) {
            $response['data'] = $result;
        }
        if (!empty($errors)) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $code);
    }
}
