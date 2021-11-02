<?php

namespace App\Interfaces;

interface LeagueRepositoryInterface
{
    /**
     * @param string $leagueSlug
     *
     * @return Collection|false
     */
    public function teamsByLeagueSlug($leagueSlug);
}
