<?php

namespace App\Repositories\User;

use App\Models\UserMission;
use App\Repositories\Base\BaseRepository;
use App\Repositories\User\Interfaces\UserMissionRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use JetBrains\PhpStorm\Pure;

class UserMissionRepository extends BaseRepository implements UserMissionRepositoryInterface
{
    private UserMission $model;

    #[Pure]
    public function __construct(UserMission $model)
    {
        parent::__construct($model);

        $this->model = $model;
    }

    public function findByUserId(int $userId, array $columns = ['*'], array $relations = []): ?Collection
    {
        return $this->model->select($columns)->where('user_id', $userId)->with($relations)->latest()->get();
    }

    public function findByMissionId(int $missionId, array $columns = ['*'], array $relations = []): ?Collection
    {
        return $this->model->select($columns)->where('mission_id', $missionId)->with($relations)->latest()->get();
    }

    public function findByUserIdAndMissionId(int $userId, int $missionId, array $columns = ['*'], array $relations = []): ?UserMission
    {
        return $this->model->select($columns)->where('user_id', $userId)->where('mission_id', $missionId)->with($relations)->first();
    }

    public function findAttendedMissionByUserId(int $userId, array $columns = ['*'], array $relations = []): ?Collection
    {
        return $this->model->select($columns)->where('user_id', $userId)->whereNotNull('attended_at')->with($relations)->latest()->get();
    }

    public function new(): UserMission
    {
        return new UserMission();
    }
}
