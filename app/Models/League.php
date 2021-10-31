<?php

namespace App\Models;

use Illuminate\Support\Str;

class League extends BaseModel
{
    protected $fillable = ['id', 'league_name', 'slug', 'sport_id'];
    public static $validateRules = [
        'id' => 'required|integer',
        'league_name' => 'required|string|max:191',
    ];

    /**
     * Get the league's teams
     */
    public function teams()
    {
        return $this->belongsToMany(Team::class, 'team_league');
    }

    /**
     * Get the league's sport
     */
    public function sport()
    {
        return $this->belongsTo(Sport::class);
    }

    /**
     * Generate the slug by using the mutator of the league_name property
     */
    public function setLeagueNameAttribute($value)
    {
        $this->attributes['league_name'] = $value;
        $this->attributes['slug'] ??= Str::slug(Str::substr($value, 0, 150));
    }
}
