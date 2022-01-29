<?php

namespace App\Http\Controllers\Lounge\Mission;

use App\Action\Group\Group;
use App\Action\Survey\SurveyForm;
use App\Http\Controllers\Controller;
use App\Models\Mission;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ApiMissionController extends Controller
{
    public function list(Request $request): JsonResponse
    {
        try {
            $this->jsonValidator($request, [
                'step' => 'int',
                'limit' => 'int',
                'query' => 'array'
            ]);

            $step = $request->get('step', 0);
            $limit = $request->get('limit', 10);
            $q = $request->get('query', []);

            if ($limit < 1 || $limit > 150) $limit = 10;

            $keys = [];
            $items = [];

            $query = new Mission();

            if (isset($q['type'])) {
                $query = $query->where('type', $q['type']);
            }

            if (isset($q['phase'])) {
                $query = $query->where('phase', $q['phase']);
            }

            if (!empty($q['filter'])) {
                switch ($q['filter']) {
                    case '종료된 미션 제외':
                        $query = $query->whereNull('ended_at');
                        break;
                }

            }

            $query = $query->select(['id', 'type', 'expected_at', 'can_tardy', 'user_id', 'phase']);

            $countMission = $query->count();

            if ($step >= 0) {
                $quotient = intdiv($countMission, $limit);
                if ($quotient <= $step) {
                    $step = $quotient - 1; //step 값은 0부터 시작하기 떄문에 1를 빼준다.

                    if ($countMission % $limit > 0) {
                        $step += 1;
                    }
                }
            } else {
                $step = 0;
            }

            $user = $request->user();
            $missions = $query->latest('expected_at')->offset($step * $limit)->limit($limit)->get(['id', 'type', 'expected_at', 'can_tardy', 'user_id', 'phase']);
            $userMissions = $user->missions()->get();
            $userMissionIds = $userMissions->pluck('mission_id')->toArray();

            foreach ($missions as $v) {
                $link =  route('lounge.mission.read', $v->id);
                $button = "<a href='{$link}' class='link-indigo'>미션 정보</a>";

                if (in_array($v->id, $userMissionIds)) {
                    if ($v->user_id != $user->id) {
                        $userMission = $userMissions->first(function ($i) use ($v) {
                            return $i->mission_id == $v->id;
                        });

                        $isFailAttend = $userMission->try_attends >= Mission::$attendTry;
                        $canAttend = !$isFailAttend && $v->phase == 2;
                        $hasAttend = !is_null($userMission->attended_at);

                        if ($v->phase >= 2) {
                            if (!$hasAttend) {
                                if ($canAttend) {
                                    $button = "<a href='{$link}' class='link-yellow'>출석 체크</a>";

                                } else {
                                    if ($isFailAttend) {
                                        $button = "<a href='{$link}' class='link-red'>출석 실패</a>";
                                    } else {
                                        $button = "<a href='{$link}' class='link-red'>출석 마감</a>";
                                    }
                                }

                            } else {
                                $button = "<a href='{$link}' class='link-green'>출석 성공</a>";
                            }
                        }
                    }
                } else {
                    if ($v->phase == 0 || ($v->can_tardy && $v->phase == 1)) {
                        $button = "<a href='{$link}' class='link-fuchsia'>참가 신청</a>";
                    }
                }

                $items[] = [
                    $v->getTypeName(),
                    $v->expected_at->format('m월 d일 H시 i분'),
                    $v->can_tardy ? '가능' : '불가능',
                    $v->user()->first()->nickname,
                    $v->getPhaseName(),
                    $button
                ];
            }

            return $this->jsonResponse(200, 'OK', [
                'fields' => ['분류', '시작 시간', '중도 참여', '미션 메이커', '상태', '&nbsp;&nbsp;&nbsp;'],
                'keys' => $keys,
                'items' => $items,
                'count' => [
                    'step' => $step,
                    'limit' => $limit,
                    'total' => $countMission
                ]
            ]);

        } catch (Exception $e) {
            return $this->jsonResponse($e->getCode(), Str::upper($e->getMessage()), []);
        }
    }

    public function create(Request $request, Group $group, SurveyForm $form): JsonResponse
    {
        try {
            $this->jsonValidator($request, [
                'id' => 'int',
                'type' => 'int|required',
                'date' => 'string|required',
                'time' => 'string|required',
                'map' => 'string|required',
                'addons' => 'array|required',
                'body' => 'string',
                'tardy' => 'boolean|required'
            ]);

            $type = (int) $request->get('type');
            $isSurvey = false;

            switch ($type) {
                case 0:
                    if (!$group->has([Group::ARMA_MAKER2, Group::STAFF])) {
                        throw new Exception('PERMISSION ERROR', 422);
                    }
                    $isSurvey = true;
                    break;

                case 1:
                    if (!$group->has([Group::ARMA_MAKER1, Group::ARMA_MAKER2, Group::STAFF])) {
                        throw new Exception('PERMISSION ERROR', 422);
                    }
                    $isSurvey = true;
                    break;

                case 2:
                    if (!$group->has([Group::ARMA_MAKER1, Group::ARMA_MAKER2, Group::STAFF])) {
                        throw new Exception('PERMISSION ERROR', 422);
                    }
                    break;

                case 10:
                case 11:
                    if (!$group->has([Group::STAFF])) {
                        throw new Exception('PERMISSION ERROR', 422);
                    }
                    break;

                default: throw new Exception('TYPE NOT SELECTED', 422);
            }

            $mission_name = Mission::$typeNames[$type];

            $user = $request->user();
            $date = Carbon::createFromFormat('Y-m-d H:i', "{$request->get('date')} {$request->get('time')}");

            if (now()->unix() > $date->unix()) {
                throw new Exception('DATE OLD', 422);
            }


            if (Mission::whereBetween('expected_at', [$date->copy()->subHours(2), $date->copy()->addHours(2)])->count() > 0) {
                throw new Exception('DATE UNAVAILABLE', 422);
            }

            $mission = Mission::create([
                'user_id' => $user->id,
                'type' => $type,
                'code' => mt_rand(1000, 9999),
                'title' => "{$date->format('m월 d일 H시 i분')} {$mission_name}",
                'body' => strip_tags($request->get('body'), '<h2><h3><h4><p><a><i><br><u><strong><sub><sup><ol><ul><li><blockquote><span><figure><table><tbody><tr><td><oembed><img>'),
                'can_tardy' => !boolval($request->get('tardy')),
                'expected_at' => $date,
                'data' => [
                    'addons' => $request->get('addons'),
                    'map' => $request->get('map')
                ]
            ]);

            if ($isSurvey) {
                $survey = $form->getMissionSurvey($mission);

                $mission->survey_id = $survey->id;
                $mission->save();
            }

            $mission->participants()->create([
                'user_id' => $user->id,
                'mission_id' => $mission->id,
                'is_maker' => true
            ]);

            return $this->jsonResponse(200, 'OK', [
                'url' => route('lounge.mission.read', $mission->id)
            ]);

        } catch (Exception $e) {
            return $this->jsonResponse($e->getCode(), Str::upper($e->getMessage()), []);
        }
    }

    public function update(Request $request, Group $group, int $id): JsonResponse
    {
        try {
            $this->jsonValidator($request, [
                'id' => 'int|required',
                'type' => 'int|required',
                'date' => 'string|required',
                'time' => 'string|required',
                'map' => 'string|required',
                'addons' => 'array|required',
                'body' => 'string',
                'tardy' => 'boolean|required'
            ]);

            if ($id != $request->get('id')) {
                throw new Exception('ID MISMATCHED', 422);
            }

            $mission = Mission::find($request->get('id'));

            if (is_null($mission)) {
                throw new Exception('CAN NOT FOUND MISSION', 422);
            }

            $type = (int) $request->get('type');

            switch ($type) {
                case 0:
                    if (!$group->has([Group::ARMA_MAKER2, Group::STAFF])) {
                        throw new Exception('PERMISSION ERROR', 422);
                    }
                    break;
                case 1:
                case 2:
                    if (!$group->has([Group::ARMA_MAKER1, Group::ARMA_MAKER2, Group::STAFF])) {
                        throw new Exception('PERMISSION ERROR', 422);
                    }
                    break;
                case 10:
                case 11:
                    if (!$group->has([Group::STAFF])) {
                        throw new Exception('PERMISSION ERROR', 422);
                    }
                    break;
                default: throw new Exception('TYPE NOT SELECTED', 422);
            }

            $mission_name = Mission::$typeNames[$type];

            $user = $request->user();
            $date = Carbon::createFromFormat('Y-m-d H:i', "{$request->get('date')} {$request->get('time')}");

            if (now()->unix() > $date->unix()) {
                throw new Exception('DATE OLD', 422);
            }

            $duplicate_missions = Mission::whereBetween('expected_at', [$date->copy()->subHours(2), $date->copy()->addHours(2)])->get();

            $isNotDuplicate = $duplicate_missions->every(function ($v, $k) use($mission) {
                return $v->id == $mission->id;
            });

            if (!$isNotDuplicate) {
                throw new Exception('DATE UNAVAILABLE', 422);
            }

            $mission->update([
                'user_id' => $user->id,
                'type' => $mission->type, //'type' => $request->get('type'), // 미션 수정시 미션 타입을 변경할 수 없다.
                'code' => mt_rand(1000, 9999),
                'title' => "{$date->format('m월 d일')} {$mission_name}",
                'body' => strip_tags($request->get('body'), '<h2><h3><h4><p><a><i><br><u><strong><sub><sup><ol><ul><li><blockquote><span><figure><table><tbody><tr><td><oembed><img>'),
                'can_tardy' => !boolval($request->get('tardy')),
                'expected_at' => $date,
                'data' => [
                    'addons' => $request->get('addons'),
                    'map' => $request->get('map')
                ]
            ]);

            return $this->jsonResponse(200, 'OK', [
                'url' => route('lounge.mission.read', $mission->id)
            ]);

        } catch (Exception $e) {
            return $this->jsonResponse($e->getCode(), Str::upper($e->getMessage()), []);
        }
    }

    public function delete(Request $request, Group $group, int $id): JsonResponse
    {
        try {
            $mission = Mission::find($id);

            if (is_null($mission)) {
                throw new Exception('CAN NOT FOUND MISSION', 422);
            }

            $user = $request->user();

            if ($user->id == $mission->user_id || $group->has(Group::STAFF, $user)) {
                if ($mission->phase > 0) {
                    throw new Exception('MISSION STATUS DOES\'T MATCH THE CONDITIONS', 422);
                }

                $mission->survey()->delete();
                $mission->participants()->delete();
                $mission->delete();
            }

            return $this->jsonResponse(200, 'SUCCESS', []);

        } catch (Exception $e) {
            return $this->jsonResponse($e->getCode(), Str::upper($e->getMessage()), []);
        }
    }

    public function read_process(Request $request, Group $group, int $id): JsonResponse
    {
        try {
            $this->jsonValidator($request, [
                'type' => 'string|required',
            ]);

            $mission = Mission::find($id);

            if (is_null($mission)) {
                throw new Exception('CAN NOT FOUND MISSION', 422);
            }

            $user = $request->user();
            $type = $request->get('type');
            $now = now();

            if ($user->id == $mission->user_id || $group->has(Group::STAFF, $user)) {
                switch ($type) {
                    case 'start':
                        if ($mission->phase != 0) {
                            throw new Exception('MISSION STATUS DOES\'T MATCH THE CONDITIONS', 422);
                        }

                        //TODO - 미션 시작일에만 미션 시작 가능하게 하기.

                        $mission->phase = 1;
                        $mission->started_at = $now;
                        $mission->save();
                        break;

                    case 'end':
                        if ($mission->phase != 1) {
                            throw new Exception('MISSION STATUS DOES\'T MATCH THE CONDITIONS', 422);
                        }
                        $mission->phase = 2;
                        $mission->ended_at = $now;
                        $mission->closed_at = $now->copy()->addHours(Mission::$attendTerm);
                        $mission->save();

                        $makerMission = $mission->participants()->where('user_id', $mission->user_id)->first();
                        $makerMission->attended_at = $now;
                        $makerMission->save();
                        break;

                    case 'cancel':
                        if ($mission->phase != 1) {
                            throw new Exception('MISSION STATUS DOES\'T MATCH THE CONDITIONS', 422);
                        }

                        $mission->phase = -1;
                        $mission->save();
                        break;
                }
            }

            switch ($type) {
                case 'join':
                    if (!($mission->phase == 1 && $mission->can_tardy == 1) && $mission->phase != 0) {
                        throw new Exception('MISSION STATUS DOES\'T MATCH THE CONDITIONS', 422);
                    }

                    if (!$mission->participants()->where('user_id', $user->id)->where('mission_id', $mission->id)->exists()) {
                        $mission->participants()->create([
                            'user_id' => $user->id,
                            'mission_id' => $mission->id,
                            'is_maker' => false,
                        ]);
                    }
                    break;

                case 'leave':
                    if ($mission->phase >= 1) {
                        throw new Exception('MISSION STATUS DOES\'T MATCH THE CONDITIONS', 422);
                    }

                    $mission->participants()->where('user_id', $user->id)->where('mission_id', $mission->id)->delete();
                    break;
            }

            return $this->jsonResponse(200, 'SUCCESS', []);

        } catch (Exception $e) {
            return $this->jsonResponse($e->getCode(), Str::upper($e->getMessage()), []);
        }
    }

    public function read_refresh(Request $request, Group $group, int $id): jsonResponse
    {
        try {
            $mission = Mission::find($id);

            if (is_null($mission)) {
                throw new Exception('CAN NOT FOUND MISSION', 422);
            }

            $user = $request->user();

            $display_timestamp = match ($mission->phase) {
                -1, 0 => $mission->expected_at,
                1, 3 => $mission->started_at,
                2 => $mission->closed_at
            };


            $data = [
                'phase' => $mission->phase,
                'status' => $mission->getPhaseName(),
                'timestamp' => [
                    'display_date' => $display_timestamp->format('Y년 m월 d일'),
                    'display_time' => $display_timestamp->format('H시 i분'),
                    'created_at' => $mission->created_at->format('Y-m-d H:i'),
                    'started_at' => (!is_null($mission->started_at)) ? $mission->started_at->format('Y-m-d H:i') : '',
                    'ended_at' => (!is_null($mission->ended_at)) ? $mission->ended_at->format('Y-m-d H:i') : '',
                    'closed_at' => (!is_null($mission->closed_at)) ? $mission->closed_at->format('Y-m-d H:i') : '',
                ],
                'code' => '',
                'can_tardy' => $mission->can_tardy,
                'body' => $mission->body,
                'is_participant' => ($user->missions()->where('mission_id', $id)->exists() && $mission->user_id != $user->id),
            ];

            if ($user->id == $mission->user_id || $group->has(Group::STAFF, $user)) {
                $data['code'] = ($mission->phase >= 2) ? $mission->code : '';
            }

            return $this->jsonResponse(200, 'SUCCESS', $data);

        } catch (Exception $e) {
            return $this->jsonResponse($e->getCode(), Str::upper($e->getMessage()), []);
        }
    }

    public function read_participants(Request $request, int $id): JsonResponse
    {
        try {
            $mission = Mission::find($id);

            if (is_null($mission)) {
                throw new Exception('CAN NOT FOUND MISSION', 422);
            }

            $data = [];
            $participants = $mission->participants()->select(['user_id', 'is_maker', 'created_at'])->oldest()->get();

            foreach ($participants as $v) {
                $user = $v->user()->first();
                $data[] = [
                    'nickname' => $user->nickname,
                    'avatar' => $user->avatar,
                    'attend' => $user->missions()->whereNotNull('attended_at')->count()
                ];
            }

            return $this->jsonResponse(200, 'SUCCESS', [
                'participants' => $data
            ]);

        } catch (Exception $e) {
            return $this->jsonResponse($e->getCode(), Str::upper($e->getMessage()), []);
        }
    }

    public function attend(Request $request, int $id): JsonResponse
    {
        try {
            $this->jsonValidator($request, [
                'code' => 'string|required',
            ]);

            $mission = Mission::find($id);

            if (is_null($mission)) {
                throw new Exception('CAN NOT FOUND MISSION', 422);
            }

            if ($mission->phase != 2) {
                throw new Exception('ATTEND TIME EXPIRES', 422);
            }

            $code = trim($request->get('code'));
            $user = $request->user();
            $userMission = $mission->participants()->where('user_id', $user->id)->first();

            if (!is_null($mission->survey_id)) {
                if (!$mission->survey()->first()->entries()->where('participant_id', $user->id)->exists()) {
                    throw new Exception('NOT PARTICIPATE IN THE SURVEY', 422);
                }
            }

            if (!is_null($userMission->attended_at)) {
                throw new Exception('ALREADY IN ATTENDANCE', 422);
            }

            if ($userMission->try_attends >= Mission::$attendTry) {
                throw new Exception('ATTEMPTS EXCEEDED', 422);
            }

            $result = false;

            if ($mission->code === $code) {
                $result = true;
                $userMission->attended_at = now();
            }

            $userMission->try_attends += 1;
            $userMission->save();

            return $this->jsonResponse(200, 'SUCCESS', [
                'result' => $result,
                'count' => $userMission->try_attends,
                'limit' => Mission::$attendTry
            ]);

        } catch (Exception $e) {
            return $this->jsonResponse($e->getCode(), Str::upper($e->getMessage()), []);
        }
    }
}
