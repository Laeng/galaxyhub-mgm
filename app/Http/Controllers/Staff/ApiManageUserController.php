<?php

namespace App\Http\Controllers\Staff;

use App\Action\Group\Group;
use App\Action\Survey\SurveyForm;
use App\Http\Controllers\Controller;
use App\Models\Survey;
use App\Models\UserGroup;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiManageUserController extends Controller
{
    public function getApplicantList(Request $request, SurveyForm $surveyForm): JsonResponse
    {
        $offset = $request->get('offset',  0);
        $limit = $request->get('limit', 20);

        $surveyForms = Survey::where('name', 'like', 'join-application-%')->get(['id'])->pluck('id')->toArray();

        $applicantQuery = UserGroup::where('group_id', Group::ARMA_APPLY);
        $applicantCount = $applicantQuery->count();
        $applicants = $applicantQuery->offset($offset * $limit)->limit($limit)->get();

        $items = [];


        foreach ($applicants as $i){
            $user = $i->user()->first();

            $survey = $user->surveys()->whereIn('survey_id', $surveyForms)->latest()->first();
            $answers = $survey->answers()->latest()->get();

            $values = [
                "<a class='text-indigo-600 hover:text-indigo-900' href='https://steamcommunity.com/profiles/{$user->socials()->where('social_provider', 'steam')->latest()->first()->social_id}' target='_blank'>{$user->nickname}</a>",
                '', '', '', '',
                '<a class="text-indigo-600 hover:text-indigo-900" href="'. route('staff.user.applicant.detail', $user->id) .'" target="_blank">확인하기</a>'
            ];

            foreach ($answers as $it) {
                $question = $it->question()->first();
                $v = $it->value;

                if (is_null($question)) continue;

                switch ($question->title) {
                    case '네이버 아이디':
                        $values[1] = "<a class='text-indigo-600 hover:text-indigo-900' href='https://cafe.naver.com/ca-fe/cafes/17091584/members?memberId={$v}' target='_blank'>{$v}</a>";
                        break;

                    case '본인의 생년월일': $values[2] = $v; break;

                    case '타 커뮤니티(클랜) 활동 여부': //TODO 테스트 이후 지우기
                    case '아르마 커뮤니티(클랜) 활동 여부': $values[3] = $v; break;
                }
            }

            $values[4] = $survey->created_at->toDateString();
            $items[] = $values;
        }

        return $this->jsonResponse(200, 'OK', [
            'fields' => ['스팀 닉네임', '네이버 아이디', '생년월일', '타 클랜 활동', '신청일' , '상세 정보'],
            'items' => $items,
            'count' => [
                'offset' => $offset,
                'limit' => $limit,
                'total' => $applicantCount
            ]
        ]);
    }
}
