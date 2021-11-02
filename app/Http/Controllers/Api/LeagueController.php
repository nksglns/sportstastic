<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Interfaces\LeagueRepositoryInterface;
use App\Models\League;
use Illuminate\Http\Request;

class LeagueController extends ApiController
{
    public function teamsByLeague(Request $request, LeagueRepositoryInterface $leagueRepository, $slug = null)
    {
        $teams = $leagueRepository->teamsByLeagueSlug($slug);
        if (!$teams) {
            return $this->respondStatusOnly(404);
        }
        return $this->respond($teams);
    }
}
