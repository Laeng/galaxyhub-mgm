<?php

namespace App\Providers;

use App\Action\Mission\Mission;
use App\Action\Mission\MissionContract;
use Illuminate\Support\ServiceProvider;

class MissionProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(MissionContract::class, function (){
            return new Mission();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        //
    }

    public function provides(): array
    {
        return [Mission::class];
    }
}
