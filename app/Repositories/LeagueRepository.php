<?php

namespace App\Repositories;

use App\Interfaces\LeagueRepositoryInterface;
use App\Models\League;
use Illuminate\Support\Collection;

class LeagueRepository extends BaseRepository implements LeagueRepositoryInterface
{
    public function __construct(League $model)
    {
        $this->model = $model;
    }

    public function all(): Collection
    {
        return $this->model->all();
    }
}
