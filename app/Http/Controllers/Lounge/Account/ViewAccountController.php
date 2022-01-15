<?php

namespace App\Http\Controllers\Lounge\Account;

use App\Http\Controllers\Controller;
use Cog\Laravel\Ban\Models\Ban;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ViewAccountController extends Controller
{
    public function suspended(Request $request): RedirectResponse|Factory|View|Application
    {
        $user = $request->user();
        $ban = Ban::where('bannable_id', $user->id)->latest()->first();

        $isBanned = is_null($ban);

        if ($isBanned) {
            abort(404);
        }

        $isPermanent = is_null($ban->expired_at);

        $ban->comment = match ($ban->comment) {
            '장기미접속' => '회원님의 장기 미접속 신청이 접수되어 계정이 정지되었습니다.<br/> 만약 활동을 재개하시기로 결정하셨다면, <a href="https://cafe.naver.com/ArticleList.nhn?search.clubid=17091584&search.menuid=223&search.boardtype=L" class="link-indigo" target="_blank">커뮤니티</a>에서 권한 복구 신청해주시기 바랍니다.',
            default => $ban->comment
       };

        return view('account.suspended', [
            'comment' => $ban->comment,
            'isPermanent' => $isPermanent,
            'ban' => $ban
        ]);
    }
}
