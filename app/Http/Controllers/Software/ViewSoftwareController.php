<?php

namespace App\Http\Controllers\Software;

use App\Action\Group\Group;
use App\Http\Controllers\Controller;
use App\Models\UserSoftware;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ViewSoftwareController extends Controller
{
    public function authorize_code(Request $request, string $code, Group $group): Factory|View|Application|RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => ['string', 'required']
        ]);

        $data = [
            'status' => false,
            'softwareName' => '',
            'machineName' => '',
            'machineIp' => ''
        ];

        if (!$validator->fails())
        {
            $user = $request->user();
            $userSoftware = UserSoftware::whereNull('user_id')->where('machine_name', base64_decode($request->get('name')))->where('code', $code)->latest()->first();

            if (!is_null($userSoftware) && !$user->isBanned())
            {
                if ($group->has([Group::ARMA_MEMBER, Group::ARMA_MAKER1, Group::ARMA_MAKER2, Group::STAFF], $user))
                {
                    $userSoftware->user_id = $user->id;
                    $userSoftware->save();

                    $software = $userSoftware->software()->latest()->first();

                    $data = [
                        'status' => true,
                        'softwareName' => $software->title,
                        'machineName' => $userSoftware->machine_name,
                        'machineIp' => $userSoftware->ip
                    ];
                }
            }
        }

        return view('software.authorize', $data);
    }


}
