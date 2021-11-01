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
}
