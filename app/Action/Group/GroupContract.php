<?php

namespace App\Action\Group;

interface GroupContract
{
    public function add(int $groupId): bool;
    public function remove(int $groupId): bool;
    public function has(int $groupId): bool;
}
