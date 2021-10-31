<?php

namespace App\Interfaces;

use Illuminate\Support\Collection;

interface DataSourceApiInterface
{

    /**
     * Fetches a collection of sports from the API
     *
     * @return Collection
     */
    public function fetchSports():Collection;

    /**
     * Fetches a collection of leagues from the API
     *
     * @return Collection
     */
    public function fetchLeagues():Collection;

    /**
     * Fetches a collection of teams participating in a league from the API
     *
     * @param int $league_id
     *
     * @return Collection
     */
    public function fetchTeams(int $league_id):Collection;

    /**
     * Fetches a collection of team standings from the API
     *
     * @param int $team_id
     *
     * @return Collection
     */
    public function fetchStandings(int $team_id):Collection;
}
