<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface EloquentRepositoryInterface
{
    public function findById(int $id, array $columns = ['*'], array $relations = []): ?Model;

    public function all(array $columns = ['*'], array $relations = []): Collection;

    public function create(array $attributes): ?Model;

    public function update(int $id, array $attributes): bool;

    public function delete(int $id): bool;

    public function paginate(int $perPages);
}
