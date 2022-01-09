<?php

namespace App\Http\Controllers\Staff\User\All;

use App\Action\Group\Group;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use function abort;
use function redirect;
use function view;

class ViewUserAllController
{
    public function list(Request $request, Group $group): Factory|View|Application|RedirectResponse
    {
        return view('staff.user.all.list',[
            'title' => '전체 회원',
            'groups' => $group->names
        ]);
    }

    public function read(Request $request, int $id): Factory|View|Application|RedirectResponse
    {
        $user = User::find($id);

        if (is_null($user)) {
            abort(404, 'CAN NOT FOUND USER');
            return redirect()->back()->withErrors(['danger' => '없는 회원입니다.']);
        }

        return view('staff.user.all.read', [
            'title' => "{$user->nickname}님의 정보",
        ]);

        /*
         * 1. 가입 신청서 링크 보기
         * 2. 활동정지, 등급 변경 등 할 수 있도록 하기
         * 3. 미션 참가 기록 표시 (각 설문지 확인 기능, 참가 횟수)
         * 4. 미션 개설 기록 표시
         * 4. 라이선스 관리 (키 재발급, 무효화 등)
         * 5. 유저 메모
         * 6. 스팀 닉네임 변경 기록
         */
    }
}
