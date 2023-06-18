<?php

namespace App\Services\Steam\Client\Services;

use App\Services\Steam\Client\Service;
use GuzzleHttp\Exception\GuzzleException;

class ISteamUser extends Service
{
    /**
     * @param $key
     * @param $steamids
     *
     * @return array
     * @throws GuzzleException
     */
    public function GetPlayerSummariesV2($key, $steamids) : array
    {
        return $this->request(__METHOD__, 'GET', array('key' => $key, 'steamids' => $steamids));
    }

    /**
     * @param $key
     * @param $steamids
     *
     * @return array
     * @throws GuzzleException
     */
    public function GetPlayerBansV1($key, $steamids) : array
    {
        return $this->request(__METHOD__, 'GET', array('key' => $key, 'steamids' => $steamids));
    }

    /**
     * @param $key
     * @param $steamid
     *
     * @return array
     * @throws GuzzleException
     */
    public function GetUserGroupListV1($key, $steamid) : array
    {
        return $this->request(__METHOD__, 'GET', array('key' => $key, 'steamid' => $steamid));
    }
}
