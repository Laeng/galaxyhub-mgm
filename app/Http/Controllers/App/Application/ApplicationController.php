<?php

namespace App\Http\Controllers\App\Application;

use App\Enums\RoleType;
use App\Http\Controllers\Controller;
use App\Repositories\User\Interfaces\UserAccountRepositoryInterface;
use App\Repositories\User\Interfaces\UserRecordRepositoryInterface;
use App\Services\User\Contracts\UserServiceContract;
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

        // 나중에 고치기....

        if ($user->hasRole(RoleType::APPLY->name)) {
            return redirect()->route('application.applied');
        }

        if ($user->hasRole(RoleType::DEFER->name)) {
            return redirect()->route('application.deferred');
        }

        if ($user->hasRole(RoleType::REJECT->name)) {
            return redirect()->route('application.rejected');
        }

        return view('app.application.index');
    }

    public function applied(): View|Application|RedirectResponse|Redirector
    {
        $user = Auth::user();

        if (!$user->hasRole(RoleType::APPLY->name))
        {
            abort('404');
        }

        return view('app.application.applied');
    }

    public function rejected(UserServiceContract $userService): View|Application|RedirectResponse|Redirector
    {
        $user = Auth::user();

        if (!$user->hasRole($user::ROLE_REJECT))
        {
            abort(404);
        }

        $recode = $userService->findRoleRecordeByUserId($user->id, RoleType::REJECT->name)->first();

        return view('app.application.rejected', [
            'reason' => $recode->data['reason'],
            'date' => $recode->created_at,
            'count' => $recode->count()
        ]);
    }

    public function deferred(): View|Application|RedirectResponse|Redirector
    {
        $user = Auth::user();

        if (!$user->hasRole(RoleType::DEFER->name))
        {
            abort(404);
        }

        return view('app.application.deferred', [

        ]);
    }

}
