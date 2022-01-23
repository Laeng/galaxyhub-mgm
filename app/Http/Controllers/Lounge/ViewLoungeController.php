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
    public function index(Request $request): Factory|View|Application|RedirectResponse
    {
        $user = $request->user();
        // 미션 시간 갱신은 실시간으로 갱신, JS 사용

        return view('lounge.index', [
            'user' => $user,

        ]);
    }

    private function getPlayerHistory(User $user, PlayerHistory $history, String $type)
    {
        return $history->getModel($history->getIdentifierFromUser($user), $type)->latest()->get();
    }
}
