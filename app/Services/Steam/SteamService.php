<?php

namespace App\Services\Steam;

use App\Services\Steam\Contracts\SteamServiceContract;
use Auauauauauauau\SteamWebApi\SteamApiClient;
use Auauauauauauau\SteamWebApi\SteamInterface\IPlayerService;
use Auauauauauauau\SteamWebApi\SteamInterface\ISteamUser;
use function config;

/**
 * Class SteamService
 * @package App\Services
 */
class SteamService implements SteamServiceContract
{
    private string $steamApiKey;
    private SteamApiClient $steamApi;

    public function __construct()
    {
        $this->steamApiKey = config('services.steam.key');
        $this->steamApi = new SteamApiClient($this->steamApiKey);
    }

    public function getOwnedGames(int $steamId, bool $includeAppInfo = true, bool $includePlayedFreeGames = false, array $appIdsFilter = []): array
    {
        //free sub 0 => https://steamdb.info/sub/0/
        $playerService = new IPlayerService($this->steamApi);

        return $playerService->GetOwnedGamesV1($appIdsFilter, $includeAppInfo, false, $includePlayedFreeGames, $this->steamApiKey, $steamId);
    }

    public function getPlayerSummaries(int $steamId): array
    {
        $userService = new ISteamUser($this->steamApi);

        return $userService->GetPlayerSummariesV2($this->steamApiKey, $steamId);
    }
}
