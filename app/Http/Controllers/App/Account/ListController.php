<?php

namespace App\Http\Controllers\App\Account;

use App\Enums\MissionPhaseType;
use App\Http\Controllers\Controller;
use App\Repositories\Mission\Interfaces\MissionRepositoryInterface;
use App\Repositories\User\Interfaces\UserMissionRepositoryInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListController extends Controller
{
    private MissionRepositoryInterface $missionRepository;
    private UserMissionRepositoryInterface $userMissionRepository;

    public function __construct
    (
        MissionRepositoryInterface $missionRepository, UserMissionRepositoryInterface $userMissionRepository
    )
    {
        $this->missionRepository = $missionRepository;
        $this->userMissionRepository = $userMissionRepository;
    }

    public function index(): View
    {

    }

    public function participate(Request $request): JsonResponse
    {
        try
        {
            $this->jsonValidator($request, [
                'step' => 'int',
                'limit' => 'int',
                'query' => 'array'
            ]);

            $user = Auth::user();
            $userMission = $this->userMissionRepository->findByUserId($user->id, ['*'], ['mission']);

            foreach ($userMission as $item)
            {
                $mission = $item->mission;

                if ($mission->user_id !== $user->id)
                {
                    $hasFailAttendance = $userMission->try_attends >= $this->userMissionRepository::MAX_ATTENDANCE_ATTEMPTS;
                    $hasAttend = !is_null($userMission->attended_at);
                    $canAttend = !$hasFailAttendance && $mission->phase === MissionPhaseType::IN_ATTENDANCE->value;

                    if ($mission->phase >= MissionPhaseType::IN_ATTENDANCE->value)
                    {
                        if (!$hasAttend)
                        {
                            if ($canAttend)
                            {
                                $text = ['link-yellow', '출석 하기'];
                            }
                            else
                            {
                                $text = ['link-red', '출석 실패'];
                            }
                        }
                        else
                        {
                            $text = ['link-green', '출석 성공'];
                        }
                    }
                }
                else
                {
                    if ($mission->phase === MissionPhaseType::RECRUITING->value || ($mission->can_tardy && $mission->phase === MissionPhaseType::IN_PROGRESS->value))
                    {
                        $text = ['link-fuchsia', '참가 신청'];
                    }
                }
            }



            return $this->jsonResponse(200, 'SUCCESS', []);
        }
        catch (\Exception $e)
        {
            return $this->jsonResponse($e->getCode(), $e->getMessage(), config('app.debug') ? $e->getTrace() : []);
        }
    }

    public function make(): JsonResponse
    {
        try
        {
            $user = Auth::user();



            return $this->jsonResponse(200, 'SUCCESS', []);
        }
        catch (\Exception $e)
        {
            return $this->jsonResponse($e->getCode(), $e->getMessage(), config('app.debug') ? $e->getTrace() : []);
        }
    }
}
