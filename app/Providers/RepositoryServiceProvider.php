<?php

namespace App\Providers;

use App\Repositories\Badge\BadgeRepository;
use App\Repositories\Badge\Interfaces\BadgeRepositoryInterface;
use App\Repositories\Ban\BanRepository;
use App\Repositories\Ban\Interfaces\BanRepositoryInterface;
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
use App\Repositories\Updater\Interfaces\UpdaterRepositoryInterface;
use App\Repositories\Updater\UpdaterRepository;
use App\Repositories\User\Interfaces\UserAccountRepositoryInterface;
use App\Repositories\User\Interfaces\UserBadgeRepositoryInterface;
use App\Repositories\User\Interfaces\UserMissionRepositoryInterface;
use App\Repositories\User\Interfaces\UserRecordRepositoryInterface;
use App\Repositories\User\Interfaces\UserRepositoryInterface;
use App\Repositories\User\UserAccountRepository;
use App\Repositories\User\UserBadgeRepositroy;
use App\Repositories\User\UserMissionRepository;
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

        //-- BADGE
        $this->app->bind(BadgeRepositoryInterface::class, BadgeRepository::class);

        //-- BAN
        $this->app->bind(BanRepositoryInterface::class, BanRepository::class);

        //-- FILE
        $this->app->bind(FileRepositoryInterface::class, FileRepository::class);

        //-- MISSION
        $this->app->bind(MissionRepositoryInterface::class, MissionRepository::class);

        //-- USER
        $this->app->bind(UserBadgeRepositoryInterface::class, UserBadgeRepositroy::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(UserAccountRepositoryInterface::class, UserAccountRepository::class);
        $this->app->bind(UserMissionRepositoryInterface::class, UserMissionRepository::class);
        $this->app->bind(UserRecordRepositoryInterface::class, UserRecordRepository::class);

        //-- UPDATER
        $this->app->bind(UpdaterRepositoryInterface::class, UpdaterRepository::class);

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
