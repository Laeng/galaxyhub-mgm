<?php

namespace App\Repositories\Ban;

use App\Repositories\Ban\Interfaces\BanRepositoryInterface;
use App\Repositories\Base\BaseRepository;
use Cog\Laravel\Ban\Models\Ban;
use Illuminate\Database\Eloquent\Collection;
use JetBrains\PhpStorm\Pure;

class BanRepository extends BaseRepository implements BanRepositoryInterface
{
    public Ban $model;

    #[Pure]
    public function __construct(Ban $model)
    {
        parent::__construct($model);

        $this->model = $model;
    }

    public function findByUserId(int $userId, array $columns = ['*'], array $relations = []): ?Collection
    {
        return $this->model->select($columns)->where('bannable_id', $userId)->with($relations)->latest()->get();
    }

}
