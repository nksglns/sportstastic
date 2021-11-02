<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Interfaces\SportRepositoryInterface;
use App\Models\Sport;
use Illuminate\Http\Request;

class SportController extends ApiController
{
    public function index(Request $request, SportRepositoryInterface $sportRepository)
    {
        return $this->respond($sportRepository->all());
    }

    public function leaguesBySport(Request $request, SportRepositoryInterface $sportRepository, $sportSlug = null)
    {
        $leagues = $sportRepository->leaguesBySportSlug($sportSlug);
        if (!$leagues) {
            return $this->respondStatusOnly(404);
        }
        return $this->respond($leagues);
    }
}
