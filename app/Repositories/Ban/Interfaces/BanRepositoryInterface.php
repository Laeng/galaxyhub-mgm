<?php

namespace App\Repositories\Ban\Interfaces;

use App\Repositories\Base\Interfaces\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

interface BanRepositoryInterface extends EloquentRepositoryInterface
{
    public function findByUserId(int $userId, array $columns = ['*'], array $relations = []): ?Collection;
}
