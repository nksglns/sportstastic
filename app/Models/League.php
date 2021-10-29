<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Team,
    Sport;

class League extends Model
{
    protected $fillable = ['id', 'league_name', 'slug'];

    /**
     * Get the league's teams
     */
    public function teams()
    {
        return $this->belongsToMany(Team::class);
    }

    /**
     * Get the league's sport
     */
    public function sport()
    {
        return $this->belongsTo(Sport::class);
    }
}
