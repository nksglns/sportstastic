<?php

namespace App\Models;

use App\Traits\HasImage;
use Illuminate\Support\Str;

class Sport extends BaseModel
{
    use HasImage;

    protected $fillable = ['sport_name', 'slug', 'remote_id'];

    // Set the absolutely necessary validation rules
    public static $validateRules = [
        'remote_id' => 'integer',
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
        $this->attributes['slug'] = $this->attributes['slug'] ?? Str::slug(Str::substr($value, 0, 150));
    }
}
