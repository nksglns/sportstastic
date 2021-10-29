<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use League,
    Standing;

class Team extends Model
{
    protected $fillable = ['id', 'team_name', 'stadium_name', 'website', 'description'];

    /**
     * Get the team's leagues
     */
    public function leagues()
    {
        return $this->belongsToMany(League::class);
    }

    /**
     * Get the team's standings
     */
    public function standings()
    {
        return $this->hasMany(Standing::class);
    }
}
