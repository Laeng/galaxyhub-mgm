<?php

namespace App\Providers;

use App\Repositories\Base\BaseRepository;
use App\Repositories\Base\Interfaces\EloquentRepositoryInterface;
use App\Repositories\File\FileRepository;
use App\Repositories\File\Interfaces\FileRepositoryInterface;
use App\Repositories\Mission\Interfaces\MissionRepositoryInterface;
use App\Repositories\Mission\MissionRepository;
use App\Repositories\Survey\Interfaces\SurveyEntryRepositoryInterface;
use App\Repositories\Survey\Interfaces\SurveyRepositoryInterface;
use App\Repositories\Survey\SurveyEntryRepository;
use App\Repositories\Survey\SurveyRepository;
use App\Repositories\User\Interfaces\UserAccountRepositoryInterface;
use App\Repositories\User\Interfaces\UserRecordRepositoryInterface;
use App\Repositories\User\Interfaces\UserRepositoryInterface;
use App\Repositories\User\UserAccountRepository;
use App\Repositories\User\UserRecordRepository;
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

        //-- FILE
        $this->app->bind(FileRepositoryInterface::class, FileRepository::class);

        //-- MISSION
        $this->app->bind(MissionRepositoryInterface::class, MissionRepository::class);

        //-- USER
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(UserAccountRepositoryInterface::class, UserAccountRepository::class);
        $this->app->bind(UserRecordRepositoryInterface::class, UserRecordRepository::class);

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
