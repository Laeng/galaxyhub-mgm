<?php

namespace App\Services\Survey\Contracts;

use App\Models\Mission;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Interface SurveyServiceContract
 * @package App\Services\Contracts
 */
interface SurveyServiceContract
{
    public function createApplicationForm(int $surveyId = null): Model;

    public function createApplicationQuiz(User $user, int $surveyId = null): Model;

    public function createMissionSurvey(Mission $mission): Model;

    public function getLatestApplicationQuiz(User $user): ?Collection;
}
