<?php

namespace App\Services\Survey;

use App\Models\Mission;
use App\Models\Survey;
use App\Models\User;
use App\Repositories\Survey\Interfaces\SurveyEntryRepositoryInterface;
use App\Repositories\Survey\Interfaces\SurveyRepositoryInterface;
use App\Services\Survey\Contracts\SurveyServiceContract;
use App\Services\Survey\Questions\ApplicationQuestion;
use App\Services\Survey\Questions\QuizQuestion;
use Illuminate\Database\Eloquent\Collection;use Illuminate\Database\Eloquent\Model;

/**
 * Class SurveyService
 * @package App\Services
 */
class SurveyService implements SurveyServiceContract
{
    const APPLICATION_FORM_NAME = 'application-2022-02-19-1';

    public SurveyRepositoryInterface $surveyRepository;
    public SurveyEntryRepositoryInterface $surveyEntryRepository;

    public function __construct(SurveyRepositoryInterface $surveyRepository)
    {
        $this->surveyRepository = $surveyRepository;
    }

    public function createApplicationForm(int $surveyId = null): Survey
    {
        $formModel = null;

        if (!is_null($surveyId))
        {
            $formModel = $this->surveyRepository->findById($surveyId);
        }

        if (is_null($formModel))
        {
            $formModel = $this->surveyRepository->findByName(self::APPLICATION_FORM_NAME)?->first();
        }

        if (is_null($formModel))
        {
            $formModel = $this->surveyRepository->create([
                'name' => self::APPLICATION_FORM_NAME
            ]);

            $questions = new ApplicationQuestion($formModel);
            $formModel = $questions->create();
        }

        return $formModel;
    }

    public function createApplicationQuiz(User $user, int $surveyId = null): Survey
    {
        $name = $this->getApplicationQuizName($user);

        if (is_null($surveyId))
        {
            $quizzes = $this->surveyRepository->findByName($name);
            $quizModel = $quizzes->filter(fn ($v, $k) => $v->created_at->isToday())->first();
        }
        else
        {
            $quizModel = $this->surveyRepository->findById($surveyId);
            $quizModel = $quizModel->created_at->isToday() ? $quizModel : null;
        }

        if (is_null($quizModel))
        {
            $quizModel = $this->surveyRepository->create([
                'name' => $name,
                'user_id' => $user->id
            ]);

            $questions = new QuizQuestion($quizModel);
            $quizModel = $questions->create($user->name);
        }

        return $quizModel;
    }

    public function createMissionSurvey(Mission $mission): Survey
    {
        // TODO: Implement createMissionSurvey() method.
    }

    public function getLatestApplicationQuiz(User $user): ?Collection
    {
        $name = $this->getApplicationQuizName($user);

        return $this->surveyRepository->findByNameWithIn7Days($name);
    }

    private function getApplicationQuizName(User $user): string
    {
        return "quiz-{$user->id}";
    }
}
