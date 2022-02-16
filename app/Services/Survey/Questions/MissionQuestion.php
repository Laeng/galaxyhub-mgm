<?php

namespace App\Services\Survey\Questions;

use App\Models\Survey as SurveyModel;

class MissionQuestion extends Question
{
    public function create(...$vars): SurveyModel
    {
        $one = $this->survey->sections()->create([
            'name' => '만족도 조사',
            'description' =>
                "<p>본 미션은 {$vars[1]}님께서 제작하셨으며 설문 결과는 {$vars[1]}님께 익명으로 제공됩니다.".
                '분쟁 중재, 고충 처리를 위하여 MGM 아르마 클랜 스탭이 회원님의 응답을 조회할 수 있는 점 양해 부탁드립니다.</p>'.
                '<p>출석체크는 본 만족도 조사가 끝나면 하실 수 있습니다.</p>'.
                '<p class="text-red-600 text-base">* 필수 입력</p>'
        ]);

        $one->questions()->create([
            'title' => '적군의 수는 적절 하였나요?',
            'content' => '',
            'type' => 'radio',
            'options' => ['매우 만족', '만족', '보통', '불만족', '매우 불만족'],
            'rules' => ['required']
        ]);

        $one->questions()->create([
            'title' => '같이 플레이한 유저들과 협동이 잘 되었다고 생각하시나요? ',
            'content' => '',
            'type' => 'radio',
            'options' => ['매우 만족', '만족', '보통', '불만족', '매우 불만족'],
            'rules' => ['required']
        ]);

        $one->questions()->create([
            'title' => '작전 진행이 원활하였다고 생각하시나요?',
            'content' => '',
            'type' => 'radio',
            'options' => ['매우 만족', '만족', '보통', '불만족', '매우 불만족'],
            'rules' => ['required']
        ]);

        $one->questions()->create([
            'title' => '진행시간은 적절하였나요?',
            'content' => '',
            'type' => 'radio',
            'options' => ['매우 만족', '만족', '보통', '불만족', '매우 불만족'],
            'rules' => ['required']
        ]);

        $one->questions()->create([
            'title' => '분대장과 분대원간 소통은 원할했나요?',
            'content' => '',
            'type' => 'radio',
            'options' => ['매우 만족', '만족', '보통', '불만족', '매우 불만족'],
            'rules' => ['required']
        ]);

        $one->questions()->create([
            'title' => '착용한 장비와 미션의 난이도가 적절하였나요?',
            'content' => '',
            'type' => 'radio',
            'options' => ['매우 만족', '만족', '보통', '불만족', '매우 불만족'],
            'rules' => ['required']
        ]);

        $one->questions()->create([
            'title' => '추가로 말씀하시고 싶은 것이 있나요?',
            'content' => '회원님의 피드백은 더 재밌는 미션을 만드는데 큰 도움이 됩니다.',
            'type' => 'long-text',
            'rules' => []
        ]);

        $two = $this->survey->sections()->create([
            'name' => '수고하셨습니다!',
            'description' => '<p>모든 설문이 끝났습니다. 이제 아래 \'출석하기\'버튼을 눌러 출석체크를 하실 수 있습니다.</p>'
        ]);

        return $this->survey;
    }
}
