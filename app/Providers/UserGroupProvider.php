<?php

namespace App\Providers;

use App\Action\UserGroup\UserGroup;
use App\Action\UserGroup\UserGroupContract;
use Illuminate\Support\ServiceProvider;

class UserGroupProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(UserGroupContract::class, function (){
            return new UserGroup();
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
        return [UserGroup::class];
    }
}
