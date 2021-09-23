<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Syntax\SteamApi\Facades\SteamApi;

class ApiJoinController extends Controller
{
    public function checkSteamStatus(Request $request) : JsonResponse
    {
        $steam = $request->user()->socials()->where('social_provider', 'steam')->first();

        $steamPlayer = SteamApi::Player($steam->social_id);
        $steamUser = SteamApi::User($steam->social_id);
        $ownedGames = $steamPlayer->GetOwnedGames();
        $profile = $steamUser->GetPlayerSummaries()[0];

        if ($profile->communityVisibilityState != 3) {
            return $this->jsonResponse(200, '스팀 프로필이 친구 공개 또는 비공개 상태입니다. 프로필을 공개로 변경해 주십시오.', false);

        }

        foreach ($ownedGames as $game) {
            if ($game->appId == 107410) {
                return $this->jsonResponse(200, '스팀 프로필이 친구 공개 또는 비공개 상태입니다. 프로필을 공개로 변경해 주십시오.', false);
            }
        }

        return $this->jsonResponse(200, 'OK', true);

    }
}
