<?php

namespace App\Http\Controllers\Account;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\ImageRequest;
use Illuminate\Http\JsonResponse;

class AvatarController extends Controller
{
    public function store(ImageRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $user = $request->user();
        $uploaded_image_path = ImageHelper::getLoadedImagePath(
            uploaded_image: $validated['image'],
            previous_image_path: $user->image?->path,
            directory: 'avatars'
        );
        $user->attachImage($uploaded_image_path);

        return $this->sendResponse('Avatar updated successfully');
    }
}
