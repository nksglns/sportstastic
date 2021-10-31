<?php

namespace App\Repositories;

use App\Interfaces\SportRepositoryInterface;
use App\Models\Sport;
use Illuminate\Support\Collection;

class SportRepository extends BaseRepository implements SportRepositoryInterface
{
    public function __construct(Sport $model)
    {
        $this->model = $model;
    }

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function allByKey():Collection
    {
        return $this->all()->keyBy(function ($item) {
            return mb_strtolower($item['sport_name']);
        });
    }
}
