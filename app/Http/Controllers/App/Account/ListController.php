<?php

namespace App\Http\Controllers\App\Account;

use App\Enums\MissionPhaseType;
use App\Enums\MissionType;
use App\Http\Controllers\Controller;
use App\Repositories\Mission\Interfaces\MissionRepositoryInterface;
use App\Repositories\User\Interfaces\UserMissionRepositoryInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListController extends Controller
{
    private UserMissionRepositoryInterface $userMissionRepository;

    public function __construct
    (
        UserMissionRepositoryInterface $userMissionRepository
    )
    {
        $this->userMissionRepository = $userMissionRepository;
    }

    public function mission(): View
    {
        return view('app.account.missions', [
            'title' => '미션 기록',
            'user' => Auth::user(),
            'types' => MissionType::getKoreanNames()
        ]);
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
            $step = $request->get('step', 0);
            $limit = $request->get('limit', 10);
            $q = $request->get('query', []);

            $query = $this->userMissionRepository->new()->where('user_id', $user->id)->where('is_maker', false);
            $conditions = array();

            if (isset($q['type'])) {
                $conditions[] = ['type', '=', $q['type']];
            }

            foreach ($conditions as $condition)
            {
                $query = $query->whereHas('mission', function ($query) use ($condition) {
                    $query->where($condition[0], $condition[1], $condition[2]);
                });
            }

            $count = $query->count();

            $th = ['분류', '시작 시간', '미션 메이커', '&nbsp;', '미션'];
            $tr = array();

            if ($count > 0)
            {
                $step = $this->getPaginationStep($step, $limit, $count);
                $userMission = $query->latest()->offset($step * $limit)->limit($limit)->get();

                $missionType = MissionType::getKoreanNames();

                foreach ($userMission as $item)
                {
                    $mission = $item->mission;
                    $url = route('mission.read', $mission->id);
                    $text = ['link-indigo', '미션 정보'];

                    if ($mission->user_id !== $user->id)
                    {
                        $hasFailAttendance = $item->try_attends >= $this->userMissionRepository::MAX_ATTENDANCE_ATTEMPTS;
                        $hasAttend = !is_null($item->attended_at);
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

                    $row = [
                        $missionType[$mission->type],
                        $mission->expected_at->format('m월 d일 H시 i분'),
                        $mission->user()->first()->name,
                        "<a href='{$url}' class='{$text[0]}' title='{$text[1]}'>{$text[1]}</a>",
                        "<a href='{$url}' title='{$mission->title}'><div class='flex justify-between'><p>{$mission->title}</p><p class='{$text[0]}'>{$text[1]}</p></div>"
                    ];

                    $tr[] = $row;
                }

            }
            else
            {
                $th = ['신청한 미션이 없습니다.', '신청한 미션이 없습니다.'];
            }


            return $this->jsonResponse(200, 'SUCCESS', [
                'checkbox' => false,
                'mobile' => true,
                'name' => '',
                'th' => $th,
                'tr' => $tr,
                'count' => [
                    'step' => $step,
                    'limit' => $limit,
                    'total' => $count
                ]
            ]);
        }
        catch (\Exception $e)
        {
            return $this->jsonResponse($e->getCode(), $e->getMessage(), config('app.debug') ? $e->getTrace() : []);
        }
    }

    public function make(Request $request): JsonResponse
    {
        try
        {
            $this->jsonValidator($request, [
                'step' => 'int',
                'limit' => 'int',
                'query' => 'array'
            ]);

            $user = Auth::user();
            $step = $request->get('step', 0);
            $limit = $request->get('limit', 10);
            $q = $request->get('query', []);

            $query = $this->userMissionRepository->new()->where('user_id', $user->id)->where('is_maker', true);
            $conditions = array();

            if (isset($q['type'])) {
                $conditions[] = ['type', '=', $q['type']];
            }

            foreach ($conditions as $condition)
            {
                $query = $query->whereHas('mission', function ($query) use ($condition) {
                    $query->where($condition[0], $condition[1], $condition[2]);
                });
            }

            $count = $query->count();

            $th = ['분류', '시작 시간', '미션 메이커', '&nbsp;', '미션'];
            $tr = array();

            if ($count > 0)
            {
                $step = $this->getPaginationStep($step, $limit, $count);
                $userMission = $query->latest()->offset($step * $limit)->limit($limit)->get();

                $missionType = MissionType::getKoreanNames();

                foreach ($userMission as $item)
                {
                    $mission = $item->mission;
                    $url = route('mission.read', $mission->id);
                    $text = ['link-indigo', '미션 정보'];

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

                    $row = [
                        $missionType[$mission->type],
                        $mission->expected_at->format('m월 d일 H시 i분'),
                        $mission->user()->first()->name,
                        "<a href='{$url}' class='{$text[0]}' title='{$text[1]}'>{$text[1]}</a>",
                        "<a href='{$url}' title='{$mission->title}'><div class='flex justify-between'><p>{$mission->title}</p><p class='{$text[0]}'>{$text[1]}</p></div>"
                    ];

                    $tr[] = $row;
                }

            }
            else
            {
                $th = ['만든 미션이 없습니다.', '만든 미션이 없습니다.'];
            }


            return $this->jsonResponse(200, 'SUCCESS', [
                'checkbox' => false,
                'mobile' => true,
                'name' => '',
                'th' => $th,
                'tr' => $tr,
                'count' => [
                    'step' => $step,
                    'limit' => $limit,
                    'total' => $count
                ]
            ]);
        }
        catch (\Exception $e)
        {
            return $this->jsonResponse($e->getCode(), $e->getMessage(), config('app.debug') ? $e->getTrace() : []);
        }
    }
}
