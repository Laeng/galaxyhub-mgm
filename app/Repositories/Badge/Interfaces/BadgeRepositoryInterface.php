<?php

namespace App\Repositories\Badge\Interfaces;

use App\Models\Badge;
use App\Repositories\Base\Interfaces\EloquentRepositoryInterface;

interface BadgeRepositoryInterface extends EloquentRepositoryInterface
{
    public function findByName(string $name, array $columns = ['*'], array $relations = []): ?Badge;
}
