<?php

namespace App\Interfaces;


interface SportRepositoryInterface
{

    /**
     * @param string $sportSlug
     *
     * @return Collection|bool
     */
    public function leaguesBySportSlug($sportSlug);
}
