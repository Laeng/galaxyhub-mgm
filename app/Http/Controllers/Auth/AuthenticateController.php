<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Contracts\AuthServiceContract;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Laravel\Socialite\Facades\Socialite;
use SocialiteProviders\Steam\OpenIDValidationException;

class AuthenticateController extends Controller
{
    private AuthServiceContract $authService;

    public function __construct(AuthServiceContract $authService)
    {
        $this->authService = $authService;
    }

    public function login(): View|Application|RedirectResponse|Redirector
    {
        if (Auth::check()) {
            return redirect()->route('lounge.index');
        }

        return view('user.auth.login');
    }

    public function provider(Request $request, string $provider): Application|RedirectResponse|Redirector
    {
        if (Auth::check()) {
            return redirect()->route('lounge.index');
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

            $user = $this->authService->create($accountArray);

            Auth::login($user);
            $request->session()->regenerate();

            return redirect()->route('lounge.welcome');
        }
        catch (OpenIDValidationException $e)
        {
            return redirect()->route('auth.login.provider', $provider);
        }
    }

    public function logout(Request $request): Application|RedirectResponse|Redirector
    {
        Auth::logout();
        return redirect()->route('welcome');
    }
}
