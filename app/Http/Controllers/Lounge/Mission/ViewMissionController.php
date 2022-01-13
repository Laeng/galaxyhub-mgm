<?php

namespace App\Http\Controllers\Lounge\Mission;

use App\Action\Group\Group;
use App\Http\Controllers\Controller;
use App\Models\Mission;
use App\Models\Survey;
use App\Models\SurveyEntry;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\ArrayShape;

class ViewMissionController extends Controller
{
    public function list(Request $request, Group $group): Factory|View|Application|RedirectResponse
    {
        $now = now();
        $user = $request->user();

        $alerts = [];

        if ($user->missions()->count() <= 0) {
            $expired_at = $user->agreed_at->addDays(14);

            if ($user->agreed_at->diffInDays($expired_at, false) <= 0) { // diffInDays() 기본 반환은 절대 값으로 반환
                $alerts[] = ['danger', '미션 참여 필요', "{$expired_at->format('Y년 m월 d일')} 이전까지 미션에 참석하여 주십시오. 미 참석시 규정에 따라 가입이 취소됩니다."];
            }
        } else {
            $missionLatest = $user->missions()->latest()->first();

            if ($missionLatest->created_at->diffInDays($now, false) >= 15) {
                $alerts[] = ['info', '출석 체크 안내', '30일 이상 미 출석자는 규정에 따라 권한이 정지 됩니다. 반드시 미션 참가 신청과 출석 체크를 해주십시오.'];
            }
        }

        return view('lounge.mission.list', [
            'title' => '미션 목록',
            'alerts' => $alerts,
            'isMaker' => $this->isMaker($request->user(), $group)
        ]);
    }

    public function read(Request $request, Group $group, int $id): Factory|View|Application|RedirectResponse
    {
        $user = $request->user();

        $mission = Mission::find($id);

        if (is_null($mission)) {
            abort(404);
        }

        $maker = $mission->user()->first();
        $isStaff = $group->has(Group::STAFF, $user);
        $isOwner = ($maker->id == $user->id);
        $isParticipant = ($user->missions()->where('mission_id', $mission->id)->exists() && !$isOwner);

        $display_timestamp = match ($mission->phase) {
            -1, 0 => $mission->expected_at,
            1, 3 => $mission->started_at,
            2 => $mission->closed_at
        };

        return view('lounge.mission.read', [
            'id' => $id,
            'mission' => $mission,
            'maker' => $maker,
            'type' => $mission->getTypeName(),
            'code' => ($mission->phase >= 2) ? $mission->code : '',
            'timestamp' => $display_timestamp,
            'isStaff' => $isStaff,
            'isOwner' => $isOwner,
            'isParticipant' => $isParticipant
        ]);
    }

    public function create(Request $request, Group $group): Factory|View|Application|RedirectResponse
    {
        $user = $request->user();

        if (!$this->isMaker($user, $group)) {
            abort(404);
        }

        return view('lounge.mission.create', [
            'title' => '미션 생성',
            'edit' => false,
            'types' => $this->getMissionTypes($user, $group),
            'maps' => $this->getMissionMaps(),
            'addons' => $this->getMissionAddons(),
            'contents' => [
                'type' => '',
                'date' => '',
                'time' => '',
                'map' => '',
                'addons' => [],
                'body' => '',
                'tardy' => false,
            ]
        ]);
    }

    public function update(Request $request, Group $group, int $id): Factory|View|Application|RedirectResponse
    {
        $user = $request->user();
        $mission = Mission::find($id);

        if (is_null($mission) || ($mission->user_id != $user->id && !$group->has(Group::STAFF, $user))) {
            abort(404);
        }

        return view('lounge.mission.create', [
            'title' => '미션 수정',
            'edit' => true,
            'types' => [
                $mission->type => Mission::$typeNames[$mission->type] //미션 수정은 미션 타입을 바꿀 수 없다!
            ],
            'maps' => $this->getMissionMaps(),
            'addons' => $this->getMissionAddons(),
            'contents' => [
                'id' => $mission->id,
                'type' => $mission->type,
                'date' => $mission->expected_at->format('Y-m-d'),
                'time' => $mission->expected_at->format('H:i'),
                'map' => $mission->data['map'],
                'addons' => $mission->data['addons'],
                'body' => $mission->body,
                'tardy' => !$mission->can_tardy, //체크 박스의 기본값 => 중도 참여 비허용
            ]
        ]);
    }

