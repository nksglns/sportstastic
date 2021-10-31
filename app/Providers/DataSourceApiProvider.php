<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\DataSourceApiInterface;
use App\Services\SportsdbApiService;

class DataSourceApiProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(DataSourceApiInterface::class, function ($app) {
            return new SportsdbApiService;
        });
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
