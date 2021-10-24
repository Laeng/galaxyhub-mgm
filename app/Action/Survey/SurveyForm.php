<?php

namespace App\Action\Survey;

use App\Models\Survey as SurveyModel;
use Illuminate\Database\Eloquent\Builder;

class SurveyForm implements SurveyFormContract
{
    const JOIN_APPLICATION = 'join-application-2021-10-24';
    const MISSION_SURVEY = 'mission-survey';

    public function getJoinApplicationForm(): SurveyModel
    {
        $survey = SurveyModel::where('name', self::JOIN_APPLICATION)->latest()->first();

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
                'content' => '이중 클랜 적발시 영구 탈퇴 및 영구적인 애드온 차단 조치가 됨을 동의합니다.',
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
                'name' => '타 커뮤니티, 클랜 활동 내역',
                'description' => '명확히 작성 부탁 드리며, 거짓이 있을 때 경고 없이 카페 탈퇴가 됨을 알려 드립니다.',
                'rules' => ['required']
            ]);

            $two->questions()->create([
                'title' => '타 커뮤니티(클랜) 활동 여부',
                'content' => '이중클랜 적발시 영구 탈퇴및 영구적인 애드온 차단 조치가 됨을 동의합니다.',
                'type' => 'radio',
                'options' => ['활동 중이다', '타 클랜, 커뮤니티 활동이 있다', '없다'],
                'rules' => ['required']
            ]);

            $two->questions()->create([
                'title' => '타 커뮤니티명(클랜명)',
                'content' => '활동하셨던 커뮤니티의 이름(클랜명)을 모두 기재하여 주십시오.',
            ]);

            $two->questions()->create([
                'title' => '타 커뮤니티(클랜)내 닉네임',
                'content' => '활동 중이거나 활동 경험이 있는 카페 내의 닉네임을 기재하여 주십시오.',
            ]);

            $two->questions()->create([
                'title' => '(탈퇴 하였다면) 탈퇴 이유',
                'content' => '타 커뮤니티, 클랜을 탈퇴하셨다면 탈퇴 이유를 기재하여 주십시오. 탈퇴 이유를 피드백 받아 본 카페 운영에 참조하도록 하겠습니다',
            ]);

            $survey = SurveyModel::where('name', self::JOIN_APPLICATION)->latest()->first();
        }

        return $survey;
    }

    public function getMissionSurveyForm(): SurveyModel
    {
        $survey = SurveyModel::create([
            'name' => 'join-application',
            'user_id' => ''
        ]);

        $one = $survey->sections()->create([
            'name' => '미션 만족도 조사',
            'description' =>
                '<p>미션 만족도 조사의 결과는 더 재밌는 미션을 제작하실 수 있도록 해당 미션을 담당하신 미션 메이커 회원님께 익명으로 제공됩니다. 번거로우시더라도 참여해주시면 감사드립니다.</p>'.
                '<p>주관식 문항에서 욕설, 조롱, 비하 등이 담긴 답변으로 분쟁 발생시 중재 목적으로 MGM 아르마 클랜 스탭이 회원님의 설문 응답을 조회할 수 있는 점 참고 부탁드립니다.</p>'
        ]);

        return $survey;
    }
}
