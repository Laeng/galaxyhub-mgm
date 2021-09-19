<?php

namespace App\Http\Controllers\Lounge;

use App\Action\UserGroup\UserGroup;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ViewLoungeController extends Controller
{
    public function index(Request $request, UserGroup $group): Factory|View|Application|RedirectResponse
    {
        /*
        if (!$group->has($group::ARMA_MEMBER)) {
            return redirect()->route('join.apply');
        }
        */


        return view('lounge.index');
    }
}
