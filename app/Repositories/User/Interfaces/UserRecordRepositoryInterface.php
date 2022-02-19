<?php

namespace App\Repositories\User\Interfaces;

use App\Repositories\Base\Interfaces\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

interface UserRecordRepositoryInterface extends EloquentRepositoryInterface
{
    public function findByUuid(string $uuid, array $columns = ['*'], array $relations = []): ?Collection;

    public function getUUIDv5(string $value): string;
}
