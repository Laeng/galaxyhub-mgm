<?php

namespace App\Providers;

use App\Action\UserData\UserData;
use App\Action\UserData\UserDataContract;
use Illuminate\Support\ServiceProvider;

class UserDataProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserDataContract::class, function (){
            return new UserData();
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
        return [UserData::class];
    }
}
