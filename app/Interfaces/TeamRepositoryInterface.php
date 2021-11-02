<?php

namespace App\Interfaces;

interface TeamRepositoryInterface
{
    /**
     * Find a team by it's slug
     *
     * @param string $teamSlug
     *
     * @return Team|bool
     */
    public function findBySlug($teamSlug);
}
