<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ViewManageUserController extends Controller
{
    public function list(Request $request): Factory|View|Application|RedirectResponse
    {
        return view('staff.user-list');
    }

    public function detail(Request $request, string $user_id): Factory|View|Application|RedirectResponse
    {
        return view('staff.user-list');
    }

    public function applicantList(Request $request): Factory|View|Application|RedirectResponse
    {
        return view('staff.user-list', [
            'title' => '가입 신청자',
            'alerts' => [
                ['danger', '',now()->subYears(16)->year . '년생 이상만 가입을 허용해 주십시오. (' . now()->year . '년 기준)'],
                ['warning', '', '미비 사항이 있다면 무조건 거절하시지 마시고 보류 처리 후 해당 부분을 보충할 기회를 주십시오.'],
                ['warning', '', '거절, 보류 사유는 해당 신청자에게 표시됩니다. 민감한 사항은 \'유저 메모\' 생성 후 별도 기록해 주십시오.']
            ],
            'applicantsListApi' => route('staff.user.applicant.list.get')
        ]);
    }

    public function applicantDetail(Request $request, string $user_id): Factory|View|Application|RedirectResponse
    {
        return view('staff.user-list');
    }
}
