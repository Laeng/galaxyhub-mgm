<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface UserRepositoryInterface extends EloquentRepositoryInterface
{

    public function findByUsername(string $username, array $columns = ['*'], array $relations = []): ?Model;
}
