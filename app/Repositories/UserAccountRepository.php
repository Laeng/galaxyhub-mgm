<?php

namespace App\Repositories;

use App\Models\UserAccount;
use App\Repositories\Interfaces\UserAccountRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use JetBrains\PhpStorm\Pure;

class UserAccountRepository extends BaseRepository implements UserAccountRepositoryInterface
{
    private UserAccount $model;

    #[Pure]
    public function __construct(UserAccount $model)
    {
        $this->model = $model;

        parent::__construct($model);
    }

    public function findByAccountId(string $accountId, array $columns = ['*'], array $relations = []): ?UserAccount
    {
        return $this->model->select($columns)->where('account_id', $accountId)->with($relations)->latest()->first();
    }
}
