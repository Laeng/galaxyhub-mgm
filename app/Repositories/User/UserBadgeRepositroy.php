<?php

namespace App\Repositories\User;

use App\Models\UserBadge;
use App\Repositories\Base\BaseRepository;
use App\Repositories\User\Interfaces\UserBadgeRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use JetBrains\PhpStorm\Pure;

class UserBadgeRepositroy extends BaseRepository implements UserBadgeRepositoryInterface
{
    private UserBadge $model;

    #[Pure]
    public function __construct(UserBadge $model)
    {
        parent::__construct($model);

        $this->model = $model;
    }

    public function findByUserId(int $userId, array $columns = ['*'], array $relations = []): ?Collection
    {
        return $this->model->select($columns)->where('user_id', $userId)->with($relations)->latest()->get();
    }

    public function findByBadgeId(int $badgeId, array $columns = ['*'], array $relations = []): ?Collection
    {
        return $this->model->select($columns)->where('badge_id', $badgeId)->with($relations)->latest()->get();
    }

    public function findByBadgeName(int $badgeName, array $columns = ['*'], array $relations = []): ?Collection
    {
        return $this->model->select($columns)->whereHas('badges', function ($query) use ($badgeName) {
            $query->where('name', $badgeName);
        })->with(array_merge(['badge'], $relations))->latest()->get();
    }

    public function findByUserIdAndBadgeId(int $userId, int $badgeId, array $columns = ['*'], array $relations = []): ?Model
    {
        return $this->model->select($columns)->where('user_id', $userId)->where('badge_id', $badgeId)->with(array_merge(['badge'], $relations))->latest()->first();
    }
}
