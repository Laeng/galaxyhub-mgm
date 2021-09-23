<?php

namespace App\Providers;

use App\Action\Group\Group;
use App\Action\Group\GroupContract;
use Illuminate\Support\ServiceProvider;

class GroupProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(GroupContract::class, function (){
            return new Group();
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
        return [Group::class];
    }
}
