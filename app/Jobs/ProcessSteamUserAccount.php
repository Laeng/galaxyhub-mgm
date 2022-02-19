<?php

namespace App\Jobs;

use App\Models\User;
use App\Repositories\User\Interfaces\UserAccountRepositoryInterface;
use App\Repositories\User\Interfaces\UserRecordRepositoryInterface;
use App\Services\Steam\Contracts\SteamServiceContract;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class ProcessSteamUserAccount implements ShouldQueue
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
    public function handle(UserAccountRepositoryInterface $accountRepository, UserRecordRepositoryInterface $recordRepository, SteamServiceContract $steamService)
    {
        $steamAccount = $accountRepository->findByUserId($this->user->id)?->filter(fn ($v, $k) => $v->provider === 'steam')?->first();

        if (!is_null($steamAccount))
        {
            $playerSummaries = $steamService->getPlayerSummaries($steamAccount->account_id);

            if ($playerSummaries['response']['players'][0]['communityvisibilitystate'] == 3)
            {
                $userId = $this->user->id;
                $accountId = $steamAccount->account_id;
                $uuid = $recordRepository->getUUIDv5($accountId);
                $data = [
                    $this->user::RECORD_STEAM_DATA_SUMMARIES => $playerSummaries,
                    $this->user::RECORD_STEAM_DATA_GAMES => $steamService->getOwnedGames($accountId, true)['response'],
                    $this->user::RECORD_STEAM_DATA_ARMA3 => $steamService->getOwnedGames($accountId, true, true, [107410])['response']['games']['0'],
                    $this->user::RECORD_STEAM_DATA_BANS => $steamService->getPlayerBans($accountId)['players']['0'],
                    $this->user::RECORD_STEAM_DATA_GROUPS => $steamService->getGroupSummary($playerSummaries['response']['players'][0]['primaryclanid'])
                ];

                foreach ($data as $k => $v)
                {
                    $recordRepository->create([
                        'user_id' => $userId,
                        'type' => $k,
                        'data' => $v,
                        'uuid' => $uuid
                    ]);
                }
            }
        }
    }
}
