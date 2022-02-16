<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class ApplicationController extends Controller
{
    public function applied(Request $request): View|Application|RedirectResponse|Redirector
    {
        return view('user.application.applied');
    }

}
