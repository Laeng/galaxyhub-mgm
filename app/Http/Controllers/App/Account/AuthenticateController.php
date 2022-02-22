<?php

namespace App\Http\Controllers\App\Account;

use App\Http\Controllers\Controller;
use App\Services\User\Contracts\UserServiceContract;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Laravel\Socialite\Facades\Socialite;
use SocialiteProviders\Steam\OpenIDValidationException;
use function config;
use function redirect;
use function route;
use function view;

class AuthenticateController extends Controller
{
    private UserServiceContract $authService;

    public function __construct(UserServiceContract $authService)
    {
        $this->authService = $authService;
    }

    public function login(): View|Application|RedirectResponse|Redirector
    {
        if (Auth::check()) {
            return redirect()->route('app.index');
        }

        return view('app.account.login');
    }

    public function provider(Request $request, string $provider): Application|RedirectResponse|Redirector
    {
        if (Auth::check()) {
            return redirect()->route('app.index');
        }

        switch($provider)
        {
            case 'steam':
                config(['services.steam.redirect' => route('auth.login.provider.callback', 'steam')]);
                return Socialite::driver('steam')->redirect();
            default:
                return redirect()->route('auth.login');
        }
    }

    public function callback(Request $request, string $provider): View|Application|RedirectResponse|Redirector
    {
        try
        {
            $account = Socialite::driver($provider)->user();
            $accountArray = [
                'provider' => $provider,
                'id' => $account->getId(),
                'name' => $account->getName(),
                'nickname' => $account->getNickname(),
                'avatar' => $account->getAvatar(),
                'email' => $account->getEmail()
            ];

            $user = $this->authService->createUser($accountArray);

            Auth::login($user);

            $request->session()->regenerate();

            return redirect()->intended(route('app.index'));
        }
        catch (OpenIDValidationException $e)
        {
            return redirect()->route('auth.login', $provider)->withErrors('error', '소셜 로그인 중 오류가 발생하였습니다. 다시 시도하여 주십시오.');
        }
    }

    public function logout(Request $request): Application|RedirectResponse|Redirector
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('app.index');
    }

    public function suspended(Request $request)
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
