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
                //'name' => $account->getName(), //수집 하지 않음
                'nickname' => $account->getNickname(),
                'avatar' => $account->getAvatar(),
                'email' => $account->getEmail()
            ];

            $user = $this->authService->createUser($accountArray);
            Auth::login($user, true);

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
}
