<?php

namespace App\Models;

use Illuminate\Support\Str;

class Sport extends BaseModel
{
    protected $fillable = ['id', 'sport_name', 'slug'];
    public static $validateRules = [
        'id' => 'required|integer',
        'sport_name' => 'required|string|max:191',
    ];

    /**
     * Get the sport's leagues
     */
    public function leagues()
    {
        return $this->hasMany(League::class);
    }

    /**
     * Generate the slug by using the mutator of the sport_name property
     */
    public function setSportNameAttribute($value)
    {
        $this->attributes['sport_name'] = $value;
        $this->attributes['slug'] ??= Str::slug(Str::substr($value, 0, 150));
    }
}
