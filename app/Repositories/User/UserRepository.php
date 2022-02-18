<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\Base\BaseRepository;
use App\Repositories\User\Interfaces\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
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

    public function findByRole(string $role, array $columns = ['*'], array $relations = []): ?Collection
    {
        return $this->model->role($role)->select($columns)->with($relations)->latest()->get();
    }

    public function findByRoleWithPagination(string $role, int $offset = 0, int $limit = 10, array $columns = ['*'], array $relations = []): ?Collection
    {
        return $this->model->role($role)->select($columns)->with($relations)->offset($offset)->limit($limit)->latest()->get();
    }
}
