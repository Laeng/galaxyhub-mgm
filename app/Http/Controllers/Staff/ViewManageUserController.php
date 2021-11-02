<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ViewManageUserController
{
    public function list(Request $request): Factory|View|Application|RedirectResponse
    {
        return view('staff.userApplicationDetail');
    }

    public function detail(Request $request, string $user_id): Factory|View|Application|RedirectResponse
    {
        return view('staff.userApplicationDetail');
    }
}
