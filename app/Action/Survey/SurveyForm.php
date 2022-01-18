<?php

namespace App\Action\Survey;

use App\Models\Mission;
use App\Models\Survey as SurveyModel;
use Illuminate\Database\Eloquent\Builder;

class SurveyForm implements SurveyFormContract
{
    const JOIN_APPLICATION = 'join-application-2021-10-25';
    const MISSION_SURVEY = 'mission-survey';

    /**
     * @param int|null $id 과거 가입 심사 폼에 대한 survey_id 입력.
     * @return SurveyModel
     */
    public function getJoinApplicationForm(int $id = null): SurveyModel
    {
        $query = SurveyModel::where('name', self::JOIN_APPLICATION);

        if (is_null($id)) {
            $survey = $query->latest()->first();
        } else {
            $survey = $query->where('id', $id)->first() ?? $query->latest()->first();
        }

        if (is_null($survey)) {
            $builder = SurveyModel::create([
                'name' => self::JOIN_APPLICATION
            ]);

            $one = $builder->sections()->create([
                'name' => '가입 시 주의사항',
                'description' =>
                    '<p>MGM 라운지 가입 및 MGM 아르마 클랜 가입을 진심으로 환영합니다.</p>'.
                    '<p>저희 MGM 클랜은 오직 본 클랜의 아르마 유저들이 다른 어느 곳에서도 느낄 수 없는 전장 체험과 색다른 게이밍 경험을 할 수 있도록 MGM 스탭, 미션 메이커, 테크 매니저들이 소통하고 협업하며 MGM 아르마 애드온을 제작 및 제공하고 있습니다. '.
                    '회원님들께 제공되는 MGM 아르마 애드온에는 MGM 아르마 클랜 또는 개인이 제작한 비공개 애드온도 포함되어 있으며 운영진 및 애드온 개발자의 동의 없이 재배포 또는 유출 시 법적으로 대응할 수 있음을 알려드립니다!</p>'.
                    '<p>본 클랜은 \'이중 클랜 가입 금지 조항\'이 있으며 이를 반드시 준수하셔야 합니다. 이와 관련된 자세한 규정은 <a class="underline text-blue-500" href="https://bit.ly/3hjb6wa">여기</a>를 참고해주시기 바랍니다.</p>'.
                    '<p>이중 클랜 가입 금지 조항은 수차례의 애드온 유출 및 무단 전용 사례가 발생하여 이중 클랜 가입 금지는 앞으로도 변함 없을 것입니다. '.
                    '만약 이중 클랜 가입이 확인될 시 클랜에서 영구 추방 및 애드온 영구 차단 조치가 이루어지니, 위 사항을 반드시 숙지하시고 가입이후 불이익을 받지 않도록 해주시기 바랍니다.</p>'.
                    '<p class="text-red-600 text-base">* 필수 입력</p>'
            ]);

            $one->questions()->create([
                'title' => '무단 배포에 대한 제재 동의',
                'content' => '위 사항을 확인했으며 무단 배포 및 사용 시 법적 책임을 짐을 동의합니다.',
                'type' => 'radio',
                'options' => ['동의함'],
                'rules' => ['required']
            ]);

            $one->questions()->create([
                'title' => '이중 클랜 활동에 대한 제재 동의',
                'content' => '이중 클랜 적발 시 탈퇴 처리와 함께 재가입 불가 및 애드온 차단 조치가 됨을 동의합니다.',
                'type' => 'radio',
                'options' => ['동의함'],
                'rules' => ['required']
            ]);

            $one->questions()->create([
                'title' => '네이버 아이디',
                'content' => '멀티플레이 게임 매니지먼트 네이버 카페에 가입한 네이버 아이디를 입력하여 주십시오.',
                'rules' => ['required']
            ]);

            $one->questions()->create([
                'title' => '본인의 생년월일',
                'content' => '과거 가입 여부를 확인을 위해 사용됩니다. 기타 용도로 사용되지 않습니다.(예)1991-01-01',
                'rules' => ['required']
            ]);

            $two = $builder->sections()->create([
                'name' => '아르마 커뮤니티(클랜) 활동',
                'description' => '명확히 작성 부탁드리며, 거짓이 있을 때 경고 없이 탈퇴 처리함을 알려드립니다.',
                'rules' => ['required']
            ]);

            $two->questions()->create([
                'title' => '아르마 커뮤니티(클랜) 활동 여부',
                'content' => '이중 클랜 활동이 확인되면 규정에 따라 강제 탈퇴 및 애드온 사용 금지 조치를 하고 있습니다.',
                'type' => 'radio',
                'options' => ['활동 중이다.', '지금은 아니다.', '없다.'],
                'rules' => ['required']
            ]);

            $two->questions()->create([
                'title' => '타 커뮤니티 이름',
                'content' => '활동하셨거나 활동 중인 아르마 관련 커뮤니티(클랜, 카페, 디스코드) 이름을 모두 기재하여 주십시오.',
            ]);

            $two->questions()->create([
                'title' => '타 커뮤니티내 닉네임',
                'content' => '아르마 관련 커뮤니티(클랜, 카페, 디스코드)에서 활동 중이거나 활동 시 사용하셨던 닉네임을 기재하여 주십시오.',
            ]);

            $two->questions()->create([
                'title' => '(탈퇴 하였다면) 탈퇴 이유',
                'content' => '해당 커뮤니티(클랜, 카페, 디스코드)를 탈퇴하셨다면 탈퇴 이유를 기재하여 주십시오. 탈퇴 이유를 피드백 받아 본 카페 운영에 참조하도록 하겠습니다.',
            ]);

            $two->questions()->create([
                'title' => '탈퇴를 증명할 수 있는 자료',
                'type' => 'image',
                'content' => '해당 커뮤니티(클랜, 카페, 디스코드)를 탈퇴했음을 증명할 수 있는 스크린샷을 업로드하여 주십시오.',
            ]);

            $survey = SurveyModel::where('name', self::JOIN_APPLICATION)->latest()->first();
        }

        return $survey;
    }

    public function getMissionSurveyForm(Mission $mission): SurveyModel
    {
        $user = $mission->user()->first();

        $survey = SurveyModel::create([
            'name' => "mission-survey-{$mission->id}",
            'user_id' => $user->id
        ]);

        $one = $survey->sections()->create([
            'name' => '만족도 조사',
            'description' =>
                "<p>본 미션은 {$user->nickname}님께서 제작하셨으며 설문 결과는 {$user->nickname}님께 익명으로 제공됩니다.".
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

        $two = $survey->sections()->create([
            'name' => '수고하셨습니다!',
            'description' => '<p>모든 설문이 끝났습니다. 이제 아래 \'출석하기\'버튼을 눌러 출석체크를 하실 수 있습니다.</p>'
        ]);

        return $survey;
    }
}
