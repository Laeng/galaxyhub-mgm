<?php

namespace App\Repositories\User\Interfaces;

use App\Repositories\Base\Interfaces\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface UserBadgeRepositoryInterface extends EloquentRepositoryInterface
{

    public function findByUserId(int $userId, array $columns = ['*'], array $relations = []): ?Collection;

    public function findByBadgeId(int $badgeId, array $columns = ['*'], array $relations = []): ?Collection;

    public function findByBadgeName(int $badgeName, array $columns = ['*'], array $relations = []): ?Collection; //?????

    public function findByUserIdAndBadgeId(int $userId, int $badgeId, array $columns = ['*'], array $relations = []): ?Model;
}
