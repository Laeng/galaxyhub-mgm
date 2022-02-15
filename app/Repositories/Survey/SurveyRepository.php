<?php

namespace App\Repositories\Survey;

use App\Models\Survey;
use App\Repositories\Base\BaseRepository;
use App\Repositories\Survey\Interfaces\SurveyRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use JetBrains\PhpStorm\Pure;

class SurveyRepository extends BaseRepository implements SurveyRepositoryInterface
{
    public Survey $model;

    #[Pure]
    public function __construct(Survey $model)
    {
        parent::__construct($model);

        $this->model = $model;
    }

    public function findByName(string $name, array $columns = ['*'], array $relations = []): ?Collection
    {
        return $this->model->select($columns)->where('name', $name)->with($relations)->latest()->get();
    }

    public function findByNameWithIn7Days(string $name, array $columns = ['*'], array $relations = []): ?Collection
    {
        return $this->model->select($columns)->where('name', $name)->with($relations)->where('created_at', '>=', today()->subDays(7))->latest()->get();
    }
}
