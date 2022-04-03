<?php

namespace App\Services\User;

use App\Enums\BanCommentType;
use App\Enums\UserRecordType;
use App\Models\User as UserModel;
use App\Models\UserAccount;
use App\Models\UserRecord;
use App\Repositories\Ban\Interfaces\BanRepositoryInterface;
use App\Repositories\User\Interfaces\UserAccountRepositoryInterface;
use App\Repositories\User\Interfaces\UserRecordRepositoryInterface;
use App\Repositories\User\Interfaces\UserRepositoryInterface;
use App\Services\Steam\Contracts\SteamServiceContract;
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
    private UserAccountRepositoryInterface $userAccountRepository;
    private UserRecordRepositoryInterface $recordRepository;
    private BanRepositoryInterface $banRepository;
    private SteamServiceContract $steamService;

    public function __construct
    (
        UserRepositoryInterface $userRepository, UserAccountRepositoryInterface $userAccountRepository,
        UserRecordRepositoryInterface $recordRepository, BanRepositoryInterface $banRepository,
        SteamServiceContract $steamService)
    {
        $this->userRepository = $userRepository;
        $this->userAccountRepository = $userAccountRepository;
        $this->recordRepository = $recordRepository;
        $this->banRepository = $banRepository;
        $this->steamService = $steamService;
    }

    public function createUser(array $attributes): ?UserModel
    {
        if($attributes['provider'] !== 'default')
        {
            //OAuth 로그인 절차
            $account = $this->userAccountRepository->findByAccountId($attributes['provider'], $attributes['id'])->first();

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
                    if ($account->nickname !== $attributes['nickname'])
                    {
                        $accountAttributes = array_merge($attributes, [
                            'user_id' => $user->id,
                            'account_id' => $attributes['id']
                        ]);

                        // 닉네임 검색을 위하여 닉네임이 변경되면 새로 등록한다.
                        $this->userAccountRepository->create($accountAttributes);
                        $this->createRecord($user->id, UserRecordType::STEAM_DATA_CHANGE_NICKNAME->name, [
                            'comment' => "{$user->name} → {$attributes['nickname']}"
                        ]);
                    }
                    else
                    {
                        $account->update($attributes);
                    }
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

                $account = $this->userAccountRepository->create($accountAttributes);
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

    public function getRecord(int $userId, string $type): Collection
    {
        return $this->recordRepository->findByUserIdAndType($userId, $type);
    }

    public function createRecord(int $userId, string $type, array $data, ?int $recorderId = null): ?UserRecord
    {
        $steamAccount = $this->userAccountRepository->findSteamAccountByUserId($userId)->first();
        $uuid = $this->recordRepository->getUuidV5($steamAccount->account_id);

        return $this->recordRepository->create([
            'user_id' => $userId,
            'recorder_id' => $recorderId,
            'type' => $type,
            'data' => $data,
            'uuid' => $uuid
        ]);
    }

    public function editRecord(int $userId, string $type, array $data, ?int $recorderId = null): ?bool
    {
        $query = $this->getRecord($userId, $type);

        if ($query->count() > 0)
        {
            $record = $query->first();
            $record->data = $data;

            $record->save();

            return true;
        }
        else
        {
            return false;
        }
    }

    public function ban(int $userId, ?string $reason = null, ?int $days = null, ?int $executeId = null): bool
    {
        $user = $this->userRepository->findById($userId);

        if (!is_null($user))
        {
            $data = [
                'comment' => $reason,
            ];

            if ($days != null) {
                $data['expired_at'] = now()->addDays($days);
            }

            $user->ban($data);
            $this->createRecord($user->id, UserRecordType::BAN_DATA->name, $data, $executeId);

            return true;
        }

        return false;
    }

    public function unban(int $userId, string $reason = null, $executeId = null): bool
    {
        $user = $this->userRepository->findById($userId);

        if (!is_null($user))
        {
            $ban = $this->banRepository->findByUserId($user->id)->first();
            $type = !is_null($ban) && $ban->comment === BanCommentType::USER_PAUSE->value ? UserRecordType::USER_PAUSE_DISABLE : UserRecordType::UNBAN_DATA;

            $user->unban();
            $this->createRecord($user->id, $type->name, [
                'comment' => $reason
            ], $executeId);

            return true;
        }

        return false;
    }

    public function delete(int $userId): bool
    {
        $user = $this->userRepository->findById($userId);

        if (!is_null($user))
        {
            $roles = $user->getRoleNames();

            foreach ($roles as $role)
            {
                $user->removeRole($role);
            }

            $user->accounts()->where('user_id', $user->id)->delete();
            $user->bans()->where('bannable_id', $user->id)->delete();
            $user->surveys()->where('participant_id', $user->id)->delete();
            $user->delete();

            return true;
        }

        return false;
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

    public function updateSteamAccount(int $userId): bool
    {
        $user = $this->userRepository->findById($userId);

        if (is_null($user)) {
            return false;
        }

        $steamAccount = $this->userAccountRepository->findSteamAccountByUserId($user->id)->first();

        if (is_null($steamAccount))
        {
            return false;
        }

        $accountId = $steamAccount->account_id;
        $playerSummaries = $this->steamService->getPlayerSummaries($accountId);

        if ($playerSummaries['response']['players'][0]['communityvisibilitystate'] == 3)
        {
            $steamOwnedGames = $this->steamService->getOwnedGames($steamAccount->account_id);

            if (count($steamOwnedGames['response']) > 0)
            {
                $playerGroups = $this->steamService->getPlayerGroups($playerSummaries['response']['players'][0]['steamid'])['response']['groups'];
                $groups = array();

                if (count($playerGroups) > 0)
                {
                    foreach($playerGroups as $id)
                    {
                        $data = $this->steamService->getGroupSummary($id['gid']);
                        $groups[] = array_merge($data['groupDetails'], ['groupID64' => $data['groupID64']]);
                    }
                }

                $data = [
                    UserRecordType::STEAM_DATA_SUMMARIES->name => $playerSummaries['response']['players'][0],
                    UserRecordType::STEAM_DATA_GAMES->name => $steamOwnedGames['response'],
                    UserRecordType::STEAM_DATA_ARMA3->name => $this->steamService->getOwnedGames($accountId, true, true, [107410])['response']['games']['0'],
                    UserRecordType::STEAM_DATA_BANS->name => $this->steamService->getPlayerBans($accountId)['players']['0'],
                    UserRecordType::STEAM_DATA_GROUPS->name => $groups
                ];

                $userId = $user->id;

                foreach ($data as $k => $v)
                {
                    if (!$this->editRecord($userId, $k, $v))
                    {
                        $this->createRecord($userId, $k, $v);
                    }
                }

                return true;
            }
        }

        return false;
    }

}
