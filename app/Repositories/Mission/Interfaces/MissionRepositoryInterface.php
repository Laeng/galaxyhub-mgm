<?php

namespace App\Repositories\Mission\Interfaces;

use App\Models\Mission;
use App\Repositories\Base\Interfaces\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

interface MissionRepositoryInterface extends EloquentRepositoryInterface
{
    const PERIOD_OF_ATTENDANCE = 12;

    public function findBetweenDates(string $column, array $dates, array $columns = ['*'], array $relations = []): ?Collection;

    public function findByUserId(int $userId, array $columns = ['*'], array $relations = []): ?Collection;

    public function findByPhase(int $phase, array $columns = ['*'], array $relations = []): ?Collection;

    public function new(): Mission;
}
