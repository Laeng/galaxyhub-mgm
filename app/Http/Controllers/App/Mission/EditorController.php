<?php

namespace App\Http\Controllers\App\Mission;

use App\Enums\MissionAddonType;
use App\Enums\MissionMapType;
use App\Enums\MissionType;
use App\Enums\PermissionType;
use App\Enums\RoleType;
use App\Http\Controllers\Controller;
use App\Repositories\Mission\Interfaces\MissionRepositoryInterface;
use App\Repositories\User\Interfaces\UserMissionRepositoryInterface;
use App\Repositories\User\Interfaces\UserRepositoryInterface;
use Auth;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class EditorController extends Controller
{
    private MissionRepositoryInterface $missionRepository;

    public function __construct(MissionRepositoryInterface $missionRepository)
    {
        $this->missionRepository = $missionRepository;
    }

    public function new(Request $request, UserMissionRepositoryInterface $userMissionRepository, UserRepositoryInterface $userRepository): View
    {
        $user = Auth::user();

        if ($user->hasAnyPermission([PermissionType::MAKER1->name, PermissionType::MAKER2->name]))
        {
            abort(404);
        }

        return view('app.mission.editor', [
            'user' => $user,
            'mission' => null,
            'title' => '새로운 미션',
            'edit' => false,
            'types' => MissionType::getTypeByRole($user->roles()->latest()->first()->name),
            'maps' => MissionMapType::getKoreanNames(),
            'addons' => MissionAddonType::getKoreanNames(),
        ]);
    }

    public function edit(Request $request, int $missionId): View
    {
        $user = Auth::user();
        $mission = $this->missionRepository->findById($missionId);

        if (is_null($mission) || ($mission->user_id !== $user->id) && !$user->hasRole(RoleType::ADMIN->name))
        {
            abort(404);
        }

        return view('app.mission.editor', [
            'user' => $user,
            'mission' => $mission,
            'title' => $mission->title,
            'edit' => true,
            'types' => [
                $mission->type => MissionMapType::getKoreanNames()[$mission->type] // 미션 수정은 미션 타입을 바꿀 수 없다.
            ],
            'maps' => MissionMapType::getKoreanNames(),
            'addons' => MissionAddonType::getKoreanNames(),
        ]);
    }
}
