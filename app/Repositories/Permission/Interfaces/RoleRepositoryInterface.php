<?php

namespace App\Repositories\Permission\Interfaces;

use App\Repositories\Base\Interfaces\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

interface RoleRepositoryInterface extends EloquentRepositoryInterface
{
    public function findByUserId(string $userId, array $columns = ['*'], array $relations = []): ?Model;

    public function getNames(): array;
}
