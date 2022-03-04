<?php

namespace App\Repositories\Base;

use App\Repositories\Base\Interfaces\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements EloquentRepositoryInterface
{
    private Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;

    }

    public function findById(int $id, array $columns = ['*'], array $relations = []): ?Model
    {
        return $this->model->select($columns)->where('id', $id)->with($relations)->latest()->first();
    }

    public function all(array $columns = ['*'], array $relations = []): Collection
    {
        return $this->model->select($columns)->with($relations)->get();
    }

    public function count(array $columns = ['*'], array $relations = []): int
    {
        return $this->model->select($columns)->with($relations)->count();
    }

    public function create(array $attributes): ?Model
    {
        return $this->model->create($attributes);
    }

    public function update(int $id, array $attributes): bool
    {
        return $this->findById($id)->update($attributes);
    }

    public function delete(int $id): bool
    {
        return $this->findById($id)->delete();
    }

    public function paginate(int $perPages)
    {
        return $this->model->paginate($perPages);
    }
}
