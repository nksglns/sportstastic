<?php

namespace App\Models;

use App\Traits\HasImage;
use Illuminate\Support\Str;

class Team extends BaseModel
{
    use HasImage;

    protected $fillable = ['team_name', 'stadium_name', 'website', 'description', 'remote_id'];

    //Hide some fields from the responses
    protected $hidden = ['id', 'pivot', 'created_at', 'updated_at', 'remote_id'];

    // Set the absolutely necessary validation rules
    public static $validateRules = [
        'remote_id' => 'integer',
        'team_name' => 'required|string|max:191',
    ];

    /**
     * Override default order by, set by team_name
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('team_name', 'asc')->get();
    }

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
        $this->attributes['slug'] = $this->attributes['slug'] ?? Str::slug(Str::substr($value, 0, 150));
    }
}
