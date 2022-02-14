<?php

namespace App\Providers;

use App\Services\AuthService;
use App\Services\Contracts\AuthServiceContract;
use App\Services\Contracts\RoleServiceContract;
use App\Services\RoleService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //Services ------------------
        $this->app->bind(AuthServiceContract::class, AuthService::class);

        //---------------------------
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
