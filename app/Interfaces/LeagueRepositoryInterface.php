<?php

namespace App\Interfaces;

use Illuminate\Support\Collection;

interface LeagueRepositoryInterface
{
    public function all():Collection;
}
