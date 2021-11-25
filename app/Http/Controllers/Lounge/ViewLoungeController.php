<?php

namespace App\Http\Controllers\Lounge;

use App\Action\Group\Group;
use App\Action\PlayerHistory\PlayerHistory;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ViewLoungeController extends Controller
{
    public function index(Request $request, Group $group, PlayerHistory $history): Factory|View|Application|RedirectResponse
    {
        $user = $request->user();
        $groups = $group->getUserGroups($user)->pluck(['group_id'])->toArray();

        if (in_array( Group::BANNED, $groups)) return view('lounge.main.banned');
        if (in_array( Group::INACTIVE, $groups)) return view('lounge.main.inactivated');

        // 가입 신청 접수 안내 페이지
        // 거절된 사람, 보류된 사람 이여도 가입 신청을 했다면 출력 되도록 해야함.
        if (in_array( Group::ARMA_APPLY, $groups)) return view('lounge.main.applied');

        // 거절
        if (in_array( Group::ARMA_REJECT, $groups)) {
            $rejectHistory = $this->getPlayerHistory($user, $history, PlayerHistory::TYPE_APPLICATION_REJECTED);
            $x = count($rejectHistory);
            $date = $rejectHistory[0]->created_at;
            $reason = $rejectHistory[0]->description;

            return view('lounge.main.rejected', ['x' => $x, 'date' => $date, 'reason' => $reason]);
        }

        // 보류
        if (in_array( Group::ARMA_DEFER, $groups)) {
            $defferHistory = $this->getPlayerHistory($user, $history, PlayerHistory::TYPE_APPLICATION_DEFERRED);
            $reason = $defferHistory[0]->description;

            return view('lounge.main.deferred', ['reason' => $reason]);
        }

        if (!in_array(Group::ARMA_MEMBER, $groups)) return redirect()->route('join.agree');


        return view('lounge.main.index');
    }

    private function getPlayerHistory(User $user, PlayerHistory $history, String $type) {
        return $history->getModel($history->getIdentifierFromUser($user), $type)->latest()->get();
    }
}
