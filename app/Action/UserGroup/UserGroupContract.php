<?php

namespace App\Action\UserGroup;

interface UserGroupContract
{
    public function put(int $groupId): bool;
    public function delete(int $groupId): bool;
    public function has(int $groupId): bool;
}
