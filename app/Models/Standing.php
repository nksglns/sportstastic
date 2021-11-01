<?php

namespace App\Models;

class Standing extends BaseModel
{
    protected $fillable = [
        'team_id', 'league_id', 'team_rank', 'goals_for',
        'goals_against', 'goals_difference', 'wins', 'losses', 'draws', 'points',
        'season', 'remote_id'
    ];

    // Set the absolutely necessary validation rules
    public static $validateRules = [
        'team_id' => 'required|integer',
        'league_id' => 'required|integer',
        'team_rank' => 'integer',
        'goals_for' => 'integer',
        'goals_against' => 'integer',
        'goals_difference' => 'integer',
        'wins' => 'integer',
        'losses' => 'integer',
        'draws' => 'integer',
        'points' => 'integer',
        'season' => 'required|string',
        'remote_id' => 'integer',
    ];
}
