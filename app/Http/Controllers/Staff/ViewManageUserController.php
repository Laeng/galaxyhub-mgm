<?php

namespace App\Http\Controllers\Staff;

use App\Action\Group\Group;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ViewManageUserController
{
    public function list(Request $request, Group $group): Factory|View|Application|RedirectResponse
    {
        return view('staff.userAll',[
            'title' => '전체 회원',
            'groups' => $group->names
        ]);
    }

    public function read(Request $request, string $user_id): Factory|View|Application|RedirectResponse
    {
        return view('staff.userApplicationRead');
    }
}
