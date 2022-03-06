<?php

namespace App\Http\Controllers\App\Mission;

use App\Enums\MissionPhaseType;
use App\Enums\MissionType;
use App\Enums\PermissionType;
use App\Http\Controllers\Controller;
use App\Repositories\Mission\Interfaces\MissionRepositoryInterface;
use App\Repositories\User\Interfaces\UserMissionRepositoryInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ListController extends Controller
{
    public function index(Request $request, UserMissionRepositoryInterface $userMissionRepository): View
    {
        $user = Auth::user();
        $missions = $userMissionRepository->findAttendedMissionByUserId($user->id);
        $now = today();
        $messages = array();

        if ($missions->count() <= 0)
        {
            $expired_at = $user->agreed_at->addDays(14);

            if ($user->agreed_at->diffInDays($expired_at, false) <= 0) {
                $messages[] = ['danger', '미션 참여 필요', "{$expired_at->format('Y년 m월 d일')} 이전까지 미션에 참석하여 주십시오. 미 참석시 규정에 따라 가입이 취소됩니다."];
            }
        }
        else
        {
            if ($missions->first()->updated_at->diffInDays($now, false) >= 15)
            {
                $messages[] = ['info', '출석 체크 안내', '30일 이상 미 출석자는 규정에 따라 권한이 정지 됩니다. 반드시 미션 참가 신청과 출석 체크를 해주십시오.'];
                $messages[] = ['info', '장기 미접속 신청 안내', '30일 이상 미션에 참여할 수 없는 경우 장기 미접속을 신청할 수 있습니다.'];
            }
        }

        return view('app.mission.index', [
            'user' => $user,
            'isMaker' => $user->hasAnyPermission([PermissionType::MAKER1->name, PermissionType::MAKER2->name, PermissionType::ADMIN->name]),
            'messages' => $messages,
            'phase' => MissionPhaseType::getKoreanNames(),
            'types' => MissionType::getKoreanNames(),
        ]);
    }

    public function list(Request $request, MissionRepositoryInterface $missionRepository, UserMissionRepositoryInterface $userMissionRepository): JsonResponse
    {
        try {
            $this->jsonValidator($request, [
                'step' => 'int',
                'limit' => 'int',
                'query' => 'array'
            ]);

            $user = Auth::user();
            $step = $request->get('step', 0);
            $limit = $request->get('limit', 10);
            $q = $request->get('query', []);

            if ($limit < 1 || $limit > 150) $limit = 10;

            $order = ['expected_at', 'desc'];
            $columns = ['id', 'type', 'expected_at', 'can_tardy', 'user_id', 'phase', 'title'];
            $conditions = array();

            $query = $missionRepository->new()->newQuery()->select($columns);

            if (isset($q['type'])) {
                $conditions[] = ['type', '=', $q['type']];
            }

            if (isset($q['phase'])) {
                $conditions[] = ['phase', '=', $q['phase']];
            }

            if (!empty($q['filter'])) {
                switch ($q['filter']) {
                    case '종료된 미션 제외':
                        $query = $query->whereNotIn('phase', [MissionPhaseType::END->value, MissionPhaseType::CANCEL]);
                        break;
                }

            }

            foreach ($conditions as $condition)
            {
                $query = $query->where($condition[0], $condition[1], $condition[2]);
            }

            $query = $query->orderBy($order[0], $order[1]);
            $count = $query->count();

            $step = $this->getPaginationStep($step, $limit, $count);
            $missions = $query->offset($step * $limit)->limit($limit)->get();
            $userMissions = $userMissionRepository->findByUserId($user->id, ['id', 'mission_id', 'try_attends', 'attended_at']);

            if ($count > 0)
            {
                $th = ['분류', '시작 시간', '중도 참여', '미션 메이커', '상태', '&nbsp;', '미션'];
                $tr = array();

                $missionType = MissionType::getKoreanNames();
                $missionPhaseType = MissionPhaseType::getKoreanNames();

                foreach ($missions as $v)
                {
                    $userMission = $userMissions->first(fn ($i) => $i->mission_id == $v->id);

                    $url = route('mission.read', $v->id);
                    $text = ['link-indigo', '미션 정보'];


                    if (!is_null($userMission))
                    {
                        if ($v->user_id !== $user->id)
                        {
                            $hasFailAttendance = $userMission->try_attends >= $userMissionRepository::MAX_ATTENDANCE_ATTEMPTS;
                            $hasAttend = !is_null($userMission->attended_at);
                            $canAttend = !$hasFailAttendance && $v->phase === MissionPhaseType::IN_ATTENDANCE->value;

                            if ($v->phase >= MissionPhaseType::IN_ATTENDANCE->value)
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
                    }
                    else
                    {
                        if ($v->phase === MissionPhaseType::RECRUITING->value || ($v->can_tardy && $v->phase === MissionPhaseType::IN_PROGRESS->value))
                        {
                            $text = ['link-fuchsia', '참가 신청'];
                        }
                    }

                    $row = [
                        $missionType[$v->type],
                        $v->expected_at->format('m월 d일 H시 i분'),
                        $v->can_tardy ? '가능' : '불가능',
                        $v->user()->first()->name,
                        $missionPhaseType[$v->phase],
                        "<a href='{$url}' class='{$text[0]}' title='{$text[1]}'>{$text[1]}</a>",
                        "<a href='{$url}' title='{$v->title}'><div class='flex justify-between'><p>{$v->title}</p><p class='{$text[0]}'>{$text[1]}</p></div>"
                    ];

                    $tr[] = $row;
                }
            }
            else
            {
                $th = ['등록된 미션이 없습니다.', '등록된 미션이 없습니다.'];
                $tr = array();
            }


            return $this->jsonResponse(200, 'OK', [
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

        } catch (\Exception $e) {
            return $this->jsonResponse($e->getCode(), Str::upper($e->getMessage()), config('app.debug') ? $e->getTrace() : [
                'checkbox' => false,
                'mobile' => true,
                'name' => '',
                'th' => [],
                'tr' => [],
                'count' => [
                    'step' => 0,
                    'limit' => 0,
                    'total' => 0
                ]
            ]);
        }
    }
}
