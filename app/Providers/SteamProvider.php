<?php

namespace App\Providers;

use App\Action\Steam\Steam;
use App\Action\Steam\SteamContract;
use Illuminate\Support\ServiceProvider;

class SteamProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(SteamContract::class, function (){
            return new Steam();
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

    public function provides(): array
    {
        return [Steam::class];
    }
}
