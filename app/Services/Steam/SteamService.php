<?php

namespace App\Services\Steam;

use App\Services\Steam\Client\Services\ISteamUser;
use App\Services\Steam\Contracts\SteamServiceContract;
use App\Services\Steam\Client\SteamApiClient;
use App\Services\Steam\Client\Services\IPlayerService;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use function config;

/**
 * Class SteamService
 * @package App\Services
 */
class SteamService implements SteamServiceContract
{
    private string $steamApiKey;
    private SteamApiClient $steamApi;
    private IPlayerService $playerService;
    private ISteamUser $steamUser;

    public function __construct()
    {
        $this->steamApiKey = config('services.steam.key');
        $this->steamApi = new SteamApiClient($this->steamApiKey);
        $this->playerService = new IPlayerService($this->steamApi);
        $this->steamUser = new ISteamUser($this->steamApi);
    }

    public function getOwnedGames(int $steamId, bool $includeAppInfo = true, bool $includePlayedFreeGames = false, array $appIdsFilter = []): array
    {
        //free sub 0 => https://steamdb.info/sub/0/
        return $this->playerService->GetOwnedGamesV1($appIdsFilter, $includeAppInfo, false, $includePlayedFreeGames, $this->steamApiKey, $steamId);
    }

    public function getPlayerSummaries(int $steamId): array
    {
        return $this->steamUser->GetPlayerSummariesV2($this->steamApiKey, $steamId);
    }

    public function getPlayerBans(int $steamId): array
    {
        return $this->steamUser->GetPlayerBansV1($this->steamApiKey, $steamId);
    }

    public function getPlayerGroups(int $steamId): array
    {
        return $this->steamUser->GetUserGroupListV1($this->steamApiKey, $steamId);
    }

    public function getGroupSummary(int $steamGroupId): array
    {
        if ($steamGroupId == 103582791429521408) return [];

        $webClient = new Client([
            'base_uri' => 'http://steamcommunity.com/',
        ]);

        try
        {
            $response = $webClient->request('GET',"gid/{$steamGroupId}/memberslistxml", ['xml' => 1]);

            $data = $response->getBody()->getContents(); //FIXME - 일부 엣지 케이스에서 작동 안함... https://steamcommunity.com/id/Hawkeye1213/
            $xml = simplexml_load_string($data,'SimpleXMLElement', LIBXML_NOCDATA);

            return json_decode(json_encode($xml), true);
        }
        catch (\Exception|GuzzleException $e)
        {
            return json_decode('{}', true);
        }
    }
}
