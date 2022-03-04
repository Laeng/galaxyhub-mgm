<?php

namespace App\Repositories\User\Interfaces;

use App\Models\User;
use App\Repositories\Base\Interfaces\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface UserRepositoryInterface extends EloquentRepositoryInterface
{
    public function findByIds(array $ids, array $columns = ['*'], array $relations = []): Collection;

    public function findByIdsWithRole(array $ids, string $role, array $columns = ['*'], array $relations = []): ?Collection;

    public function findByUsername(string $username, array $columns = ['*'], array $relations = []): ?User;

    public function findByRole(string $role, array $columns = ['*'], array $relations = []): ?Collection;

    public function countByRole(string $role, array $columns = ['*'], array $relations = []): int;

    public function findByRoleWithPagination(string $role, int $offset = 0, int $limit = 10, array $columns = ['*'], array $relations = []): ?Collection;

    public function pagination(int $offset = 0, int $limit = 10, array $columns = ['*'], array $relations = []): ?Collection;

    public function new(): User;
}
