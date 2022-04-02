<?php

namespace App\Repositories\Updater;

use App\Models\Updater;
use App\Repositories\Base\BaseRepository;
use App\Repositories\Updater\Interfaces\UpdaterRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use JetBrains\PhpStorm\Pure;

class UpdaterRepository extends BaseRepository implements UpdaterRepositoryInterface
{
    public Updater $model;

    #[Pure]
    public function __construct(Updater $model)
    {
        parent::__construct($model);

        $this->model = $model;
    }

    public function findByCode(string $code, array $columns = ['*'], array $relations = []): ?Updater
    {
        return $this->model->select($columns)->where('code', $code)->with($relations)->latest()->first();
    }

    public function findByCodeAndIp(string $code, string $ip, array $columns = ['*'], array $relations = []): ?Updater
    {
        return $this->model->select($columns)->where('code', $code)->where('ip', $ip)->with($relations)->latest()->first();
    }

    public function findByMachineNameAndCode(string $machineName, string $code, array $columns = ['*'], array $relations = []): ?Updater
    {
        return $this->model->select($columns)->where('machine_name', $machineName)->where('code', $code)->with($relations)->latest()->first();
    }

    public function findByIpMachineNameAndMachineVersion(string $ip, string $machineName, string $machineVersion, array $columns = ['*'], array $relations = []): ?Updater
    {
        return $this->model->select($columns)->where('ip', $ip)->where('machine_name', $machineName)->where('machine_version', $machineVersion)->with($relations)->latest()->first();
    }

    public function findByUserId(int $userId, array $columns = ['*'], array $relations = []): ?Collection
    {
        return $this->model->select($columns)->where('user_id', $userId)->with($relations)->latest()->get();
    }

    public function findLatestUpdatedByUserId(int $userId, array $columns = ['*'], array $relations = []): ?Collection
    {
        return $this->model->select($columns)->where('user_id', $userId)->with($relations)->latest('updated_at')->get();
    }

    public function findUnusedOverDay(array $columns = ['*'], array $relations = []): ?Collection
    {
        return $this->model->select($columns)->whereNull('user_id')->whereBetween('updated_at', [today()->subYear(), today()->subDay()])->with($relations)->latest('updated_at')->get();
    }

    public function findOver6MonthsByUserId(int $userId, array $columns = ['*'], array $relations = []): ?Collection
    {
        return $this->model->select($columns)->where('user_id', $userId)->where('updated_at', '>', today()->subMonths(6))->with($relations)->latest('updated_at')->get();
    }


}
