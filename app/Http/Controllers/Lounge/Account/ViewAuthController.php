<?php

namespace App\Http\Controllers\Lounge\Account;

use App\Action\PlayerHistory\PlayerHistory;
use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class ViewAuthController extends Controller
{
    public function login(Request $request): RedirectResponse|Factory|View|Application
    {
        if (Auth::check()) {
            return redirect()->route('lounge.index');
        }

        config(['services.steam.redirect' => route('account.auth.callback.steam')]);

        $steam = Socialite::driver('steam')->redirect()->getTargetUrl();
        return view('account.auth', ['steam' => $steam]);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    public function callback(Request $request, PlayerHistory $history, string $provider = 'steam'): RedirectResponse|Factory|View|Application
    {
        if (Auth::check()) {
            return redirect()->route('lounge.index');
        }

        $social = Socialite::driver($provider)->user();
        $user = $this->authenticate($social->id, null, $provider);

        if (!is_null($user)) {
            $updateUser = [
                'visit' => $user->visit + 1,
                'visited_at' => now()
            ];

            if ($user->avatar != $social->getAvatar()) { // 동일한 객체가 아님, 단순 값만 맞으면 된다.
                $updateUser = array_combine($updateUser, ['avatar' => $social->getAvatar()]);
            }

            if ($user->nickname != $social->getNickname()) {
                $updateUser = array_combine($updateUser, ['nickname' => $social->getNickname()]);
                $history->add($social->id, PlayerHistory::TYPE_STEAM_DISPLAY_NAME_CHANGED, $social->getNickname());
            }

            $user->update($updateUser);

            $userSocial = $user->socials()->where('social_provider', $provider)->first();

            if ($userSocial->social_nickname != $social->getNickname() || $userSocial->social_avatar != $social->getAvatar()) {
                $userSocial->update([
                    'social_nickname' => $social->getNickname(),
                    'social_avatar' => $social->getAvatar()
                ]);
            }
        } else {
            /**
             * @var User
             */
            $user = User::create([
                'provider' => 'steam',
                'username' => $social->getId(),
                'nickname' => $social->getNickname(),
                'password' => \Hash::make(\Str::random()),
                'avatar' => $social->getAvatar(),
                'visited_at' => now()
            ]);

            $user->socials()->create([
                'user_id' => $user->id,
                'social_provider' => 'steam',
                'social_id' => $social->getId(),
                'social_email' => $social->getEmail(),
                'social_name' => $social->getName(),
                'social_nickname' => $social->getNickname(),
                'social_avatar' => $social->getAvatar()
            ]);

            $history->add($social->id, PlayerHistory::TYPE_STEAM_DISPLAY_NAME_CHANGED, $social->getNickname());
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended('lounge');
    }

    private function authenticate(int|string $username, string $password = null, string $provider = 'default'): ?User
    {
        $query = User::where('provider', $provider)->where('username', '=', (string) $username);

        if ($provider === 'default') {
            $query->where('password', '=', $password);
        }

        $user = $query->latest()->first();

        return !is_null($user) ? $user : null;
    }

}
