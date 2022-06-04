<?php

namespace App\Helper;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageHelper
{
    /***
     * Returns the path of the loaded image
     */
    static function getLoadedImagePath(
        UploadedFile $uploaded_image,
        string|null  $previous_image_path = null,
        string       $directory = 'images'
    ): string
    {
        $uploaded_image_path = $uploaded_image->store($directory);

        if ($previous_image_path && Storage::exists($previous_image_path)) {
            Storage::delete($previous_image_path);
        }

        return $uploaded_image_path;
    }
}
