<?php

namespace App\Traits;

use App\Models\Image;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait HasImage
{
    /**
     * Relations
     */
    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    /**
     * Methods
     */
    public function attachImage(string $image_path): void
    {
        $previous_image = $this->image;

        if (is_null($previous_image)) {
            $image = new Image(['path' => $image_path]);
            $this->image()->save($image);
        } else {
            $previous_image->path = $image_path;
            $previous_image->save();
        }
    }
}
