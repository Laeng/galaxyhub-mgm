<?php

namespace App\Providers;

use App\Action\PlayerHistory\PlayerHistory;
use App\Action\PlayerHistory\PlayerHistoryContract;
use Illuminate\Support\ServiceProvider;

class PlayerHistoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PlayerHistoryContract::class, function (){
            return new PlayerHistory();
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
        return [PlayerHistory::class];
    }
}
