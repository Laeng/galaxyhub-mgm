<?php

namespace App\Jobs;

use App\Action\Steam\Steam;
use App\Action\UserData\UserData;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessSteamEnquiry implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected User $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User|int $user)
    {
        if (is_int($user)) {
            $user = User::find($user);
        }

        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(UserData $userData, Steam $steam)
    {
        $userId = $this->user->id;
        $playerSummaries = $steam->getPlayerSummaries($userId)[0];

        if (!is_null($playerSummaries) && $playerSummaries->communityVisibilityState == 3) {
            $userData->set($this->user, $userData::STEAM_USER_BANS, $steam->getPlayerBans($userId));
            $userData->set($this->user, $userData::STEAM_USER_SUMMARIES, $steam->getPlayerSummaries($userId));
            //$userData->set($this->user, $userData::STEAM_USER_FRIENDS, $steam->getPlayerFriends($userId)); // HTTP 401 오류 발생.

            $userData->set($this->user, $userData::STEAM_GAME_OWNED, $steam->getOwnedGames($userId));
            $userData->set($this->user, $userData::STEAM_GAME_INFO_ARMA3, $steam->getOwnedGameInfo($userId, 107410));
        }
    }
}
