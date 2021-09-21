<?php

namespace App\Action\Survey;

use Illuminate\Support\Collection;

class Survey implements SurveyContract
{

    public function get(int $surveyId, int $userId): Collection
    {
        // TODO: Implement get() method.
    }

    public function create(int $surveyId, int $userId, array $questions): bool
    {

    }

    public function update(int $surveyId, int $userId, array $questions): bool
    {
        // TODO: Implement update() method.
    }
}
