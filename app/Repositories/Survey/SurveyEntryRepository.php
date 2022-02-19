<?php

namespace App\Repositories\Survey;

use App\Models\SurveyEntry;
use App\Repositories\Base\BaseRepository;
use App\Repositories\Survey\Interfaces\SurveyEntryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use JetBrains\PhpStorm\Pure;

class SurveyEntryRepository extends BaseRepository implements SurveyEntryRepositoryInterface
{
    private SurveyEntry $model;

    #[Pure]
    public function __construct(SurveyEntry $model)
    {
        $this->model = $model;

        parent::__construct($model);
    }

    public function findByUserIdAndSurveyId(int $userId, int|array $surveyId, array $columns = ['*'], array $relations = []): ?Collection
    {
        $query =  $this->model->select($columns)->where('participant_id', $userId);

        if (is_int($surveyId))
        {
            $query = $query->where('survey_id', $surveyId);
        }
        else {
            $query = $query->whereIn('survey_id', $surveyId);
        }

        return $query->with($relations)->latest()->get();
    }

    public function new(): SurveyEntry
    {
        return new SurveyEntry();
    }
}
