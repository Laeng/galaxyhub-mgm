<?php

namespace App\Action\Survey;

use App\Action\Survey\Questions\ApplicationQuestion;
use App\Action\Survey\Questions\QuizQuestion;
use App\Models\Mission;
use App\Models\Survey as SurveyModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class SurveyForm implements SurveyFormContract
{
    const JOIN_APPLICATION = 'application-2022-01-23';

    /**
     * @param int|null $id 과거 가입 심사 폼에 대한 survey_id 입력.
     * @return SurveyModel
     */
    public function getJoinApplication(int $id = null): SurveyModel
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

            $question = new ApplicationQuestion($builder);
            $builder = $question->create();

            $survey = SurveyModel::where('name', self::JOIN_APPLICATION)->latest()->first();
        }

        return $survey;
    }

    public function getMissionSurvey(Mission $mission): SurveyModel
    {
        $user = $mission->user()->first();

        $builder = SurveyModel::create([
            'name' => "mission-survey-{$mission->id}",
            'user_id' => $user->id
        ]);

        $question = new ApplicationQuestion($builder);

        return $question->create($user->nickname);
    }

    public function getQuiz(User $user, int $id = null): SurveyModel
    {
        $name = $this->getQuizName($user);
        $query = SurveyModel::where('name', $name);

        if (is_null($id)) {
            $builder = $query->latest()->first();
        } else {
            $builder = $query->where('id', $id)->first() ?? $query->latest()->first();
        }

        if (is_null($builder) || $builder->created_at->diffInDays(now()) > 0) {
            $builder = SurveyModel::create([
                'name' => $name,
                'user_id' => $user->id
            ]);

            $question = new QuizQuestion($builder);
            $builder = $question->create($user->nickname);
        }

        return $builder;
    }

    public function getQuizName(User $user): string
    {
        return "quiz-{$user->id}";
    }
}
