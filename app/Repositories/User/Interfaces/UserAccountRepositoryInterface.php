<?php

namespace App\Repositories\User\Interfaces;

use App\Models\UserAccount;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface UserAccountRepositoryInterface
{
    public function findByAccountId(string $provider, string $accountId, array $columns = ['*'], array $relations = []): ?Collection;

    public function findByUserId(string $userId, array $columns = ['*'], array $relations = []): ?Collection;

    public function findByNickname(string $nickname, array $columns = ['*'], array $relations = []): ?Collection;

    public function findSteamAccountByUserId(string $userId, array $columns = ['*'], array $relations = []): ?Collection;

    public function findNaverAccountByUserId(string $userId, array $columns = ['*'], array $relations = []): ?Collection;
}
