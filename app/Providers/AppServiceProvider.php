<?php

namespace App\Providers;

use App\Services\User\UserService;
use App\Services\User\Contracts\UserServiceContract;
use App\Services\File\Contracts\FileServiceContract;
use App\Services\File\FileService;
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
        $this->app->bind(FileServiceContract::class, FileService::class);
        $this->app->bind(SteamServiceContract::class, SteamService::class);
        $this->app->bind(SurveyServiceContract::class, SurveyService::class);
        $this->app->bind(UserServiceContract::class, UserService::class);

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
