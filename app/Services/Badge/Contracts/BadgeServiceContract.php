<?php

namespace App\Services\Badge\Contracts;

interface BadgeServiceContract
{
    public function award(string $badgeName, int $userId): bool;

    public function take(string $badgeName, int $userId): bool;
}
