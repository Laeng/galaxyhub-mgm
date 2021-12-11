<?php

namespace App\Http\Controllers\Lounge\Join;

use App\Action\PlayerHistory\PlayerHistory;
use App\Action\Steam\Steam;
use App\Action\Survey\SurveyForm;
use App\Action\Group\Group;
use App\Action\UserData\UserData;
use App\Http\Controllers\Controller;
use App\Jobs\ProcessSteamEnquiry;
use App\Models\SurveyEntry;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Syntax\SteamApi\Facades\SteamApi;

class ViewJoinController extends Controller
{
    public function agree(Request $request, Group $group, PlayerHistory $history): Factory|View|Application|RedirectResponse
    {
        $redirect = $this->validateGroups($request, $group, $history);

        if (!is_null($redirect)) {
            return $redirect;
        }

        if ($group->has([$group::ARMA_MEMBER, $group::BANNED, $group::ARMA_APPLY])) {
            return redirect()->route('lounge.index');
        }

        return view('join.agree');
    }

    public function apply(Request $request, Group $group, SurveyForm $form, PlayerHistory $history): Factory|View|Application|RedirectResponse
    {
        $redirect = $this->validateGroups($request, $group, $history);

        if (!is_null($redirect)) {
            return $redirect;
        }

        if ($request->isMethod('get') && (is_null($request->session()->get('_old_input')) || count($request->session()->get('_old_input')) <= 0 )) {
            return redirect()->route('join.agree');
        }

        $survey = $form->getJoinApplicationForm();

        return view('join.apply', ['survey' => $survey, 'action' => route('join.submit')]);
    }

    public function submit(Request $request, Group $group, SurveyForm $form, Steam $steam, PlayerHistory $history): RedirectResponse
    {
        $redirect = $this->validateGroups($request, $group, $history);

        if (!is_null($redirect)) {
            return $redirect;
        }

        $survey = $form->getJoinApplicationForm();
        $answers = $this->validate($request, $survey->validateRules());

        $user = $request->user();

        $userId = $user->id;
        $profile = $steam->getPlayerSummaries($userId)[0];

        if ($profile->communityVisibilityState != 3) {
            return redirect()->back()->withErrors(['error' => '스팀 프로필이 친구 공개 또는 비공개 상태입니다. 프로필을 공개로 변경해 주십시오.']);
        }

        ProcessSteamEnquiry::dispatch($userId);

        (new SurveyEntry())->for($survey)->by($request->user())->fromArray($answers)->push();

        $now = now();

        $user->update([
            'created_at' => $now,
            'agreed_at' => $now
        ]);

        $group->add($group::ARMA_APPLY);

        $history->add($history->getIdentifierFromUser($user), PlayerHistory::TYPE_USER_APPLY, '가입 신청');

        return redirect()->route('lounge.index')->withErrors(['success' => '가입 신청이 접수되었습니다.']);
    }

    private function validateGroups(Request $request, Group $group, PlayerHistory $history): RedirectResponse|null
    {
        $user = $request->user();
        $steamAccount =  $user->socials()->where('social_provider', 'steam')->latest()->first();

        $banned = $history->getModel($steamAccount->social_id, PlayerHistory::TYPE_USER_BANNED)->latest()->get();
        if (!is_null($banned) && count($banned) > 0) {
            foreach ($banned as $i) {
                $group->add(Group::BANNED, $user, $i->description);
                break;
            }
        }

        $rejected = $history->getModel($steamAccount->social_id, PlayerHistory::TYPE_APPLICATION_REJECTED)->latest()->get();
        if (!is_null($rejected) && count($rejected) > 0) {
            foreach ($rejected as $i) {
                $group->add(Group::ARMA_REJECT, $user, $i->description);
                break;
            }
        }

        if ($group->has([Group::ARMA_MEMBER, Group::BANNED, Group::ARMA_APPLY])) {
            return redirect()->route('lounge.index');
        }

        if ($group->has([Group::ARMA_REJECT])) {
            if (count($rejected) >= 2) {
                return redirect()->route('lounge.index');
            }
        }

        return null;
    }
}
