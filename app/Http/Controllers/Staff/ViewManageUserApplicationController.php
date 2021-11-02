<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Survey;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
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
                ['warning', '', '거절, 보류 사유는 해당 신청자에게 표시됩니다. 민감한 사항은 \'유저 메모\' 생성 후 별도 기록해 주십시오.']
            ],
            'api' => route('staff.user.application.get')
        ]);
    }

    public function detail(Request $request, int $id): Factory|View|Application|RedirectResponse
    {
        try {
            $user = User::find($id);

            if (is_null($user)) {
                throw new Exception('회원을 찾을 수 없습니다.');
            }

            $surveyForms = Survey::where('name', 'like', 'join-application-%')->get(['id'])->pluck('id')->toArray();
            $userSurveys = $user->surveys()->whereIn('survey_id', $surveyForms);
            $userApplication = $userSurveys->latest()->get();

            return view('staff.userApplicationDetail', [
                'title' => "{$user->nickname}님의 신청서",
                'applications' => $userApplication,
            ]);
        } catch (Exception $e) {
            return redirect()->route('staff.user.application')->withErrors(['danger' => $e->getMessage()]);
        }
    }

    public function detailRevision(Request $request, int $id, int $survey_id): Factory|View|Application|RedirectResponse
    {

    }
}
