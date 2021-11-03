<?php

namespace App\Repositories;

use App\Interfaces\SportRepositoryInterface;
use App\Models\Sport;

class SportRepository extends BaseRepository implements SportRepositoryInterface
{
    public function __construct(Sport $model)
    {
        $this->model = $model;
    }

    public function leaguesBySportSlug($sportSlug)
    {
        if (!$sportSlug || !$sport = Sport::where('slug', $sportSlug)->first()) {
            return false;
        }
        return $sport->leagues()->ordered();
    }
}
