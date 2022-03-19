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

    public function findByAccountId(string $provider, string $accountId, array $columns = ['*'], array $relations = []): ?Collection
    {
        return $this->model->select($columns)->where('provider', $provider)->where('account_id', $accountId)->with($relations)->latest()->get();
    }

    public function findByUserId(string $userId, array $columns = ['*'], array $relations = []): ?Collection
    {
        return $this->model->select($columns)->where('user_id', $userId)->with($relations)->latest()->get();
    }

    public function findByNickname(string $nickname, array $columns = ['*'], array $relations = []): ?Collection
    {
        return $this->model->select($columns)->where('nickname', $nickname)->with($relations)->latest()->get();
    }

    public function findSteamAccountByUserId(string $userId, array $columns = ['*'], array $relations = []): ?Collection
    {
        return $this->model->select($columns)->where('user_id', $userId)->where('provider', 'steam')->with($relations)->latest()->get();
    }

    public function findNaverAccountByUserId(string $userId, array $columns = ['*'], array $relations = []): ?Collection
    {
        return $this->model->select($columns)->where('user_id', $userId)->where('provider', 'naver')->with($relations)->latest()->get();
    }

}
