<?php

namespace App\Repositories\Survey\Interfaces;

use App\Models\SurveyEntry;
use App\Repositories\Base\Interfaces\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

interface SurveyEntryRepositoryInterface extends EloquentRepositoryInterface
{
    public function findByUserIdAndSurveyId(int $userId, int $surveyId, array $columns = ['*'], array $relations = []): ?Collection;

    public function new(): SurveyEntry;
}
