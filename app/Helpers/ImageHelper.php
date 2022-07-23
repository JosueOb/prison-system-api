<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageHelper
{
    /***
     * Returns the path of the loaded image
     */
    static function getLoadedImagePath(
        UploadedFile $uploaded_image,
        string|null  $previous_image_path = null,
        string       $directory = 'images',
        string       $disk = 'dropbox'
    ): string
    {
        $uploaded_image_path = $uploaded_image->store($directory, $disk);

        if ($previous_image_path && Storage::disk($disk)->exists($previous_image_path)) {
            Storage::disk($disk)->delete($previous_image_path);
        }

        return $uploaded_image_path;
    }

    static function getDiskImageUrl(string $path, string $disk = 'dropbox'): string
    {
        return Str::startsWith($path, 'https://')
            ? $path
            : Storage::disk($disk)->url($path);
    }
}
