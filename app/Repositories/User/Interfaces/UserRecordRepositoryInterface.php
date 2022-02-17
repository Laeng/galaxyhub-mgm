<?php

namespace App\Repositories\User\Interfaces;

use App\Repositories\Base\Interfaces\EloquentRepositoryInterface;

interface UserRecordRepositoryInterface extends EloquentRepositoryInterface
{
    public function getUUIDv5(string $value): string;
}
