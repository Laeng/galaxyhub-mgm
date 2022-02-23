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

    public function findByConditions(array $conditions, array $order = ['created_at', 'desc'], array $columns = ['*'], array $relations = []): ?Collection
    {
        $query = $this->model->select($columns);

        foreach ($conditions as $condition)
        {
            $query = $query->where($condition[0], $condition[1], $condition[2]);
        }

        return $query->with($relations)->orderBy($order[0], $order[1])->get();
    }

    public function new(): Mission
    {
        return new Mission();
    }
}
