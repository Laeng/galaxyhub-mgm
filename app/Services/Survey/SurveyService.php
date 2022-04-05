<?php

namespace App\Services\Survey;

use App\Models\Mission;
use App\Models\Survey;
use App\Models\SurveyEntry;
use App\Models\User;
use App\Repositories\Survey\Interfaces\SurveyEntryRepositoryInterface;
use App\Repositories\Survey\Interfaces\SurveyRepositoryInterface;
use App\Services\Survey\Contracts\SurveyServiceContract;
use App\Services\Survey\Questions\ApplicationQuestion;
use App\Services\Survey\Questions\MissionQuestion;
use App\Services\Survey\Questions\QuizQuestion;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class SurveyService
 * @package App\Services
 */
class SurveyService implements SurveyServiceContract
{
    const APPLICATION_FORM_NAME = 'application-2022-04-05-1';

    public SurveyRepositoryInterface $surveyRepository;
    public SurveyEntryRepositoryInterface $surveyEntryRepository;

    public function __construct(SurveyRepositoryInterface $surveyRepository, SurveyEntryRepositoryInterface $surveyEntryRepository)
    {
        $this->surveyRepository = $surveyRepository;
        $this->surveyEntryRepository = $surveyEntryRepository;
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

    public function createApplicationQuiz(int $userId, string $userName, int $surveyId = null): Survey
    {
        $name = $this->getApplicationQuizName($userId);

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
                'user_id' => $userId
            ]);

            $questions = new QuizQuestion($quizModel);
            $quizModel = $questions->create($userName);
        }

        return $quizModel;
    }

    public function createMissionSurvey(int $userId, int $missionId): Survey
    {
        $missionSurveyModel = $this->surveyRepository->create([
            'name' => "mission-survey-{$missionId}",
            'user_id' => $userId
        ]);

        $questions = new MissionQuestion($missionSurveyModel);

        return $questions->create();
    }

    public function getLatestApplicationForm(int $userId): ?SurveyEntry
    {
        $ids = $this->surveyRepository->findApplicationForms(['id'])->pluck('id')->values()->toArray();
        $surveys = $this->surveyEntryRepository->findByUserIdAndSurveyId($userId, $ids);

        return $surveys->first();
    }

    public function getLatestApplicationQuiz(int $userId): ?SurveyEntry
    {
        $name = $this->getApplicationQuizName($userId);
        $survey = $this->surveyRepository->findByName($name)->first();

        if (is_null($survey))
        {
            return null;
        }

        return $this->surveyEntryRepository->findByUserIdAndSurveyId($userId, $survey->id)->first();
    }

    public function getApplicationQuiz(int $userId): ?Collection
    {
        $name = $this->getApplicationQuizName($userId);

        return $this->surveyRepository->findByName($name);
    }

    public function getApplicationQuizWithIn7Days(int $userId): ?Collection
    {
        $name = $this->getApplicationQuizName($userId);

        return $this->surveyRepository->findByNameWithIn7Days($name);
    }

    private function getApplicationQuizName(int $userId): string
    {
        return "quiz-{$userId}";
    }
}
