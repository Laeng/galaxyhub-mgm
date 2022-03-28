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
        User::whereNull('banned_at')->latest()->chunk(100, function ($users) use ($userService, $steamService, $userAccountRepository) {
            foreach ($users as $user) {
                if ($user->hasAnyRole([RoleType::MEMBER->name, RoleType::MAKER1->name, RoleType::MAKER2->name]))
                {
                    $steamAccount = $userAccountRepository->findSteamAccountByUserId($user->id)->first();

                    if (is_null($steamAccount)) continue;

                    $userId = $user->id;
                    $accountId = $steamAccount->account_id;
                    $playerSummaries = $steamService->getPlayerSummaries($accountId);

                    if ($playerSummaries['response']['players'][0]['communityvisibilitystate'] == 3)
                    {
                        $steamOwnedGames = $steamService->getOwnedGames($steamAccount->account_id);

                        if (count($steamOwnedGames['response']) > 0)
                        {
                            $playerGroups = $steamService->getPlayerGroups($playerSummaries['response']['players'][0]['steamid'])['response']['groups'];
                            $groups = array();

                            if (count($playerGroups) > 0)
                            {
                                foreach($playerGroups as $id)
                                {
                                    $data = $steamService->getGroupSummary($id['gid']);
                                    $groups[] = array_merge($data['groupDetails'], ['groupID64' => $data['groupID64']]);
                                }
                            }

                            $data = [
                                UserRecordType::STEAM_DATA_SUMMARIES->name => $playerSummaries['response']['players'][0],
                                UserRecordType::STEAM_DATA_GAMES->name => $steamOwnedGames['response'],
                                UserRecordType::STEAM_DATA_ARMA3->name => $steamService->getOwnedGames($accountId, true, true, [107410])['response']['games']['0'],
                                UserRecordType::STEAM_DATA_BANS->name => $steamService->getPlayerBans($accountId)['players']['0'],
                                UserRecordType::STEAM_DATA_GROUPS->name => $groups
                            ];

                            foreach ($data as $k => $v)
                            {
                                $userService->editRecord($userId, $k, $v);
                            }

                            continue;
                        }
                    }

                    $userService->ban($userId, BanCommentType::STEAM_PROFILE_STATUS_PRIVATE->name);
                }
            }
        });
    }
}
