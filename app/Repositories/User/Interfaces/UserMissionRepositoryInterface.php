<?php

namespace App\Repositories\User\Interfaces;

use App\Repositories\Base\Interfaces\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

interface UserMissionRepositoryInterface extends EloquentRepositoryInterface
{
    const MAX_ATTENDANCE_ATTEMPTS = 5;

    public function findByUserId(int $userId, array $columns = ['*'], array $relations = []): ?Collection;

    public function findAttendedMissionByUserId(int $userId, array $columns = ['*'], array $relations = []): ?Collection;
}
