<?php

namespace App\Http\Controllers\App\Mission;

use App\Enums\PermissionType;
use App\Http\Controllers\Controller;
use App\Repositories\Mission\Interfaces\MissionRepositoryInterface;
use App\Repositories\User\Interfaces\UserMissionRepositoryInterface;
use App\Repositories\User\Interfaces\UserRepositoryInterface;
use Auth;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ReadController extends Controller
{
    public function __invoke(Request $request, int $missionId, MissionRepositoryInterface $missionRepository, UserMissionRepositoryInterface $userMissionRepository, UserRepositoryInterface $userRepository): View
    {
        $user = Auth::user();
        $mission = $missionRepository->findById($missionId);

        if (is_null($mission))
        {
            abort(404);
        }

        $userMission = $userMissionRepository->findByUserId($user->id)->first(fn ($i) => $i->mission_id === $mission->id);
        $maker = $userRepository->findById($mission->maker_id);

        $isAdmin = $user->hasPermissionTo(PermissionType::ADMIN->name);
        $isMaker = $maker->id === $user->id;
        $isParticipant = !is_null($userMission) && !$isMaker;

        $visibleDate = match ($mission->phase) {
            -1, 0 => $mission->expected_at,
            1, 3 => $mission->started_at,
            2 => $mission->closed_at
        };

        return view('app.mission.read', [
            'user' => $user,
            'maker' => $maker,
            'mission' => $mission,
            'visibleDate' => $visibleDate,
            'isAdmin' => $isAdmin,
            'isMaker' => $isMaker,
            'isParticipant' => $isParticipant
        ]);
    }
}
