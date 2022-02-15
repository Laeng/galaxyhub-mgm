<?php

namespace App\Repositories\User\Interfaces;

use App\Repositories\Base\Interfaces\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

interface UserRepositoryInterface extends EloquentRepositoryInterface
{

    public function findByUsername(string $username, array $columns = ['*'], array $relations = []): ?Model;
}
