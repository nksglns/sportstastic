<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Standing extends Model
{
    protected $fillable = ['id', 'team_id', 'league_id', 'team_rank', 'goals_for',
        'goals_against', 'goals_difference', 'wins', 'losses', 'draws', 'points',
        'season'];

}
