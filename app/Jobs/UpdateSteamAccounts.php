<?php

namespace App\Jobs;

use App\Enums\BanCommentType;
use App\Enums\RoleType;
use App\Enums\UserRecordType;
use App\Models\User;
use App\Repositories\User\Interfaces\UserAccountRepositoryInterface;
use App\Repositories\User\Interfaces\UserRecordRepositoryInterface;
use App\Repositories\User\Interfaces\UserRepositoryInterface;
use App\Services\Steam\Contracts\SteamServiceContract;
use App\Services\User\UserService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class UpdateSteamAccounts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(UserService $userService, SteamServiceContract $steamService, UserAccountRepositoryInterface $userAccountRepository)
    {
        /**
        User::whereNull('banned_at')->latest()->chunk(100, function ($users) use ($userService, $steamService, $userAccountRepository) {
            foreach ($users as $user) {
                if ($user->hasAnyRole([RoleType::MEMBER->name, RoleType::MAKER1->name, RoleType::MAKER2->name]))
                {
                    if (!$userService->updateSteamAccount($user->id))
                    {
                        $userService->ban($user->id, BanCommentType::STEAM_PROFILE_STATUS_PRIVATE->value);
                    }
                }
            }
        });
         * **/
    }
}
