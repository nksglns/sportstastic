<?php

namespace App\Providers;

use App\Interfaces\BaseRepositoryInterface;
use App\Interfaces\SportRepositoryInterface;
use App\Interfaces\LeagueRepositoryInterface;
use App\Interfaces\TeamRepositoryInterface;
use App\Repositories\BaseRepository;
use App\Repositories\SportRepository;
use App\Repositories\LeagueRepository;
use App\Repositories\TeamRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(BaseRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(SportRepositoryInterface::class, SportRepository::class);
        $this->app->bind(LeagueRepositoryInterface::class, LeagueRepository::class);
        $this->app->bind(TeamRepositoryInterface::class, TeamRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
