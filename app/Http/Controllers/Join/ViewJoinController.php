<?php

namespace App\Http\Controllers\Join;

use App\Action\UserGroup\UserGroup;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Syntax\SteamApi\Facades\SteamApi;

class ViewJoinController extends Controller
{
    public function apply(Request $request, UserGroup $group): Factory|View|Application|RedirectResponse
    {
        if ($group->has([$group::ARMA_MEMBER, $group::BANNED])) {
            return redirect()->route('lounge.index');
        }

        $steam = $request->user()->socials()->where('social_provider', 'steam')->first();

        $steamPlayer = SteamApi::Player($steam->social_id);
        $steamUser = SteamApi::User($steam->social_id);
        $ownedGames = $steamPlayer->GetOwnedGames();
        $profile = $steamUser->GetPlayerSummaries()[0];

        $isJoinUnable = true;
        $unableReason = 'MGM 라운지는 ARMA 3 구매자만 가입할 수 있습니다. ARMA 3를 구매 하신 후 다시 신청하여 주십시오.';

        if ($profile->communityVisibilityState != 3) {
            $unableReason = '스팀 프로필이 친구 공개 또는 비공개 상태입니다. 프로필을 공개로 변경해 주십시오.';
        } else {
            foreach ($ownedGames as $game) {
                if ($game->appId == 107410) {
                    $isJoinUnable = false;
                    break;
                }
            }
        }

        return view('join.apply', ['isJoinUnable' => $isJoinUnable, 'unableReason' => $unableReason]);
    }

    public function applySubmit(Request $request, UserGroup $group): RedirectResponse
    {
        if ($group->has([$group::ARMA_MEMBER, $group::BANNED])) {
            return redirect()->route('lounge.index');
        }

        $steam = $request->user()->socials()->where('social_provider', 'steam')->first();

        $steamPlayer = SteamApi::Player($steam->social_id);
        $steamUser = SteamApi::User($steam->social_id);
        $ownedGames = $steamPlayer->GetOwnedGames();
        $profile = $steamUser->GetPlayerSummaries()[0];

        if ($profile->communityVisibilityState != 3) {
            return redirect()->back()->withErrors(['error' => '스팀 프로필이 친구 공개 또는 비공개 상태입니다. 프로필을 공개로 변경해 주십시오.']);
        } else {
            $isJoinUnable = true;

            foreach ($ownedGames as $game) {
                if ($game->appId == 107410) {
                    $isJoinUnable = false;
                    break;
                }
            }

            if ($isJoinUnable) {
                return redirect()->back()->withErrors(['error' => 'MGM 라운지는 ARMA 3 구매자만 가입할 수 있습니다. ARMA 3를 구매 하신 후 다시 신청하여 주십시오.']);
            }
        }

        $group->put($group::ARMA_APPLY);

        return redirect()->route('');
    }
}
