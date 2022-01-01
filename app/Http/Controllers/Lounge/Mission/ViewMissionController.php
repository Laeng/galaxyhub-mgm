<?php

namespace App\Http\Controllers\Lounge\Mission;

use App\Action\Group\Group;
use App\Http\Controllers\Controller;
use App\Models\Mission;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ViewMissionController extends Controller
{
    public function list(Request $request, Group $group): Factory|View|Application|RedirectResponse
    {
        return view('lounge.mission.list', [
            'title' => '미션 목록',
            'alerts' => [
                ['danger', '미션 참여 필요','2022년 1월 23일 이전까지 미션에 참석하여 주십시오. 미 참석시 규정에 따라 가입이 취소됩니다.'],
                ['info', '출석 체크 안내', '30일 이상 미 출석자는 규정에 따라 권한이 해지됩니다. 반드시 미션 참가 신청과 출석 체크를 해주십시오.']
            ],
            'isMaker' => $this->isMaker($request->user(), $group)
        ]);
    }

    public function read(Request $request, int $id): Factory|View|Application|RedirectResponse
    {

    }

    public function create(Request $request, Group $group): Factory|View|Application|RedirectResponse
    {
        if (!$this->isMaker($request->user(), $group)) {
            abort(404);
        }

        return view('lounge.mission.create', [
            'title' => '미션 생성',
            'edit' => false,
            'contents' => []
        ]);
    }
    public function update(Request $request, Group $group, int $id): Factory|View|Application|RedirectResponse
    {
        if (!$this->isMaker($request->user(), $group)) {
            abort(404);
        }

        $mission = Mission::find($id);

        if (is_null($mission)) {
            abort(404);
        }

        return view('lounge.mission.create', [
            'title' => '미션 수정',
            'edit' => true,
            'contents' => [

            ]
        ]);
    }


    private function isMaker(User $user, Group $group): bool
    {
        return $group->has([Group::ARMA_MAKER1, Group::ARMA_MAKER2, Group::STAFF]);
    }

    private function getMissionTypes(User $user, Group $group): array
    {

    }
}
