<?php

namespace App\Models;

use Illuminate\Support\Str;

class Team extends BaseModel
{
    protected $fillable = ['id', 'team_name', 'stadium_name', 'website', 'description'];
    public static $validateRules = [
        'id' => 'required|integer',
        'team_name' => 'required|string|max:191',
    ];

    /**
     * Get the team's leagues
     */
    public function leagues()
    {
        return $this->belongsToMany(League::class, 'team_league');
    }

    /**
     * Get the team's standings
     */
    public function standings()
    {
        return $this->hasMany(Standing::class);
    }

    /**
     * Generate the slug by using the mutator of the team_name property
     */
    public function setTeamNameAttribute($value)
    {
        $this->attributes['team_name'] = $value;
        $this->attributes['slug'] ??= Str::slug(Str::substr($value, 0, 150));
    }
}
