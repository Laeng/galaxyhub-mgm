<?php

namespace App\Services\Survey\Contracts;

use App\Models\Mission;
use App\Models\Survey;
use App\Models\SurveyEntry;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface SurveyServiceContract
 * @package App\Services\Contracts
 */
interface SurveyServiceContract
{
    public function createApplicationForm(int $surveyId = null): Survey;

    public function createApplicationQuiz(int $userId, string $userName, int $surveyId = null): Survey;

    public function createMissionSurvey(int $userId, int $missionId): Survey;

    public function getLatestApplicationForm(int $userId): ?SurveyEntry;

    public function getLatestApplicationQuiz(int $userId): ?SurveyEntry;

    public function getApplicationQuiz(int $userId): ?Collection;

    public function getApplicationQuizWithIn7Days(int $userId): ?Collection;
}
