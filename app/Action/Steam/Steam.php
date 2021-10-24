<?php

namespace App\Action\Steam;

use App\Models\User;
use Illuminate\Support\Collection;
use Syntax\SteamApi\Containers\Game;
use Syntax\SteamApi\Facades\SteamApi;
use Syntax\SteamApi\Steam\App as SteamApp;
use Syntax\SteamApi\Steam\Player as SteamPlayer;
use Syntax\SteamApi\Steam\User as SteamUser;

class Steam
{
    public function getGameInfo(int $gameId): Collection
    {
        return $this->getApp()->appDetails($gameId);
    }

    public function getOwnedGames(int $userId, array $filter = []): Collection
    {
        return $this->getPlayer($userId)->GetOwnedGames(true, true, $filter);
    }

    public function getOwnedGameInfo(int $userId, int $gameId = 107410): ?Game
    {
        $owned = $this->getOwnedGames($userId, [$gameId]);

        foreach ($owned as $game) {
            if ($game->appId == $gameId) {
                return $game;
            }
        }

        return null;
    }

    public function getPlayerSummaries(int $userId): array
    {
        return $this->getUser($userId)->GetPlayerSummaries();
    }

    public function getPlayerBans(int $userId): object
    {
        return $this->getUser($userId)->GetPlayerBans();
    }





    private function getId(int $userId): int
    {
        return User::find($userId)->socials()->where('social_provider', 'steam')->latest()->first()->social_id;
    }

    private function getApp(): SteamApp
    {
        return SteamApi::app();
    }

    private function getPlayer(int $userId): SteamPlayer
    {
        return SteamApi::player($this->getId($userId));
    }

    private function getUser(int $userId): SteamUser
    {
        return SteamApi::User($this->getId($userId));
    }


}
