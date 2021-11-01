<?php

namespace App\Repositories;

use App\Interfaces\StandingRepositoryInterface;
use App\Models\Standing;
use App\Models\Team;
use App\Models\League;
use Illuminate\Support\Facades\Log;

class StandingRepository extends BaseRepository implements StandingRepositoryInterface
{
    public function __construct(Standing $model)
    {
        $this->model = $model;
    }

    /**
     * Override the default save method to find the local
     * team_id/league_id based on the remote_ids
     *
     * @param array $data
     *
     * @return bool
     */
    public function save(array $data): bool
    {
        //The API does not provide a sport id so get it from sport name
        $data['team_id'] = Team::where('remote_id', $data['remote_team_id'])->pluck('id')->first();
        $data['league_id'] = League::where('remote_id', $data['remote_league_id'])->pluck('id')->first();
        if (!$data['team_id']) {
            if (config('logging.log_application_warnings')) {
                Log::warning('A team id was not found for standing with id: ' . $data['remote_id'] . ' from league: ' . $data['remote_league_id']);
            }
            return false;
        }
        if (!$data['league_id']) {
            if (config('logging.log_application_warnings')) {
                Log::warning('A league id was not found for standing with id: ' . $data['remote_id'] . ' from league: ' . $data['remote_league_id']);
            }
            return false;
        }
        return parent::save($data);
    }
}
