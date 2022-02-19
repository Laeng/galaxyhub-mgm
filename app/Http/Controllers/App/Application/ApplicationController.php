<?php

namespace App\Http\Controllers\App\Application;

use App\Http\Controllers\Controller;
use App\Repositories\User\Interfaces\UserAccountRepositoryInterface;
use App\Repositories\User\Interfaces\UserRecordRepositoryInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use function redirect;
use function view;

class ApplicationController extends Controller
{
    public function index(Request $request): View|Application|RedirectResponse|Redirector
    {
        $user = Auth::user();

        if ($user->hasRole($user::ROLE_APPLY)) {
            return redirect()->route('application.applied');
        }

        if ($user->hasRole($user::ROLE_DEFER)) {
            return redirect()->route('application.deferred');
        }

        if ($user->hasRole($user::ROLE_REJECT)) {
            return redirect()->route('application.rejected');
        }

        return view('app.application.index');
    }

    public function applied(): View|Application|RedirectResponse|Redirector
    {
        $user = Auth::user();

        if (!$user->hasRole($user::ROLE_APPLY))
        {
            abort('404');
        }

        return view('app.application.applied');
    }

    public function rejected(UserAccountRepositoryInterface $accountRepository, UserRecordRepositoryInterface $recordRepository): View|Application|RedirectResponse|Redirector
    {
        $user = Auth::user();

        if (!$user->hasRole($user::ROLE_REJECT))
        {
            abort(404);
        }

        $steamAccount = $accountRepository->findByUserId($user->id)?->filter(fn ($v, $k) => $v->provider === 'steam')?->first();
        $uuid = $recordRepository->getUUIDv5($steamAccount->account_id);
        $recode = $recordRepository->findByUuid($uuid)?->filter(fn ($v, $k) => $v->type === $user::RECORD_ROLE_DATA && $v->data['role'] === $user::ROLE_REJECT);

        $reject = $recode->first();

        return view('app.application.rejected', [
            'reason' => $reject->data['reason'],
            'date' => $reject->created_at,
            'count' => $recode->count()
        ]);
    }

    public function deferred(Request $request): View|Application|RedirectResponse|Redirector
    {
        $user = Auth::user();

        if (!$user->hasRole($user::ROLE_DEFER))
        {
            abort(404);
        }



        return view('app.application.deferred', [

        ]);
    }

}
