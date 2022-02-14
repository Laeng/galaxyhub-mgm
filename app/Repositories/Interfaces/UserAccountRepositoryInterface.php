<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface UserAccountRepositoryInterface
{
    public function findByAccountId(string $accountId, array $columns = ['*'], array $relations = []): ?Model;
}
