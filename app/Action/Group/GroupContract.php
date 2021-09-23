<?php

namespace App\Action\Group;

interface GroupContract
{
    public function create(int $groupId): bool;
    public function delete(int $groupId): bool;
    public function has(int $groupId): bool;
}
