<?php

/**
 * A trait to add the image attribute on models on demand
 */

namespace App\Traits;

trait HasImage
{


    /**
     * This will add the extra "image" attribute
     * to the appends array of the model
     *
     * @return void
     */
    public function initializeHasImage()
    {
        $this->append('image');
    }

    /**
     * Sets the image attribute if an image exists for
     * this model instance
     *
     * @return string
     */
    public function getImageAttribute()
    {
        $className = $this->getClassName();
        $filename = storage_path('app/public/images/' . $className . '/' . $this->id . '.png');
        if (file_exists($filename)) {
            return asset('public/images/' . $className . '/' . $this->id . '.png');
        } else {
            return asset('images/' . $className . '_default.png');
        }
    }
}
