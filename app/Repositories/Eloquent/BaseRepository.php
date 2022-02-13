<?php

namespace App\Repositories\Eloquent;

use App\Repositories\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements EloquentRepositoryInterface
{
    private Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function findById(int $id, array $columns = ['*'], array $relations = []): Model
    {
        return $this->model->find($id, $columns);
    }

    public function all(array $columns = ['*'], array $relations = []): Collection
    {
        return $this->model->with($relations)->get($columns);
    }

    public function create(array $attributes): Model
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
