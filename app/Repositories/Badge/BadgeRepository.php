<?php

namespace App\Repositories\Badge;

use App\Models\Badge;
use App\Repositories\Badge\Interfaces\BadgeRepositoryInterface;
use App\Repositories\Base\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use JetBrains\PhpStorm\Pure;

class BadgeRepository extends BaseRepository implements BadgeRepositoryInterface
{
    public Badge $model;

    #[Pure]
    public function __construct(Badge $model)
    {
        parent::__construct($model);

        $this->model = $model;
    }

    public function findByName(string $name, array $columns = ['*'], array $relations = []): ?Badge
    {
        return $this->model->select($columns)->where('name', $name)->with($relations)->latest()->first();
    }
}
