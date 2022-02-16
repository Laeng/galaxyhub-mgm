<?php

namespace App\Repositories\Mission;

use App\Models\Mission;
use App\Repositories\Base\BaseRepository;
use App\Repositories\Mission\Interfaces\MissionRepositoryInterface;
use JetBrains\PhpStorm\Pure;

class MissionRepository extends BaseRepository implements MissionRepositoryInterface
{
    #[Pure]
    public function __construct(Mission $model)
    {
        parent::__construct($model);
    }
}
