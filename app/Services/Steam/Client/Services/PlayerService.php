<?php

namespace App\Services\Steam\Client\Services;

use App\Services\Steam\Client\Service;
use GuzzleHttp\Exception\GuzzleException;

class PlayerService extends Service
{
    /**
     * Return a list of games owned by the player
     *
     * @param $appidsFilter
     * @param $includeAppinfo
     * @param $includeFreeSub
     * @param $includePlayedFreeGames
     * @param $key
     * @param $steamid
     * @param $skipUnvettedApps
     *
     * @return array
     * @throws GuzzleException
     */
    public function GetOwnedGamesV1($appidsFilter, $includeAppinfo, $includeFreeSub, $includePlayedFreeGames, $key, $steamid, $skipUnvettedApps = null) : array
    {
        return $this->request(__METHOD__, 'GET', array('appids_filter' => $appidsFilter, 'include_appinfo' => $includeAppinfo, 'include_free_sub' => $includeFreeSub, 'include_played_free_games' => $includePlayedFreeGames, 'key' => $key, 'steamid' => $steamid, 'skip_unvetted_apps' => $skipUnvettedApps));
    }
}
