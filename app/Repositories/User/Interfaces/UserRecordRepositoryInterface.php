<?php

namespace App\Repositories\User\Interfaces;

use App\Repositories\Base\Interfaces\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

interface UserRecordRepositoryInterface extends EloquentRepositoryInterface
{
    public function findByUserId(int $userId, array $columns = ['*'], array $relations = []): ?Collection;

    public function findByUuid(string $uuid, array $columns = ['*'], array $relations = []): ?Collection;

    public function findByUserIdAndType(int $userId, string $type, array $columns = ['*'], array $relations = []): ?Collection;

    public function findByUuidAndType(string $uuid, string $type, array $columns = ['*'], array $relations = []): ?Collection;

    public function getUuidV5(string $value): string;
}
