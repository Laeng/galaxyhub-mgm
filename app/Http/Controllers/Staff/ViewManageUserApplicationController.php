<?php

namespace App\Http\Controllers\Staff;

use App\Action\Steam\Steam;
use App\Action\Survey\SurveyForm;
use App\Action\UserData\UserData;
use App\Http\Controllers\Controller;
use App\Models\Survey;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ViewManageUserApplicationController extends Controller
{
    public function list(Request $request): Factory|View|Application|RedirectResponse
    {
        return view('staff.userApplication', [
            'title' => '가입 신청자',
            'alerts' => [
                ['danger', '',now()->subYears(16)->year . '년생 이상만 가입을 허용해 주십시오. (' . now()->year . '년 기준)'],
                ['warning', '', '미비 사항이 있다면 무조건 거절하시지 마시고 보류 처리 후 해당 부분을 보충할 기회를 주십시오.'],
                ['warning', '', '거절, 보류 사유는 해당 신청자에게 표시됩니다. 민감한 사항은 \'유저 메모\' 에 별도 기록해 주십시오.']
            ],
            'api' => route('staff.user.application.get')
        ]);
    }

    public function detail(SurveyForm $surveyForm, Request $request, int $id): Factory|View|Application|RedirectResponse
    {
        $user = User::find($id);

        if (is_null($user)) {
            return redirect()->route('staff.user.application')->withErrors(['danger' => '회원을 찾을 수 없습니다.']);
        }

        $surveyForms = Survey::where('name', 'like', 'join-application-%')->get(['id'])->pluck('id')->toArray();
        $userSurveys = $user->surveys()->whereIn('survey_id', $surveyForms)->latest()->get()->toArray();

        $status = null;
        $assign = null;
        $userGroups = $user->groups()->orderBy('group_id', 'asc')->get();

        foreach ($userGroups as $group) {
            if ($group->group_id == 20) {
                $status = '접수';
                break;
            }

            if ($group->group_id > 30) {
                continue;
            }

            $status = match ($group->group_id) {
                21 => '보류',
                22 => '거절',
                30 => '승인',
                default => ''
            };

            $groupReason = $group->reason()->latest()->first();

            if (!is_null($groupReason)) {
                $staffInfo = $groupReason->staff()->latest()->first();

                $assign = [
                    'nickname' => '알 수 없음',
                    'reason' => (is_null($groupReason->reason) || $groupReason->reason === '') ? '입력한 사유가 없습니다.' : $groupReason->reason,
                    'created_at' => $groupReason->created_at
                ];


                if (!is_null($staffInfo)) {
                    $assign['nickname'] = $staffInfo->nickname;
                }
            }
        }

        return view('staff.userApplicationDetail', [
            'title' => "{$user->nickname}님의 신청서",
            'status' => $status,
            'assign' => $assign,
            'user' => $user,
            'applications' => $userSurveys,
            'surveyForm' => $surveyForm->getJoinApplicationForm($userSurveys[0]['survey_id']),
            'answer' => $userSurveys[0]['id']
        ]);
    }

    public function detailRevision(Request $request, int $id, int $survey_id): Factory|View|Application|RedirectResponse
    {
        return redirect()->back();
    }

}
