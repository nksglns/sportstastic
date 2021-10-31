<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    public static $validateRules = [];

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
                    $model->slug = $initialSlug.'-'.$existingSlugs;
                }
            }
        });
    }
}
