<?php

namespace App\Repositories\User\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface UserAccountRepositoryInterface
{
    public function findByAccountId(string $provider, string $accountId, array $columns = ['*'], array $relations = []): ?Model;

    public function findByUserId(string $userId, array $columns = ['*'], array $relations = []): ?Collection;
}
