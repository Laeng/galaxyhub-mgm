<?php

namespace App\Services\Survey\Questions;

use App\Models\Survey as SurveyModel;

class QuizQuestion extends Question
{
    private array $bank;

    public function __construct(SurveyModel $survey)
    {
        parent::__construct($survey);
        $this->bank = $this->getQuizzes();
    }

    public function create(...$vars): SurveyModel
    {
        $one = $this->survey->sections()->create([
            'name' => '퀴즈',
            'description' =>
                "<p>본 퀴즈는 가입자분들이 더 재밌게 아르마를 즐기실 수 있도록 돕고자 제작되었습니다.<br/>".
                '모든 문제는 <a class="link-indigo" href="https://cafe.naver.com/gamemmakers/book5076085" target="_blank">아르마 길잡이</a>에서 출제되며 5문제 중 3문제 이상을 맞추어 주셔야 합니다.</p>'.
                '<p>제한 시간은 없으며, 맞은 갯수가 3개 미만일 경우 7일간 재 가입 신청을 하실 수 없사오니 주의해 주시기 바랍니다.</p>'.
                '<p class="text-red-600 text-base">* 필수 입력</p>'
        ]);

        foreach ($this->bank as $i => $q) {
            $number = $i + 1;

            $one->questions()->create([
                'title' => sprintf('%s. %s', $number, $q['title']),
                'content' => $q['content'],
                'type' => 'quiz',
                'options' => array_merge($q['options'], [$q['answer']]),
                'rules' => ['required']
            ]);
        }

        $two = $this->survey->sections()->create([
            'name' => '수고하셨습니다!',
            'description' => ''
        ]);

        return $this->survey;
    }

    private function getQuizzes(): array
    {
        $questions = $this->questionBank();
        shuffle($questions);

        return array_map(function ($i) use ($questions) { return $questions[$i]; }, array_rand($questions, 5));
    }

    private function questionBank(): array
    {
        $form = [
            [
                'title' => '',   // 문제 입력
                'content' => '', // 문제 지문 입력
                'options' => [   // 문제 보기 입력

                ],
                'answer' => '',  // 정답 입력
            ],
        ];
        return [
            [
                'title' => '클래스 다이어그램의 요소로 다음 설명에 해당하는 용어는? 1',
                'content' => '<ul><li>클래스의 동작을 의미한다.</li><li>UML에서는 동작에 대한 인터페이스를 지칭한다고 볼 수 있다.</li></ul>',
                'options' => [
                    'Instance', 'Operation', 'Item', 'Hiding'
                ],
                'answer' => 'Operation',
            ],
            [
                'title' => '객체지향의 주요 개념에 대한 설명으로 틀린 것은? 1',
                'content' => '',
                'options' => [
                    '캡슐화는 상위클래스에서 속성이나 연산을 전달받아 새로운 형태의 클래스로 확장하여 사용하는 것을 의미한다.',
                    '객체는 실세계에 존재하거나 생각할 수 있는 것을 말한다.',
                    '클래스는 하나 이상의 유사한 객체들을 묶어 공통된 특성을 표현한 것이다.',
                    '다형성은 상속받은 여러 개의 하위 객체들이 다른 형태의 특성을 갖는 객체로 이용될 수 있는 성질이다.'
                ],
                'answer' => '캡슐화는 상위클래스에서 속성이나 연산을 전달받아 새로운 형태의 클래스로 확장하여 사용하는 것을 의미한다.',
            ],
            [
                'title' => '클래스 다이어그램의 요소로 다음 설명에 해당하는 용어는? 2',
                'content' => '<ul><li>클래스의 동작을 의미한다.</li><li>UML에서는 동작에 대한 인터페이스를 지칭한다고 볼 수 있다.</li></ul>',
                'options' => [
                    'Instance', 'Operation', 'Item', 'Hiding'
                ],
                'answer' => 'Operation',
            ],
            [
                'title' => '객체지향의 주요 개념에 대한 설명으로 틀린 것은? 2',
                'content' => '',
                'options' => [
                    '캡슐화는 상위클래스에서 속성이나 연산을 전달받아 새로운 형태의 클래스로 확장하여 사용하는 것을 의미한다.',
                    '객체는 실세계에 존재하거나 생각할 수 있는 것을 말한다.',
                    '클래스는 하나 이상의 유사한 객체들을 묶어 공통된 특성을 표현한 것이다.',
                    '다형성은 상속받은 여러 개의 하위 객체들이 다른 형태의 특성을 갖는 객체로 이용될 수 있는 성질이다.'
                ],
                'answer' => '캡슐화는 상위클래스에서 속성이나 연산을 전달받아 새로운 형태의 클래스로 확장하여 사용하는 것을 의미한다.',
            ],
            [
                'title' => '클래스 다이어그램의 요소로 다음 설명에 해당하는 용어는? 3',
                'content' => '<ul><li>클래스의 동작을 의미한다.</li><li>UML에서는 동작에 대한 인터페이스를 지칭한다고 볼 수 있다.</li></ul>',
                'options' => [
                    'Instance', 'Operation', 'Item', 'Hiding'
                ],
                'answer' => 'Operation',
            ],
            [
                'title' => '객체지향의 주요 개념에 대한 설명으로 틀린 것은? 3',
                'content' => '',
                'options' => [
                    '캡슐화는 상위클래스에서 속성이나 연산을 전달받아 새로운 형태의 클래스로 확장하여 사용하는 것을 의미한다.',
                    '객체는 실세계에 존재하거나 생각할 수 있는 것을 말한다.',
                    '클래스는 하나 이상의 유사한 객체들을 묶어 공통된 특성을 표현한 것이다.',
                    '다형성은 상속받은 여러 개의 하위 객체들이 다른 형태의 특성을 갖는 객체로 이용될 수 있는 성질이다.'
                ],
                'answer' => '캡슐화는 상위클래스에서 속성이나 연산을 전달받아 새로운 형태의 클래스로 확장하여 사용하는 것을 의미한다.',
            ],

        ];
    }
}
