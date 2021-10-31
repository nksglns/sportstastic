<?php

namespace App\Models;

class Standing extends BaseModel
{
    protected $fillable = ['id', 'team_id', 'league_id', 'team_rank', 'goals_for',
        'goals_against', 'goals_difference', 'wins', 'losses', 'draws', 'points',
        'season',
    ];
}
