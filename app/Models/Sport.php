<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use League;

class Sport extends Model
{
    protected $fillable = ['id', 'sport_name', 'slug'];

    /**
     * Get the sport's leagues
     */
    public function leagues()
    {
        return $this->hasMany(League::class);
    }
}
