<?php

namespace App\Repositories\User;

use App\Models\UserRecord;
use App\Repositories\Base\BaseRepository;
use App\Repositories\User\Interfaces\UserRecordRepositoryInterface;
use JetBrains\PhpStorm\Pure;
use Ramsey\Uuid\Uuid;

class UserRecordRepository extends BaseRepository implements UserRecordRepositoryInterface
{
    #[Pure]
    public function __construct(UserRecord $model)
    {
        parent::__construct($model);
    }

    public function getUUIDv5(string $value): string
    {
        return Uuid::uuid5('96b40e30-fdb1-4c78-8146-2d71ad157499', $value)->toString();
    }
}
