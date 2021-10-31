<?php

namespace App\Repositories;

use App\Interfaces\TeamRepositoryInterface;
use App\Models\Team;
use Illuminate\Support\Collection;

class TeamRepository extends BaseRepository implements TeamRepositoryInterface
{
    public function __construct(Team $model)
    {
        $this->model = $model;
    }

    public function save(array $data): bool
    {
        $return = parent::save($data);
        if ($return) {
            if (isset($data['leagues']) && count($data['leagues']) > 0) {
                $team = $this->model->find($data['id']);
                $team->leagues()->sync($data['leagues']);
            }
        }
        return $return;
    }

    public function all(): Collection
    {
        return $this->model->all();
    }
}
