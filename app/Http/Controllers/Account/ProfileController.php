<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\ProfileRequest;
use App\Http\Resources\ProfileResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show(): JsonResponse
    {
        $user = Auth::user();
        return $this->sendResponse(message: "User's profile returned successfully", result: [
            'user' => new ProfileResource($user),
            'avatar' => $user->getAvatarPath()
        ]);
    }

    public function store(ProfileRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $user = $request->user();
        $user->fill($validated)->save();

        return $this->sendResponse('Profile updated successfully');
    }
}
