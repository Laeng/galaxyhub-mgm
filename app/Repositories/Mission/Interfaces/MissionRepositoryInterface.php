<?php

namespace App\Repositories\Mission\Interfaces;

use App\Models\Mission;
use App\Repositories\Base\Interfaces\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

interface MissionRepositoryInterface extends EloquentRepositoryInterface
{
    public function findByUserId(int $userId, array $columns = ['*'], array $relations = []): ?Collection;

    public function findByConditions(array $conditions, array $order = ['created_at', 'desc'], array $columns = ['*'], array $relations = []): ?Collection;

    public function new(): Mission;
}
