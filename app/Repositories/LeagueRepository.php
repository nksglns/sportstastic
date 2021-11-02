<?php

namespace App\Repositories;

use App\Interfaces\LeagueRepositoryInterface;
use App\Models\League;
use App\Models\Sport;
use Illuminate\Support\Facades\Log;

class LeagueRepository extends BaseRepository implements LeagueRepositoryInterface
{
    public function __construct(League $model)
    {
        $this->model = $model;
    }

    /**
     * Override the save method to find the sport_id
     * based on the sport's name
     *
     * @param array $data
     *
     * @return bool
     */
    public function save(array $data): bool
    {
        //The API does not provide a sport id so get it from sport name
        $data['sport_id'] = Sport::where('sport_name', $data['sport_name'])->pluck('id')->first();
        if (!$data['sport_id']) {
            if (config('logging.log_application_warnings')) {
                Log::warning('A sport id was not found for ' . $data['league_name']);
            }
            return false;
        }
        return parent::save($data);
    }

    public function teamsByLeagueSlug($leagueSlug)
    {
        if (!$leagueSlug || !$league = League::where('slug', $leagueSlug)->first()) {
            return false;
        }
        return $league->teams()->with('leagues', 'standings', 'standings.league')->get();
    }
}
