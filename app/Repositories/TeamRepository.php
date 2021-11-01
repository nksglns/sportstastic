<?php

namespace App\Repositories;

use App\Interfaces\TeamRepositoryInterface;
use App\Models\Team;
use App\Models\League;
use Illuminate\Support\Facades\Log;

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
                $team = $this->model->where('remote_id', $data['remote_id'])->first();
                $leagues = League::whereIn('remote_id', $data['leagues'])->pluck('id');
                if ($leagues->count() < count($data['leagues'])) {
                    if (config('logging.log_application_warnings')) {
                        Log::warning('One or more leagues not found for the team ' . $data['remote_id']);
                    }
                }
                $team->leagues()->sync($leagues);
            }
        }
        return $return;
    }
}
