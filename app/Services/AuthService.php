<?php

namespace App\Services;

use App\Models\User as UserModel;
use App\Repositories\Interfaces\UserAccountRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\Contracts\AuthServiceContract;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AuthService
 * @package App\Services
 */
class AuthService implements AuthServiceContract
{
    private UserRepositoryInterface $userRepository;
    private UserAccountRepositoryInterface $accountRepository;

    public function __construct(UserRepositoryInterface $user, UserAccountRepositoryInterface $account)
    {
        $this->userRepository = $user;
        $this->accountRepository = $account;
    }

    public function create(array $attributes): ?UserModel
    {
        if($attributes['provider'] !== 'default')
        {
            //OAuth 로그인 절차
            $account = $this->accountRepository->findByAccountId($attributes['id']);

            $userAttributes = [
                'name' => $attributes['nickname'],
                'avatar' => $attributes['avatar'],
                'provider' => $attributes['provider'],
                'visited_at' => now()
            ];

            if(!is_null($account) && $account->provider === $attributes['provider'])
            {
                $user = $this->userRepository->findById($account->user_id);
                $diff = array_diff($account->toArray(), $attributes);
                $isDifferent = count($diff) > 0;

                if ($isDifferent){
                    $account->update($attributes);
                }
                else
                {
                    $userAttributes = [];
                }

                if(!$user->visited_at->isToday()) {
                    $userAttributes['visit'] = $user->visit + 1;
                }

                $user->update($userAttributes);
            }
            else
            {
                $username = "{$attributes['provider']}_{$attributes['id']}";

                $userAttributes = array_merge($userAttributes, [
                    'username' => $username,
                    'password' => bcrypt(\Str::random(32)),
                    'visited_at' => now()
                ]);

                $user = $this->userRepository->findByUsername($username) ?? $this->userRepository->create($userAttributes);

                $accountAttributes = array_merge($attributes, [
                    'user_id' => $user->id,
                    'account_id' => $attributes['id']
                ]);

                unset($accountAttributes['id']);

                $this->accountRepository->create($accountAttributes);
            }

            return $user;
        }
        else
        {
            //일반 로그인 절차
            return null;
        }
    }

    public function update(int $id, array $attributes): bool
    {
        return false;
    }

    public function delete(int $id): bool
    {

        return false;
    }
}
