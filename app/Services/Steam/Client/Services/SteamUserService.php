<?php

namespace App\Services\Steam\Client\Services;

use App\Services\Steam\Client\Service;

class SteamUserService extends Service
{
    /**
     * @param $key
     * @param $steamids
     *
     * @return array
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
     */
    public function GetUserGroupListV1($key, $steamid) : array
    {
        return $this->request(__METHOD__, 'GET', array('key' => $key, 'steamid' => $steamid));
    }
}
