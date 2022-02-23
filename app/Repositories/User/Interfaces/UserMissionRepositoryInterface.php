<?php

namespace App\Repositories\User\Interfaces;

use App\Models\UserMission;
use App\Repositories\Base\Interfaces\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

interface UserMissionRepositoryInterface extends EloquentRepositoryInterface
{
    const MAX_ATTENDANCE_ATTEMPTS = 5;

    public function findByUserId(int $userId, array $columns = ['*'], array $relations = []): ?Collection;

    public function findByMissionId(int $missionId, array $columns = ['*'], array $relations = []): ?Collection;

    public function findByUserIdAndMissionId(int $userId, int $missionId, array $columns = ['*'], array $relations = []): ?UserMission;

    public function findAttendedMissionByUserId(int $userId, array $columns = ['*'], array $relations = []): ?Collection;
}
