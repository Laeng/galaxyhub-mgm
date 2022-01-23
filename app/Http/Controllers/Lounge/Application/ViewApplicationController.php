<?php

namespace App\Http\Controllers\Lounge\Application;

use App\Action\PlayerHistory\PlayerHistory;
use App\Action\Steam\Steam;
use App\Action\Survey\SurveyForm;
use App\Action\Group\Group;
use App\Action\UserData\UserData;
use App\Http\Controllers\Controller;
use App\Jobs\ProcessSteamEnquiry;
use App\Models\SurveyEntry;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Syntax\SteamApi\Facades\SteamApi;

class ViewApplicationController extends Controller
{
    public function index(Request $request): Factory|View|Application|RedirectResponse
    {
        $user = $request->user();
        $group = $user->groups()->get();

        if (is_null($group) || $group->count() <= 0) {
            return redirect()->route('application.agreements');
        }

        $groupIds = $group->pluck('group_id')->toArray();

        if (in_array(Group::ARMA_APPLY, $groupIds)) {
            return redirect()->route('application.apply');
        }

        if (in_array(Group::ARMA_REJECT, $groupIds)) {
            return redirect()->route('application.reject');
        }

        if (in_array(Group::ARMA_DEFER, $groupIds)) {
            return redirect()->route('application.defer');
        }

        return redirect()->route('lounge.index');
    }

    public function agreements(Request $request, Group $group, PlayerHistory $history): Factory|View|Application|RedirectResponse
    {
        $user = $request->user();

        if ($this->groupValidate($user, $group, Group::ARMA_APPLY) || $user->isBanned()) {
            return redirect()->route('application.index');
        }

        return view('application.agreements');
    }

    public function form(Request $request, Group $group, SurveyForm $form, PlayerHistory $history): Factory|View|Application|RedirectResponse
    {
        $user = $request->user();

        if ($this->groupValidate($user, $group, Group::ARMA_APPLY) || $user->isBanned()) {
            return redirect()->route('application.index');
        }

        if ($request->isMethod('get') && (is_null($request->session()->get('_old_input')) || count($request->session()->get('_old_input')) <= 0 )) {
            return redirect()->route('application.agreements');
        }

        $survey = $form->getJoinApplicationForm();

        return view('application.form', ['survey' => $survey, 'action' => route('application.submit')]);
    }

    public function submit(Request $request, Group $group, SurveyForm $form, Steam $steam, PlayerHistory $history): Factory|View|Application|RedirectResponse
    {
        $user = $request->user();

        if ($this->groupValidate($user, $group, Group::ARMA_APPLY) || $user->isBanned()) {
            return redirect()->route('application.index');
        }

        $survey = $form->getJoinApplicationForm();
        $answers = $this->validate($request, $survey->validateRules());

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

        return redirect()->route('application.apply')->withErrors(['success' => '가입 신청이 접수되었습니다.']);
    }

    public function defer(Request $request, Group $group, PlayerHistory $history): Factory|View|Application|RedirectResponse
    {
        $user = $request->user();

        if (!$this->groupValidate($user, $group, Group::ARMA_DEFER)) {
            return redirect()->route('application.index');
        }

        $deferred = $this->getPlayerHistory($user, $history, PlayerHistory::TYPE_APPLICATION_DEFERRED)->first();

        if (!is_null($deferred)) {
            $data = [
                'reason' => $deferred->description
            ];

        } else {
            $data = [
                'reason' => ''
            ];
        }

        return view('application.deferred', $data);
    }

    public function reject(Request $request, Group $group, PlayerHistory $history): Factory|View|Application|RedirectResponse
    {
        $user = $request->user();

        if (!$this->groupValidate($user, $group, Group::ARMA_REJECT)) {
            return redirect()->route('application.index');
        }

        $rejected = $this->getPlayerHistory($user, $history, PlayerHistory::TYPE_APPLICATION_REJECTED)->get();

        if ($rejected->count() > 0) {
            $data = [
                'x' => count($rejected),
                'date' => $rejected[0]->created_at,
                'reason' => $rejected[0]->description
            ];
        } else {
            $data = [
                'x' => 0,
                'date' => now(),
                'reason' => ''
            ];
        }

        return view('application.rejected', $data);
    }

    public function apply(Request $request, Group $group): Factory|View|Application|RedirectResponse
    {
        $user = $request->user();

        if (!$this->groupValidate($user, $group, Group::ARMA_APPLY)) {
            return redirect()->route('application.index');
        }

        return view('application.applied', []);
    }

    private function groupValidate(User $user, Group $group, ...$condition): bool
    {
        return $group->has($condition, $user); // || config('app.debug');
    }

    private function getPlayerHistory(User $user, PlayerHistory $history, String $type): Builder
    {
        return $history->getModel($history->getIdentifierFromUser($user), $type)->latest();
    }
}
