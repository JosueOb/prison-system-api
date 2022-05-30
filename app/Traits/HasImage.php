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
     * TODO: Store and update image
     */
    public function getImage(): string
    {
        if (!$this->image) {
            return env(
                'DEFAULT_USER_AVATAR',
                'https://cdn-icons-png.flaticon.com/512/711/711769.png'
            );
        }
        return $this->image->path;
    }
}
