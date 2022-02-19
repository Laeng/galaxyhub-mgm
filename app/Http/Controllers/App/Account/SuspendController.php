<?php

namespace App\Http\Controllers\App\Account;

use App\Http\Controllers\Controller;
use Cog\Laravel\Ban\Models\Ban;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuspendController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = Auth::user();
        $ban = $user->bans()->latest()->first();

        if (is_null($ban))
        {
            abort(404);
        }

        $ban->comment = match ($ban->comment) {
            '장기미접속' => '회원님의 장기 미접속 신청이 접수되어 계정이 정지되었습니다.<br/> 만약 활동을 재개하시기로 결정하셨다면, <a href="https://cafe.naver.com/ArticleList.nhn?search.clubid=17091584&search.menuid=223&search.boardtype=L" class="link-indigo" target="_blank">커뮤니티</a>에서 권한 복구 신청해주시기 바랍니다.',
            default => $ban->comment
        };

        return view('app.account.suspended', [
            'comment' => $ban->comment,
            'isPermanent' => is_null($ban->expired_at),
            'ban' => $ban
        ]);
    }
}
