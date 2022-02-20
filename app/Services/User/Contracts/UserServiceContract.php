<?php

namespace App\Services\User\Contracts;

use App\Models\User;
use App\Models\UserAccount;
use App\Models\UserRecord;
use Illuminate\Support\Collection;

/**
 * Interface AuthServiceContract
 * @package App\Services\Contracts
 */
interface UserServiceContract
{
    public function createUser(array $attributes): ?User;

    public function createRecord(int $userId, string $type, array $data, ?int $recorderId = null): ?UserRecord;

    public function findBanRecordByUuid(int $uuid): ?Collection;

    public function findRoleRecordeByUserId(int $userId, string $role): ?Collection;
}
