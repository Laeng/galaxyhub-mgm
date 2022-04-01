<?php

namespace App\Jobs;

use App\Enums\UserRecordType;
use App\Models\User;
use App\Repositories\User\Interfaces\UserAccountRepositoryInterface;
use App\Repositories\User\Interfaces\UserRecordRepositoryInterface;
use App\Services\Steam\Contracts\SteamServiceContract;
use App\Services\User\UserService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class CreateSteamAccount implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private User $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(UserService $userService, SteamServiceContract $steamService, UserAccountRepositoryInterface $accountRepository)
    {
        $steamAccount = $accountRepository->findSteamAccountByUserId($this->user->id)->first();

        if (!is_null($steamAccount))
        {
            $accountId = $steamAccount->account_id;
            $playerSummaries = $steamService->getPlayerSummaries($accountId);

            if ($playerSummaries['response']['players'][0]['communityvisibilitystate'] == 3)
            {
                $userId = $this->user->id;
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
                    UserRecordType::STEAM_DATA_GAMES->name => $steamService->getOwnedGames($accountId, true)['response'],
                    UserRecordType::STEAM_DATA_ARMA3->name => $steamService->getOwnedGames($accountId, true, true, [107410])['response']['games']['0'],
                    UserRecordType::STEAM_DATA_BANS->name => $steamService->getPlayerBans($accountId)['players']['0'],
                    UserRecordType::STEAM_DATA_GROUPS->name => $groups
                ];

                foreach ($data as $k => $v)
                {
                    if ($userService->getRecord($userId, $k)->count() > 0)
                    {
                        $userService->editRecord($userId, $k, $v);
                    }
                    else
                    {
                        $userService->createRecord($userId, $k, $v);
                    }
                }
            }
        }
    }
}
