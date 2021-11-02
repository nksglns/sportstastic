<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Interfaces\TeamRepositoryInterface;
use Illuminate\Http\Request;

class TeamController extends ApiController
{
    public function show(Request $request, TeamRepositoryInterface $teamRepository, $teamSlug)
    {
        $team = $teamRepository->findBySlug($teamSlug);
        if (!$team) {
            return $this->respondStatusOnly(404);
        }
        return $this->respond($team);
    }
}
