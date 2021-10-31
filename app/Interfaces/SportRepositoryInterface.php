<?php

namespace App\Interfaces;

use Illuminate\Support\Collection;

interface SportRepositoryInterface
{
    public function all():Collection;
    public function allByKey():Collection;
}
