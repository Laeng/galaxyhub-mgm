<?php

namespace App\Repositories\Mission;

use App\Models\Mission;
use App\Repositories\Base\BaseRepository;
use App\Repositories\Mission\Interfaces\MissionRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use JetBrains\PhpStorm\Pure;

class MissionRepository extends BaseRepository implements MissionRepositoryInterface
{
    private Mission $model;

    #[Pure]
    public function __construct(Mission $model)
    {
        parent::__construct($model);

        $this->model = $model;
    }

    public function findBetweenDates(string $column, array $dates, array $columns = ['*'], array $relations = []): ?Collection
    {
        return $this->model->select($columns)->whereBetween($column, $dates)->with($relations)->latest()->get();
    }

    public function findByUserId(int $userId, array $columns = ['*'], array $relations = []): ?Collection
    {
        return $this->model->select($columns)->where('user_id', $userId)->with($relations)->latest()->get();
    }

    public function findByPhase(int $phase, array $columns = ['*'], array $relations = []): ?Collection
    {
        return $this->model->select($columns)->where('phase', $phase)->with($relations)->latest()->get();
    }

    public function new(): Mission
    {
        return new Mission();
    }
}
