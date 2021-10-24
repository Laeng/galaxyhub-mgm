<?php

namespace App\Http\Controllers\Join;

use App\Action\Steam\Steam;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Syntax\SteamApi\Facades\SteamApi;

class ApiJoinController extends Controller
{
    public function checkSteamStatus(Request $request, Steam $steam) : JsonResponse
    {
        $ownedGames = $steam->getOwnedGames(auth()->id());
        $profile = $steam->getPlayerSummaries(auth()->id())[0];

        if ($profile->communityVisibilityState != 3) {
            return $this->jsonResponse(200, '스팀 프로필이 친구 공개 또는 비공개 상태입니다. 프로필을 공개로 변경해 주십시오.', false);

        }

        foreach ($ownedGames as $game) {
            if ($game->appId == 107410) {
                return $this->jsonResponse(200, 'OK', true);
            }
        }

        return $this->jsonResponse(200, '아르마 3 를 구매하셔야만  MGM 라운지 및 MGM 아르마 클랜 가입 신청이 가능합니다.', true);

    }
}
