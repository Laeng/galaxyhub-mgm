<?php

namespace App\Repositories\Survey\Interfaces;

use App\Repositories\Base\Interfaces\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

interface SurveyRepositoryInterface extends EloquentRepositoryInterface
{
    public function findByName(string $name, array $columns = ['*'], array $relations = []): ?Collection;

    public function findByNameWithIn7Days(string $name, array $columns = ['*'], array $relations = []): ?Collection;
}
