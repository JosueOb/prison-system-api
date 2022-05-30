<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Http\Resources\ProfileResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show(): JsonResponse
    {
        $user = Auth::user();
        return $this->sendResponse(message: "Successfully getting the user's profile", result: [
            'user' => new ProfileResource($user),
            'avatar' => 'example.png' #TODO: Get the user's avatar.
        ]);
    }

    public function store(ProfileRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $user = $request->user();
        $user->fill($validated)->save();

        return $this->sendResponse('Profile successfully updated');
    }
}
