<?php

namespace App\Http\Controllers\Join;

use App\Action\Survey\SurveyForm;
use App\Action\Group\Group;
use App\Http\Controllers\Controller;
use App\Models\SurveyEntry;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Syntax\SteamApi\Facades\SteamApi;

class ViewJoinController extends Controller
{
    public function agree(Request $request, Group $group): Factory|View|Application|RedirectResponse
    {
        if ($group->has([$group::ARMA_MEMBER, $group::BANNED, $group::ARMA_APPLY])) {
            return redirect()->route('lounge.index');
        }

        $isJoinUnable = false;
        $unableReason = null;

        try {
            $this->getSteamProfile($request);
        } catch (\Exception $e) {

            $isJoinUnable = true;
            $unableReason = $e->getMessage();
        }

        return view('join.agree', ['isJoinUnable' => $isJoinUnable, 'unableReason' => $unableReason]);
    }

    public function apply(Request $request, Group $group, SurveyForm $form): Factory|View|Application|RedirectResponse
    {
        if ($group->has([$group::ARMA_MEMBER, $group::BANNED, $group::ARMA_APPLY])) {
            return redirect()->route('lounge.index');
        }

        $survey = $form->getJoinApplicationForm();

        return view('join.apply', ['survey' => $survey, 'action' => route('join.apply.submit')]);
    }

    public function applySubmit(Request $request, Group $group, SurveyForm $form): RedirectResponse
    {
        if ($group->has([$group::ARMA_MEMBER, $group::BANNED, $group::ARMA_APPLY])) {
            return redirect()->route('lounge.index');
        }

        try {
            $steamProfile = $this->getSteamProfile($request);
        } catch (\Exception $e) {
            return redirect()->route('join.apply');
        }

        $survey = $form->getJoinApplicationForm();
        $answers = $this->validate($request, $survey->validateRules());

        (new SurveyEntry())->for($survey)->by(auth()->user())->fromArray($answers)->push();


        auth()->user()->update(['agreed_at', now()]);
        $group->create($group::ARMA_APPLY);

        return redirect()->route('lounge.index');
    }

    /**
     * @throws \Exception
     */
    private function getSteamProfile(Request $request)
    {
        $steam = $request->user()->socials()->where('social_provider', 'steam')->first();

        $steamPlayer = SteamApi::Player($steam->social_id);
        $steamUser = SteamApi::User($steam->social_id);
        $ownedGames = $steamPlayer->GetOwnedGames();
        $profile = $steamUser->GetPlayerSummaries()[0];

        if ($profile->communityVisibilityState != 3) {
            throw new \Exception('스팀 프로필이 친구 공개 또는 비공개 상태입니다. 프로필을 공개로 변경해 주십시오.');
        } else {
            $isJoinUnable = true;

            foreach ($ownedGames as $game) {
                if ($game->appId == 107410) {
                    $isJoinUnable = false;
                    break;
                }
            }

            if ($isJoinUnable) {
                throw new \Exception('MGM 라운지 및 MGM 아르마 클랜은 ARMA 3 구매자만 가입할 수 있습니다. ARMA 3를 구매 하신 후 다시 신청하여 주십시오.');
            }
        }

        return $profile;
    }
}
