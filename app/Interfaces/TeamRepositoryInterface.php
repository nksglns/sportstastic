<?php

namespace App\Interfaces;

use Illuminate\Support\Collection;

interface TeamRepositoryInterface
{
    public function all():Collection;
}
