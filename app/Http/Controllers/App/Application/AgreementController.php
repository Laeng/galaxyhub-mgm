<?php

namespace App\Http\Controllers\App\Application;

use App\Enums\RoleType;
use App\Http\Controllers\Controller;
use App\Jobs\CreateSteamAccount;
use App\Repositories\User\Interfaces\UserAccountRepositoryInterface;
use App\Repositories\User\Interfaces\UserRecordRepositoryInterface;
use App\Services\Steam\Contracts\SteamServiceContract;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use function auth;
use function config;
use function redirect;
use function view;

class AgreementController extends Controller
{
    public function index(Request $request): View|Application|RedirectResponse|Redirector
    {
        $user = Auth::user();

        if ($user->hasRole(RoleType::APPLY->name))
        {
            return redirect()->route('application.index');
        }

        return view('app.application.agreements');
    }

    public function checkAccount
    (
        Request $request, UserAccountRepositoryInterface $userAccountRepository,
        SteamServiceContract $steamService,
    ): JsonResponse
    {
        try
        {
            $user = Auth::user();
            $accounts = $userAccountRepository->findByUserId($user->id);
            $steamAccount = $accounts->filter(fn ($v, $k) => $v->provider === 'steam')->first();

            $steamPlayerSummaries = $steamService->getPlayerSummaries($steamAccount->account_id);

            if ($steamPlayerSummaries['response']['players'][0]['communityvisibilitystate'] != 3)
            {
                return $this->jsonResponse(200, '스팀 프로필이 친구 공개 또는 비공개 상태입니다. 프로필을 공개로 변경해 주십시오.', false);
            }

            $steamOwnedGames = $steamService->getOwnedGames($steamAccount->account_id);

            if (count($steamOwnedGames['response']) <= 0)
            {
                return $this->jsonResponse(200, '아르마 3 구매 여부를 확인할 수 없습니다. 스팀 프로필 설정에서 게임 세부 정보 와 게임 플레이 시간을 공개로 변경하여 주십시오. ', false);
            }

            $steamOwnedGamesCollection = new Collection($steamOwnedGames['response']['games']);

            if ($steamOwnedGamesCollection->filter(fn ($v, $k) => $v['appid'] == 107410)->count() == 0)
            {
                return $this->jsonResponse(200, '\'아르마 3\'를 구매하셔야만  MGM 라운지 및 MGM 아르마 클랜 가입 신청이 가능합니다.', false);
            }

            CreateSteamAccount::dispatch($user);

            return $this->jsonResponse(200, 'OK', true);
        }
        catch (\Exception $e)
        {
            return $this->jsonResponse($e->getCode(), $e->getMessage(), config('app.debug') ? $e->getTrace() : []);
        }
    }


}
