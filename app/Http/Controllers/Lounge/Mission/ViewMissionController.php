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

        if (is_null($mission)) {
            abort(404);
        }

        $isOwner = $mission->user_id == $user->id;
        $hasSurvey = !is_null($mission->survey_id);

        if (!$hasSurvey) {
            abort(404);
        }

        $userMission = $user->missions()->where('mission_id', $mission->id)->first();

        if (is_null($userMission)) {
            abort(404);
        }

        $isFailAttend = $userMission->try_attends >= Mission::$attendTry;
        $canAttend = !$isFailAttend && $mission->phase == 2;
        $hasAttend = !is_null($userMission->attended_at);

        if (!$canAttend && !$hasAttend && !$isFailAttend) {
            return redirect()->route('lounge.mission.read', $mission->id)->withErrors([
                'error' => '만족도 조사 기간이 아닙니다.'
            ]);
        }

        $survey = Survey::find($mission->survey_id);
        $userSurvey = $survey->entries()->where('participant_id', $user->id)->latest()->first();
        $hasUserSurvey = !is_null($userSurvey);
        $surveyAnswerId = $hasUserSurvey ? $userSurvey->id : null;

        return view('lounge.mission.survey', [
            'id' => $mission->id,
            'title' => '만족도 조사',
            'type' => $mission->getTypeName(),
            'survey' => $survey,
            'answer' => $surveyAnswerId,
            'canAttend' => $canAttend,
            'hasAttend' => $hasAttend,
            'hasUserSurvey' => $hasUserSurvey,
            'hasUserSurveyDate' => ($hasUserSurvey) ? $userSurvey->created_at : ''
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

        if (is_null($userMission)) {
            abort(404);
        }

        $isOwner = $mission->user_id == $user->id;
        $isFailAttend = $userMission->try_attends >= Mission::$attendTry;
        $canAttend = !$isFailAttend && $mission->phase == 2;
        $hasAttend = !is_null($userMission->attended_at);
        $hasSurvey = !is_null($mission->survey_id);

        if (!$canAttend && !$isFailAttend) {
            return redirect()->route('lounge.mission.read', $mission->id)->withErrors([
                'error' => '출석 기간이 아닙니다.'
            ]);
        }

        if ($isFailAttend) {
            return redirect()->route('lounge.mission.read', $mission->id)->withErrors([
                'error' => '출석 시도 횟수 초과로 출석 할 수 없습니다.'
            ]);
        }

        if ($hasAttend) {
            return redirect()->route('lounge.mission.read', $mission->id)->withErrors([
                'error' => '이미 출석 하셨습니다.'
            ]);
        }

        $survey = ($hasSurvey) ? $mission->survey()->first() : null;
        $hasUserSurvey = (!is_null($survey)) ? $survey->entries()->where('participant_id', $user->id)->exists() : false;

        if ($request->isMethod('GET')) {
            if ($hasSurvey) {
                if (!$hasUserSurvey) {
                    return redirect()->route('lounge.mission.survey', $mission->id)->withErrors([
                        'error' => '출석 체크 전 만족도 조사에 참여하여 주십시오.'
                    ]);
                }

                if ($isOwner) {
                    return redirect()->route('lounge.mission.survey', $mission->id)->withErrors([
                        'error' => '미션 메이커는 미션 종료시 자동으로 출석 체크 되므로 출석 체크를 할 필요가 없습니다.'
                    ]);
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
            'type' => $mission->getTypeName(),
            'title' => '출석'
        ]);
    }

    public function report(Request $request, Group $group, int $id): Factory|View|Application|RedirectResponse
    {
        $user = $request->user();
        $mission = Mission::find($id);

        if (is_null($mission) || is_null($mission->survey_id)) {
            abort(404);
        }

        $isOwner = $mission->user_id === $user->id;
        $isStaff = $group->has(Group::STAFF, $user);

        if (!$isStaff && !$isOwner) {
            abort(404);
        }

        $survey = $mission->survey()->first();
        $sections = $survey->sections()->get();
        //$questions = $survey->questions()->get();

        $countParticipant = $survey->entries()->count();

        $data = [];

        foreach ($sections as $section) {
            $sectionQuestions = $section->questions;

            foreach($sectionQuestions as $question) {
                $type = $question->type;

                $answers = $question->answers()->get();
                $options = $question->options;

                $countAnswers = count($answers);
                $countOptions = [];
                $userAnswers = [];

                if ($type === 'radio') {
                    $countOptions = array_fill_keys($options, 0);

                    foreach ($answers as $answer) {
                        $countOptions[$answer->value] += 1;
                    }
                } else {
                    foreach ($answers as $answer) {
                        $userAnswer = [
                            'answer' => $answer->value
                        ];

                        if ($isStaff) {
                            $userAnswer['user'] = $answer->entry()->first()->participant()->first();
                        }

                        $userAnswers[] = $userAnswer;
                    }

                    shuffle($userAnswers);
                }

                $data[] = [
                    'title' => $question->title,
                    'type' => $type,
                    'options' => $options,
                    'countAnswers' => $countAnswers,
                    'countOptions' => $countOptions,
                    'userAnswer' => $userAnswers,
                ];
            }
        }

        // TODO 만약 섹션 없이 질문들로만 구성된 설문을 만든다면, 추가하기.


        return view('lounge.mission.report', [
            'id' => $mission->id,
            'type' => $mission->getTypeName(),
            'title' => '만족도 조사 결과',
            'isStaff' => $isStaff,
            'mission' => $mission,
            'countParticipant' => $countParticipant,
            'data' => $data
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
