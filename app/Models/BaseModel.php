<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    // Set an empty validateRules array to cover cases when models
    // won't have one
    public static $validateRules = [];

    // Set a default ordered by scope
    public function scopeOrdered($query)
    {
        return $query->orderBy('id', 'asc')->get();
    }


    // Use the "saving" hook to check if a slug is duplicate and
    // append a modifier accordingly on all models

    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if (isset($model->slug)) {
                $existingSlugs = 0;
                $initialSlug = $model->slug;
                //increment the slug suffix until unique
                while (self::whereSlug($model->slug)->where('id', '!=', $model->id)->count() > 0) {
                    $existingSlugs++;
                    $model->slug = $initialSlug . '-' . $existingSlugs;
                }
            }
        });
    }

    /**
     * Get the class name of the currently used model
     *
     * @return string
     */
    public function getClassName()
    {
        $classNamespace = explode('\\', get_class($this));
        return mb_strtolower(array_pop($classNamespace));
    }
}
