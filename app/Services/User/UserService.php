<?php

namespace App\Services\User;

use App\Enums\UserRecordType;
use App\Models\User as UserModel;
use App\Models\UserAccount;
use App\Models\UserRecord;
use App\Repositories\User\Interfaces\UserAccountRepositoryInterface;
use App\Repositories\User\Interfaces\UserRecordRepositoryInterface;
use App\Repositories\User\Interfaces\UserRepositoryInterface;
use App\Services\User\Contracts\UserServiceContract;
use Illuminate\Support\Collection;
use function now;

/**
 * Class AuthService
 * @package App\Services
 */
class UserService implements UserServiceContract
{
    private UserRepositoryInterface $userRepository;
    private UserAccountRepositoryInterface $accountRepository;
    private UserRecordRepositoryInterface $recordRepository;

    public function __construct(UserRepositoryInterface $user, UserAccountRepositoryInterface $account, UserRecordRepositoryInterface $record)
    {
        $this->userRepository = $user;
        $this->accountRepository = $account;
        $this->recordRepository = $record;
    }

    public function createUser(array $attributes): ?UserModel
    {
        if($attributes['provider'] !== 'default')
        {
            //OAuth 로그인 절차
            $account = $this->accountRepository->findByAccountId($attributes['provider'], $attributes['id']);

            $userAttributes = [
                'name' => $attributes['nickname'],
                'avatar' => $attributes['avatar'],
                'provider' => $attributes['provider'],
                'visited_at' => now()
            ];

            if(!is_null($account))
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

                $account = $this->accountRepository->create($accountAttributes);
            }

            //$bans = $this->findBanRecordByUuid($this->recordRepository->getUuidV5($account->account_id))->filter(function ($v, $k) {
                //return $v->data['expired_at']
            //});


            return $user;
        }
        else
        {
            //일반 로그인 절차
            return new UserModel();
        }
    }

    public function createRecord(int $userId, string $type, array $data, ?int $recorderId = null): ?UserRecord
    {
        $steamAccount = $this->accountRepository->findSteamAccountByUserId($userId);

        if (is_null($steamAccount)) return null;

        $uuid = $this->recordRepository->getUuidV5($userId);

        return $this->recordRepository->create([
            'user_id' => $userId,
            'recorder_id' => $recorderId,
            'type' => $type,
            'data' => $data,
            'uuid' => $uuid
        ]);
    }

    public function findBanRecordByUuid(int $uuid): ?Collection
    {
        return $this->recordRepository->findByUuidAndType($uuid, UserRecordType::BAN_DATA->name);
    }

    public function findRoleRecordeByUserId(int $userId, string $role): ?Collection
    {
        return $this->recordRepository->findByUserIdAndType($userId, UserRecordType::ROLE_DATA->name)?->filter(
            fn ($v, $k) => $v->data['role'] === $role
        );
    }

}