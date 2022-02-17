<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    public function index(Request $request): View|Application|RedirectResponse|Redirector
    {
        $user = Auth::user();


        return view('user.application.index');
    }

    public function applied(Request $request): View|Application|RedirectResponse|Redirector
    {
        $user = Auth::user();

        if (!$user->hasRole($user::ROLE_APPLY) || $user->isBanned())
        {
            return redirect()->route('application.index');
        }

        return view('user.application.applied');
    }

}
