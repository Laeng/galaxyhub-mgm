<?php

namespace App\Providers;

use App\Services\Azure\AzureService;
use App\Services\Azure\Contracts\AzureServiceContract;
use App\Services\Badge\BadgeService;
use App\Services\Badge\Contracts\BadgeServiceContract;
use App\Services\Discord\Contracts\DiscordServiceContract;
use App\Services\Discord\DiscordService;
use App\Services\Github\Contracts\GithubServiceContract;
use App\Services\Github\GithubService;
use App\Services\Mission\Contracts\MissionServiceContract;
use App\Services\Mission\MissionService;
use App\Services\Naver\Contracts\NaverServiceContract;
use App\Services\Naver\NaverService;
use App\Services\SSH\Contracts\SSHServiceContract;
use App\Services\SSH\SSHService;
use App\Services\User\UserService;
use App\Services\User\Contracts\UserServiceContract;
use App\Services\File\Contracts\FileServiceContract;
use App\Services\File\FileService;
use App\Services\Steam\Contracts\SteamServiceContract;
use App\Services\Steam\SteamService;
use App\Services\Survey\Contracts\SurveyServiceContract;
use App\Services\Survey\SurveyService;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\HttpFoundation\Request;

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
        $this->app->bind(AzureServiceContract::class, AzureService::class);
        $this->app->bind(BadgeServiceContract::class, BadgeService::class);
        $this->app->bind(DiscordServiceContract::class, DiscordService::class);
        $this->app->bind(FileServiceContract::class, FileService::class);
        $this->app->bind(GithubServiceContract::class, GithubService::class);
        $this->app->bind(MissionServiceContract::class, MissionService::class);
        $this->app->bind(NaverServiceContract::class, NaverService::class);
        $this->app->bind(SSHServiceContract::class, SSHService::class);
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
        Request::setTrustedProxies(
            ['REMOTE_ADDR'],
            Request::HEADER_X_FORWARDED_FOR
        );
    }
}
