<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use JetBrains\PhpStorm\Pure;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public User $model;

    #[Pure]
    public function __construct(User $model)
    {
        parent::__construct($model);

        $this->model = $model;
    }

    public function findByUsername(string $username, array $columns = ['*'], array $relations = []): ?User
    {
        return $this->model->select($columns)->where('username', $username)->with($relations)->latest()->first();
    }
}
