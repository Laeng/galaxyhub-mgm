<?php

namespace App\Http\Controllers\App\Mission;

use App\Enums\MissionPhaseType;
use App\Enums\MissionType;
use App\Enums\PermissionType;
use App\Enums\RoleType;
use App\Http\Controllers\Controller;
use App\Repositories\Mission\Interfaces\MissionRepositoryInterface;
use App\Repositories\Survey\Interfaces\SurveyRepositoryInterface;
use App\Repositories\User\Interfaces\UserMissionRepositoryInterface;
use App\Repositories\User\Interfaces\UserRepositoryInterface;
use App\Services\Mission\Contracts\MissionServiceContract;
use Auth;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ReadController extends Controller
{
    private MissionRepositoryInterface $missionRepository;
    private UserMissionRepositoryInterface $userMissionRepository;
    private MissionServiceContract $missionService;

    public function __construct
    (
        MissionRepositoryInterface $missionRepository, UserMissionRepositoryInterface $userMissionRepository,
        MissionServiceContract $missionService
    )
    {
        $this->missionRepository = $missionRepository;
        $this->userMissionRepository = $userMissionRepository;
        $this->missionService = $missionService;
    }

    public function delete(Request $request, SurveyRepositoryInterface $surveyRepository): JsonResponse
    {
        try
        {
            $this->jsonValidator($request, [
                'id' => ['required', 'int'],
            ]);

            $mission = $this->missionRepository->findById($request->get('id'));

            if (is_null($mission))
            {
                throw new \Exception('CAN NOT FOUND MISSION', 422);
            }

            $user = Auth::user();

            if ($user->id === $mission->user_id || $user->hasRole(RoleType::ADMIN->name))
            {
                if ($mission->phase > 0) {
                    throw new \Exception('MISSION STATUS DOES\'T MATCH THE CONDITIONS', 422);
                }

                if (!is_null($mission->survey_id))
                {
                    $survey = $surveyRepository->findById($mission->survey_id);

                    if (!is_null($survey))
                    {
                        $survey->delete();
                    }
                }

                $mission->participants()->delete();
                $mission->delete();
            }

            return $this->jsonResponse(200, 'SUCCESS', []);

        }
        catch (\Exception $e)
        {
            return $this->jsonResponse($e->getCode(), Str::upper($e->getMessage()), []);
        }
    }

    public function read(Request $request, int $missionId, UserRepositoryInterface $userRepository): View
    {
        $user = Auth::user();
        $mission = $this->missionRepository->findById($missionId);

        if (is_null($mission))
        {
            abort(404);
        }

        $userMission = $this->userMissionRepository->findByUserId($user->id)->first(fn ($i) => $i->mission_id === $mission->id);
        $maker = $userRepository->findById($mission->user_id);

        $isAdmin = $user->hasPermissionTo(PermissionType::ADMIN->name);
        $isMaker = $maker->id === $user->id;
        $isParticipant = !is_null($userMission) && !$isMaker;
        $visibleDate = $this->visibleDate($mission);

        $code = ($isMaker || $isAdmin) ? $mission->code : '';

        return view('app.mission.read', [
            'user' => $user,
            'maker' => $maker,
            'mission' => $mission,
            'type' => MissionType::getKoreanNames()[$mission->type],
            'status' => MissionPhaseType::getKoreanNames()[$mission->phase],
            'code' => ($mission->phase >= MissionPhaseType::IN_ATTENDANCE) ? $code : '',
            'timestamp' => $visibleDate,
            'isAdmin' => $isAdmin,
            'isMaker' => $isMaker,
            'isParticipant' => $isParticipant
        ]);
    }

    public function process(Request $request, int $missionId): JsonResponse
    {
        try {
            $this->jsonValidator($request, [
                'type' => 'string|required',
            ]);

            $mission = $this->missionRepository->findById($missionId);

            if (is_null($mission))
            {
                throw new \Exception('CAN NOT FOUND MISSION', 422);
            }

            $user = Auth::user();
            $type = $request->get('type'); // 미션 타입이 아님...
            $now = now();

            if
            (
                $user->id == $mission->user_id ||
                $user->hasAnyPermission([PermissionType::MAKER1->name, PermissionType::MAKER2, PermissionType::ADMIN])
            )
            {
                switch($type)
                {
                    case 'START':
                        if ($mission->phase !== MissionPhaseType::RECRUITING->value)
                        {
                            throw new \Exception('MISSION STATUS DOES\'T MATCH THE CONDITIONS', 422);
                        }

                        $mission->phase = MissionPhaseType::IN_PROGRESS->value;
                        $mission->started_at = $now;
                        $mission->save();
                        break;

                    case 'END':
                        if ($mission->phase !== MissionPhaseType::IN_PROGRESS->value)
                        {
                            throw new \Exception('MISSION STATUS DOES\'T MATCH THE CONDITIONS', 422);
                        }

                        $mission->phase = MissionPhaseType::IN_ATTENDANCE->value;
                        $mission->ended_at = $now;
                        $mission->closed_at = $now->copy()->addHours($this->missionRepository::PERIOD_OF_ATTENDANCE);
                        $mission->started_at = $now;
                        $mission->save();

                        $makerMission = $this->userMissionRepository->findByUserIdAndMissionId($mission->user_id, $mission->id);
                        $makerMission->attended_at = $now;
                        $makerMission->save();
                        break;

                    case 'CANCEL':
                        if ($mission->phase !== MissionPhaseType::RECRUITING->value)
                        {
                            throw new \Exception('MISSION STATUS DOES\'T MATCH THE CONDITIONS', 422);
                        }

                        $mission->phase = MissionPhaseType::CANCEL->value;
                        $mission->save();
                        break;
                }
            }

            switch ($type)
            {
                case 'JOIN':
                    if
                    (
                        !($mission->phase == MissionPhaseType::IN_PROGRESS->value && $mission->can_tardy) &&
                        $mission->phase != MissionPhaseType::RECRUITING->value
                    )
                    {
                        throw new \Exception('MISSION STATUS DOES\'T MATCH THE CONDITIONS', 422);
                    }

                    $this->missionService->addParticipant($mission->id, $user->id);
                    break;

                case 'LEAVE':
                    if ($mission->phase >= MissionPhaseType::IN_PROGRESS->value) {
                        throw new \Exception('MISSION STATUS DOES\'T MATCH THE CONDITIONS', 422);
                    }

                    $this->missionService->removeParticipant($mission->id, $user->id);
                    break;
            }

            return $this->jsonResponse(200, 'SUCCESS', []);

        } catch (\Exception $e) {
            return $this->jsonResponse($e->getCode(), Str::upper($e->getMessage()), config('app.debug') ? $e->getTrace() : []);
        }
    }

    public function refresh(Request $request, int $missionId): JsonResponse
    {
        try {
            $mission = $this->missionRepository->findById($missionId);

            if (is_null($mission))
            {
                throw new \Exception('CAN NOT FOUND MISSION', 422);
            }

            $user = Auth::user();
            $visibleDate = $this->visibleDate($mission);

            $userMissions = $this->userMissionRepository->findByUserIdAndMissionId($user->id, $mission->id);

            $data = [
                'phase' => $mission->phase,
                'status' => MissionPhaseType::getKoreanNames()[$mission->phase],
                'timestamp' => [
                    'display_date' => $visibleDate->format('Y년 m월 d일'),
                    'display_time' => $visibleDate->format('H시 i분'),
                    'created_at' => $mission->created_at->format('Y-m-d H:i'),
                    'started_at' => (!is_null($mission->started_at)) ? $mission->started_at->format('Y-m-d H:i') : '',
                    'ended_at' => (!is_null($mission->ended_at)) ? $mission->ended_at->format('Y-m-d H:i') : '',
                    'closed_at' => (!is_null($mission->closed_at)) ? $mission->closed_at->format('Y-m-d H:i') : '',
                ],
                'code' => '',
                'can_tardy' => $mission->can_tardy,
                'body' => $mission->body,
                'is_participant' => (!is_null($userMissions) && $mission->user_id != $user->id),
            ];

            if ($user->id == $mission->user_id || $user->hasPermissionTo(PermissionType::ADMIN->name)) {
                $data['code'] = ($mission->phase >= MissionPhaseType::IN_ATTENDANCE->value) ? $mission->code : '';
            }

            return $this->jsonResponse(200, 'SUCCESS', $data);

        } catch (\Exception $e) {
            return $this->jsonResponse($e->getCode(), Str::upper($e->getMessage()), []);
        }
    }

    public function participants(Request $request, int $missionId, UserRepositoryInterface $userRepository): JsonResponse
    {
        try {
            $mission = $this->missionRepository->findById($missionId);

            if (is_null($mission))
            {
                throw new \Exception('CAN NOT FOUND MISSION', 422);
            }

            $data = [];
            $participants = $this->userMissionRepository->findByMissionId($mission->id)->reverse();

            foreach ($participants as $k => $v)
            {
                $user = $userRepository->findById($v->user_id);
                $data[] = [
                    'name' => $user->name,
                    'avatar' => $user->avatar,
                    'attend' => $this->userMissionRepository->findAttendedMissionByUserId($user->id)->count() // TODO - 약장으로 대체
                ];
            }

            return $this->jsonResponse(200, 'SUCCESS', [
                'participants' => $data
            ]);

        } catch (\Exception $e) {
            return $this->jsonResponse($e->getCode(), Str::upper($e->getMessage()), []);
        }
    }

    private function visibleDate(Model $mission)
    {
        return match ($mission->phase) {
            MissionPhaseType::CANCEL->value, MissionPhaseType::RECRUITING->value => $mission->expected_at,
            MissionPhaseType::IN_PROGRESS->value, MissionPhaseType::END->value => $mission->started_at,
            MissionPhaseType::IN_ATTENDANCE->value => $mission->closed_at
        };
    }

}