    public function survey(Request $request, Group $group, int $id): Factory|View|Application|RedirectResponse
    {
        $user = $request->user();
        $mission = Mission::find($id);

        if (is_null($mission) || $mission->user_id == $user->id || $mission->phase != 2) {
            abort(404);
        }

        if (is_null($mission->survey_id)) {
            return redirect()->route('lounge.mission.attend', $mission->id);
        }

        $userMission = $user->missions()->where('mission_id', $mission->id)->first();

        if (is_null($userMission)) {
            abort(404);
        }

        $survey = Survey::find($mission->survey_id);
        $userSurvey = $survey->entries()->where('participant_id', $user->id)->latest()->first();

        $hasAttend = !is_null($userMission->attended_at);
        $hasSurvey = !is_null($userSurvey);
        $isClosed = $mission->phase != 2; // 스케쥴러에 의해 phase 가 변경됨

        if (!$hasAttend && $isClosed) {
            abort(404); // 출석체크를 하지 않고, 만족도 조사도 하지 않았다면 거부
        }

        $answer = ($hasSurvey) ? $userSurvey->id : null;

        return view('lounge.mission.survey', [
            'id' => $mission->id,
            'title' => '만족도 조사',
            'type' => $mission->getTypeName(),
            'survey' => $survey,
            'answer' => $answer,
            'hasAttend' => $hasAttend,
            'hasSurvey' => $hasSurvey,
            'isClosed' => $isClosed,
        ]);
    }

    public function attend(Request $request, int $id): Factory|View|Application|RedirectResponse
    {
        $user = $request->user();
        $mission = Mission::find($id);

        if (is_null($mission)) {
            abort(404);
        }

        $userMission = $user->missions()->where('mission_id', $mission->id)->first();

        $canAttend = $userMission->try_attends < Mission::$attendTry;
        $hasAttend = !is_null($userMission->attended_at);
        $hasSurvey = !is_null($mission->survey_id);

        if (!$canAttend || $hasAttend) {
            return redirect()->route('lounge.mission.read', $mission->id)->withErrors([
                'error' => '출석 실패 또는 출석 마감이 되어 출석할 수 없습니다.'
            ]);
        }

        $survey = ($hasSurvey) ? $mission->survey()->first() : null;
        $hasUserSurvey = (!is_null($survey)) ? $survey->entries()->where('participant_id', $user->id)->exists() : false;

        if ($request->isMethod('GET')) {
            if ($hasSurvey) {
                if (!$hasUserSurvey) {
                    return redirect()->route('lounge.mission.survey', $mission->id);
                }
            }

        } else {
            if (!$hasSurvey) {
                return abort(405);
            }

            if (!$hasUserSurvey) {
                $answers = $this->validate($request, $survey->validateRules());
                (new SurveyEntry())->for($survey)->by($user)->fromArray($answers)->push();
            }
        }

        return view('lounge.mission.attend', [
            'id' => $mission->id,
            'title' => '출석'
        ]);
    }


    private function isMaker(User $user, Group $group): bool
    {
        return $group->has([Group::ARMA_MAKER1, Group::ARMA_MAKER2, Group::STAFF]);
    }

    private function getMissionTypes(User $user, Group $group): array
    {
        $original = Mission::$typeNames;
        $types = [];

        if ($group->has([Group::ARMA_MAKER2, Group::STAFF], $user)) {
            $types[0] = $original[0];
        }

        if ($group->has([Group::ARMA_MAKER1, Group::ARMA_MAKER2, Group::STAFF], $user)) {
            $types[1] = $original[1];
            $types[2] = $original[2];
        }

        if ($group->has([Group::STAFF], $user)) {
            $types[10] = $original[10];
            $types[11] = $original[11];
        }

        return $types;
    }

    #[ArrayShape(['알티스' => "string", '스트라티스' => "string", '타노아' => "string", '체르나러스' => "string", '자가바드' => "string", '팔루자' => "string", '기타' => "string"])]
    private function getMissionMaps(): array
    {
        return [
            '알티스' => '알티스',
            '스트라티스' => '스트라티스',
            '타노아' => '타노아',
            '체르나러스' => '체르나러스',
            '자가바드' => '자가바드',
            '팔루자' => '팔루자',
            '기타' => '기타',
        ];
    }

    private function getMissionAddons(): array
    {
        return [
            'RHS' => 'RHS',
            'F1' => 'F1',
            'F2' => 'F2',
            'WAR' => 'WAR',
            'MAPS' => 'MAPS',
            'MAPS2' => 'MAPS2',
            'NAVY' => 'NAVY',
            'etc' => 'etc'
        ];
    }
}
