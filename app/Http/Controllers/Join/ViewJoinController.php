<?php

namespace App\Http\Controllers\Join;

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
    public function agree(Request $request, Group $group): Factory|View|Application|RedirectResponse
    {
        try {
            if ($group->has([$group::ARMA_MEMBER, $group::BANNED, $group::ARMA_APPLY])) {
                return redirect()->route('lounge.index');
            }

        } catch (\Exception $e) {
            abort('500', $e->getMessage());
        }

        return view('join.agree');
    }

    public function apply(Request $request, Group $group, SurveyForm $form): Factory|View|Application|RedirectResponse
    {
        try {
            if ($group->has([$group::ARMA_MEMBER, $group::BANNED, $group::ARMA_APPLY])) {
                return redirect()->route('lounge.index');
            }

            if ($request->isMethod('get') && (is_null($request->session()->get('_old_input')) || count($request->session()->get('_old_input')) <= 0 )) {
                return redirect()->route('join.agree');
            }

            $survey = $form->getJoinApplicationForm();

        } catch (\Exception $e) {
            abort('500', $e->getMessage());
        }

        return view('join.apply', ['survey' => $survey, 'action' => route('join.submit')]);
    }

    public function submit(Request $request, Group $group, SurveyForm $form, Steam $steam, UserData $userData): RedirectResponse
    {
        try{
            if ($group->has([$group::ARMA_MEMBER, $group::BANNED, $group::ARMA_APPLY])) {
                return redirect()->route('lounge.index');
            }

            $survey = $form->getJoinApplicationForm();
            $answers = $this->validate($request, $survey->validateRules());

            $userId = $request->user()->id;
            $profile = $steam->getPlayerSummaries($userId)[0];

            if ($profile->communityVisibilityState != 3) {
                return redirect()->back()->withErrors(['error' => '스팀 프로필이 친구 공개 또는 비공개 상태입니다. 프로필을 공개로 변경해 주십시오.']);
            }

            ProcessSteamEnquiry::dispatch($userId);

            (new SurveyEntry())->for($survey)->by(auth()->user())->fromArray($answers)->push();

            $now = now();
            auth()->user()->update(['created_at', 'agreed_at'], [$now, $now]);
            $group->add($group::ARMA_APPLY);

        } catch (\Exception $e) {
            abort('500', $e->getMessage());
        }

        return redirect()->route('lounge.index')->withErrors(['success' => '가입 신청이 접수되었습니다.']);
    }
}
