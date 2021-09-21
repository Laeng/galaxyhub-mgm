<?php

namespace App\Action\Survey;

use Illuminate\Support\Collection;

interface SurveyResponseContract
{
    public function get(int $surveyId, int $userId): Collection;
    public function create(int $surveyId, int $userId, array $response): bool;
    public function update(int $surveyId, int $userId, array $response): bool;

}
