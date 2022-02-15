<?php

namespace App\Services\Survey\Contracts;

use App\Models\Mission;
use App\Models\Survey;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface SurveyServiceContract
 * @package App\Services\Contracts
 */
interface SurveyServiceContract
{
    public function createApplicationForm(int $surveyId = null): Survey;

    public function createApplicationQuiz(User $user, int $surveyId = null): Survey;

    public function createMissionSurvey(Mission $mission): Survey;

    public function getLatestApplicationQuiz(User $user): ?Collection;
}
