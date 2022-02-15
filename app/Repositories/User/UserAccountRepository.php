<?php

namespace App\Repositories\User;

use App\Models\UserAccount;
use App\Repositories\Base\BaseRepository;
use App\Repositories\User\Interfaces\UserAccountRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
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

    public function findByAccountId(string $provider, string $accountId, array $columns = ['*'], array $relations = []): ?UserAccount
    {
        return $this->model->select($columns)->where('provider', $provider)->where('account_id', $accountId)->with($relations)->latest()->first();
    }

    public function findByUserId(string $userId, array $columns = ['*'], array $relations = []): ?Collection
    {
        return $this->model->select($columns)->where('user_id', $userId)->with($relations)->latest()->get();
    }
}
