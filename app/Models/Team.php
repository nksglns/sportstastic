<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = ['id', 'team_name', 'stadium_name', 'website', 'description'];

}
