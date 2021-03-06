<?php

namespace App\Models;

use Illuminate\Support\Str;

class League extends BaseModel
{
    protected $fillable = ['league_name', 'slug', 'sport_id', 'remote_id'];

    //Hide some fields from the responses
    protected $hidden = ['id', 'sport_id', 'pivot', 'created_at', 'updated_at', 'remote_id'];

    // Set the absolutely necessary validation rules
    public static $validateRules = [
        'remote_id' => 'integer',
        'league_name' => 'required|string|max:191',
    ];

    /**
     * Override default order by, set by league_name
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('league_name', 'asc')->get();
    }

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
        $this->attributes['slug'] = $this->attributes['slug'] ?? Str::slug(Str::substr($value, 0, 150));
    }
}
