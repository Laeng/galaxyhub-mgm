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

    public function getRecord(int $userId, string $type, bool $useSteamAccount = false): Collection;

    public function createRecord(int $userId, string $type, array $data, ?int $recorderId = null): ?UserRecord;

    public function editRecord(int $userId, string $type, array $data): ?bool;

    public function delete(int $userId): bool;

    public function ban(int $userId, ?string $reason = null, ?int $days = null, ?int $executeId = null, ?bool $overwrite = false): bool;

    public function unban(int $userId, string $reason = null, $executeId = null): bool;

    public function findBanRecordByUuid(int $uuid): ?Collection;

    public function findRoleRecordeByUserId(int $userId, string $role, bool $useSteamAccount = false): ?Collection;

    public function updateSteamAccount(int $userId): bool;
}
