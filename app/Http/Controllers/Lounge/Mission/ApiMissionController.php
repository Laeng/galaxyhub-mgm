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
use Str;

class ApiMissionController extends Controller
{
    public function list(Request $request): JsonResponse
    {
        try {
            $this->jsonValidator($request, [
                'step' => 'int',
                'limit' => 'int'
            ]);

            $step = $request->get('step', 0);
            $limit = $request->get('limit', 20);

            if ($limit < 1 || $limit > 100) $limit = 20;

            $keys = [];
            $items = [];

            $query = Mission::select(['id', 'type', 'expected_at', 'can_tardy', 'user_id', 'phase']);
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

            $missions = $query->latest()->offset($step * $limit)->limit($limit)->get(['id', 'type', 'expected_at', 'can_tardy', 'user_id', 'phase']);

            foreach ($missions as $v) {
                $items[] = [
                    $v->id,
                    $v->getTypeName(),
                    $v->getPhaseName(),
                    $v->expected_at->format('m월 d일 H시 i분'),
                    $v->can_tardy ? '가능' : '불가능',
                    $v->user()->first()->nickname,
                    "<a href='". route('mission.read', $v->id) . "' class='text-indigo-600 hover:text-indigo-900'>" . (($v->phase == 0 || ($v->can_tardy && $v->phase == 1)) ? '신청하기' : '상세보기') . '</a>'
                ];
            }

            return $this->jsonResponse(200, 'OK', [
                'fields' => ['ID', '분류', '상태', '시작 시간', '중도 참여', '미션 메이커', '&nbsp;&nbsp;&nbsp;'],
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

            switch ($request->get('type')) {
                case 0:
                    if (!$group->has([Group::ARMA_MAKER2, Group::STAFF])) {
                        throw new Exception('PERMISSION ERROR', 422);
                    }
                    break;
                case 1:
                    if (!$group->has([Group::ARMA_MAKER1, Group::ARMA_MAKER2, Group::STAFF])) {
                        throw new Exception('PERMISSION ERROR', 422);
                    }
                    break;
                case 2:
                case 3:
                    if (!$group->has([Group::STAFF])) {
                        throw new Exception('PERMISSION ERROR', 422);
                    }
                    break;
                default: throw new Exception('TYPE NOT SELECTED', 422);
            }

            $mission_name = Mission::$typeNames[$request->get('type')];

            $user = $request->user();
            $date = Carbon::createFromFormat('Y-m-d H:i', "{$request->get('date')} {$request->get('time')}");

            if (now()->unix() > $date->unix()) {
                throw new Exception('DATE OLD', 422);
            }


            if (Mission::whereBetween('expected_at', [$date->copy()->subHours(), $date->copy()->addHours()])->count() > 0) {
                throw new Exception('DATE UNAVAILABLE', 422);
            }

            $mission = Mission::create([
                'user_id' => $user->id,
                'type' => $request->get('type'),
                'code' => mt_rand(1000, 9999),
                'title' => "{$date->format('m월 d일')} {$mission_name}",
                'body' => strip_tags($request->get('body'), '<h2><h3><h4><p><a><i><br><strong><sub><sup><ol><ul><li><blockquote>'),
                'can_tardy' => $request->get('tardy'),
                'expected_at' => $date,
                'data' => [
                    'addons' => $request->get('addons'),
                    'map' => $request->get('map')
                ]
            ]);

            $survey = $form->getMissionSurveyForm($mission);

            $mission->survey_id = $survey->id;
            $mission->save();

            $mission->participants()->create([
                'user_id' => $user->id,
                'mission_id' => $mission->id,
                'is_maker' => true,
                'is_attended' => true
            ]);

            return $this->jsonResponse(200, 'OK', [
                'url' => route('mission.read', $mission->id)
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

            switch ($request->get('type')) {
                case 0:
                    if (!$group->has([Group::ARMA_MAKER2, Group::STAFF])) {
                        throw new Exception('PERMISSION ERROR', 422);
                    }
                    break;
                case 1:
                    if (!$group->has([Group::ARMA_MAKER1, Group::ARMA_MAKER2, Group::STAFF])) {
                        throw new Exception('PERMISSION ERROR', 422);
                    }
                    break;
                case 2:
                case 3:
                    if (!$group->has([Group::STAFF])) {
                        throw new Exception('PERMISSION ERROR', 422);
                    }
                    break;
                default: throw new Exception('TYPE NOT SELECTED', 422);
            }

            $mission_name = Mission::$typeNames[$request->get('type')];

            $user = $request->user();
            $date = Carbon::createFromFormat('Y-m-d H:i', "{$request->get('date')} {$request->get('time')}");

            if (now()->unix() > $date->unix()) {
                throw new Exception('DATE OLD', 422);
            }

            $duplicate_missions = Mission::whereBetween('expected_at', [$date->copy()->subHours(), $date->copy()->addHours()])->get();

            $isNotDuplicate = $duplicate_missions->every(function ($v, $k) use($mission) {
                return $v->id == $mission->id;
            });

            if (!$isNotDuplicate) {
                throw new Exception('DATE UNAVAILABLE', 422);
            }

            $mission->update([
                'user_id' => $user->id,
                'type' => $request->get('type'),
                'code' => mt_rand(1000, 9999),
                'title' => "{$date->format('m월 d일')} {$mission_name}",
                'body' => strip_tags($request->get('body'), '<h2><h3><h4><p><a><i><br><strong><sub><sup><ol><ul><li><blockquote>'),
                'can_tardy' => $request->get('tardy'),
                'expected_at' => $date,
                'data' => [
                    'addons' => $request->get('addons'),
                    'map' => $request->get('map')
                ]
            ]);

            return $this->jsonResponse(200, 'OK', [
                'url' => route('mission.read', $mission->id)
            ]);

        } catch (Exception $e) {
            return $this->jsonResponse($e->getCode(), Str::upper($e->getMessage()), []);
        }
    }

    public function delete(Request $request, Group $group): JsonResponse
    {
        try {
            $this->jsonValidator($request, [
                'id' => 'int|required',
            ]);

            $mission = Mission::find($request->get('id'));

            if (is_null($mission)) {
                throw new Exception('CAN NOT FOUND MISSION', 422);
            }

            $user = $request->user();

            if ($user->id == $mission->user_id || $group->has(Group::STAFF, $user)) {
                if ($mission->phase > 0) {
                    throw new Exception('CAN NOT DELETE MISSION BECAUSE MISSION STATUS IS NOT READY', 422);
                }

                $mission->survey()->sections()->questions()->delete();
                $mission->survey()->sections()->delete();
                $mission->survey()->questions()->delete();
                $mission->survey()->delete();
                $mission->participants()->delete();
                $mission->delete();
            }

        } catch (Exception $e) {
            return $this->jsonResponse($e->getCode(), Str::upper($e->getMessage()), []);
        }
    }

}
