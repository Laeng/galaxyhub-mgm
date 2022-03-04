<?php

namespace App\Repositories\Updater\Interfaces;

use App\Models\Updater;
use App\Repositories\Base\Interfaces\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

interface UpdaterRepositoryInterface extends EloquentRepositoryInterface
{
    public function findByCode(string $code, array $columns = ['*'], array $relations = []): ?Updater;

    public function findByCodeAndIp(string $code, string $ip, array $columns = ['*'], array $relations = []): ?Updater;

    public function findByIpMachineNameAndMachineVersion(string $ip, string $machineName, string $machineVersion, array $columns = ['*'], array $relations = []): ?Updater;

    public function findByUserId(int $userId, array $columns = ['*'], array $relations = []): ?Collection;

    public function findByUserIdMachineNameAndCode(int $userId, string $machineName, string $code, array $columns = ['*'], array $relations = []): ?Updater;
}
