<?php

namespace App\Http\Controllers\Lounge;

use App\Action\Group\Group;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ViewLoungeController extends Controller
{
    public function index(Request $request, Group $group): Factory|View|Application|RedirectResponse
    {
        try {
            if ($group->has($group::BANNED)) {
                return view('lounge.banned');
            }

            if ($group->has($group::INACTIVE)) {
                return view('lounge.inactivated');
            }

            if ($group->has($group::ARMA_APPLY)) {
                return view('lounge.applied');
            }

            if (!$group->has($group::ARMA_MEMBER)) {
                return redirect()->route('join.agree');
            }
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }

        return view('lounge.index');
    }
}
