<?php

namespace App\Providers;

use App\Services\Auth\AuthService;
use App\Services\Auth\Contracts\AuthBaseServiceContract;
use App\Services\Steam\Contracts\SteamServiceContract;
use App\Services\Steam\SteamService;
use App\Services\Survey\Contracts\SurveyServiceContract;
use App\Services\Survey\SurveyService;
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
        $this->app->bind(AuthBaseServiceContract::class, AuthService::class);
        $this->app->bind(SteamServiceContract::class, SteamService::class);
        $this->app->bind(SurveyServiceContract::class, SurveyService::class);

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
