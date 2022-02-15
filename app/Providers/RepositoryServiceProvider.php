<?php

namespace App\Providers;

use App\Repositories\Base\BaseRepository;
use App\Repositories\Base\Interfaces\EloquentRepositoryInterface;
use App\Repositories\Mission\Interfaces\MissionRepositoryInterface;
use App\Repositories\Mission\MissionRepository;
use App\Repositories\Permission\Interfaces\RoleRepositoryInterface;
use App\Repositories\Permission\RoleRepository;
use App\Repositories\Survey\Interfaces\SurveyEntryRepositoryInterface;
use App\Repositories\Survey\Interfaces\SurveyRepositoryInterface;
use App\Repositories\Survey\SurveyEntryRepository;
use App\Repositories\Survey\SurveyRepository;
use App\Repositories\User\Interfaces\UserAccountRepositoryInterface;
use App\Repositories\User\Interfaces\UserRepositoryInterface;
use App\Repositories\User\UserAccountRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(EloquentRepositoryInterface::class, BaseRepository::class);

        //-- MISSION
        $this->app->bind(MissionRepositoryInterface::class, MissionRepository::class);

        //-- USER
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(UserAccountRepositoryInterface::class, UserAccountRepository::class);

        //-- PERMISSION
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);

        //-- SURVEY
        $this->app->bind(SurveyRepositoryInterface::class, SurveyRepository::class);
        $this->app->bind(SurveyEntryRepositoryInterface::class, SurveyEntryRepository::class);
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
