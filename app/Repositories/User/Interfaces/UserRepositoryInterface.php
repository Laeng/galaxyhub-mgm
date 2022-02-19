<?php

namespace App\Repositories\User\Interfaces;

use App\Repositories\Base\Interfaces\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface UserRepositoryInterface extends EloquentRepositoryInterface
{
    public function findByIdsWithRole(array $ids, string $role, array $columns = ['*'], array $relations = []): ?Collection;

    public function findByUsername(string $username, array $columns = ['*'], array $relations = []): ?Model;

    public function findByRole(string $role, array $columns = ['*'], array $relations = []): ?Collection;

    public function findByRoleWithPagination(string $role, int $offset = 0, int $limit = 10, array $columns = ['*'], array $relations = []): ?Collection;
}
