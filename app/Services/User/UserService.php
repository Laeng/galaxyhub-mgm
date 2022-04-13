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
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Support\Carbon;
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

                if ($isDifferent)
                {
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
                $this->userAccountRepository->create($accountAttributes);

                $isBanned = false;

                $roles = $this->getRecord($user->id, UserRecordType::ROLE_DATA->name, true);

                if ($roles->count() > 0)
                {
                    $role = $roles->first();
                    $reason = array_key_exists('comment', $role->data) && $role->data['comment'] !== '' ? $role->data['comment'] : '가입 거절';

                    switch ($roles->count())
                    {
                        case 1:
                            $expired_at = $role->updated_at->addDays(30);
                            break;

                        case 2:
                            $expired_at = $role->updated_at->addDays(90);
                            break;

                        default:
                            $expired_at = null;
                            $this->ban($user->id, $reason);
                            break;
                    }

                    if (!is_null($expired_at) && !$expired_at->isPast())
                    {
                        $this->ban($user->id, $reason, today()->diffInDays($expired_at));
                    }
                }

                $bans = $this->getRecord($user->id, UserRecordType::BAN_DATA->name, true);
                $unbans = $this->getRecord($user->id, UserRecordType::UNBAN_DATA->name, true);

                if ($bans->count() > $unbans->count())
                {
                    $ban = $bans->first();

                    if (!array_key_exists('expired_at', $ban->data))
                    {
                        $this->ban($user->id, array_key_exists('comment', $ban->data) ? $ban->data['comment'] : '', null, null, true);
                    }
                    else
                    {
                        $expired_at = Carbon::parse($ban->data['expired_at']);

                        if (!$expired_at->isPast())
                        {
                            $this->ban($user->id, array_key_exists('comment', $ban->data) ? $ban->data['comment'] : '', today()->diffInDays($expired_at), null, true);
                        }
                    }
                }
            }

            return $user;
        }
        else
        {
            //일반 로그인 절차
            return new UserModel();
        }
    }

    public function getRecord(int $userId, string $type, bool $useSteamAccount = false): Collection
    {
        if ($useSteamAccount)
        {
            $steamAccount = $this->userAccountRepository->findSteamAccountByUserId($userId)->first();

            if (!is_null($steamAccount))
            {
                $uuid = $this->recordRepository->getUuidV5($steamAccount->account_id);

                return $this->recordRepository->findByUuidAndType($uuid, $type);
            }

            return new Collection();
        }
        else
        {
            return $this->recordRepository->findByUserIdAndType($userId, $type);
        }
    }

    public function createRecord(int $userId, string $type, array $data, ?int $recorderId = null): ?UserRecord
    {
        $steamAccount = $this->userAccountRepository->findSteamAccountByUserId($userId)->first();

        if (!is_null($steamAccount))
        {
            $uuid = $this->recordRepository->getUuidV5($steamAccount->account_id);

            return $this->recordRepository->create([
                'user_id' => $userId,
                'recorder_id' => $recorderId,
                'type' => $type,
                'data' => $data,
                'uuid' => $uuid
            ]);
        }

        return null;
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

    public function ban(int $userId, ?string $reason = null, ?int $days = null, ?int $executeId = null, ?bool $overwrite = false): bool
    {
        $user = $this->userRepository->findById($userId);

        if (!is_null($user))
        {
            if (is_null($user->banned_at) || $overwrite)
            {
                $data = [
                    'comment' => $reason,
                ];

                if ($days != null) {
                    $data['expired_at'] = now()->addDays($days);
                }

                $user->ban($data);
                $this->createRecord($user->id, UserRecordType::BAN_DATA->name, $data, $executeId);
            }

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

    public function findRoleRecordeByUserId(int $userId, string $role, bool $useSteamAccount = false): ?Collection
    {
        if ($useSteamAccount)
        {
            $steamAccount = $this->userAccountRepository->findSteamAccountByUserId($userId)->first();

            if (!is_null($steamAccount))
            {
                $uuid = $this->recordRepository->getUuidV5($steamAccount->account_id);

                return $this->recordRepository->findByUuidAndType($uuid, UserRecordType::ROLE_DATA->name)?->filter(
                fn ($v, $k) => $v->data['role'] === $role
            );
            }
        }
        else
        {
            return $this->recordRepository->findByUserIdAndType($userId, UserRecordType::ROLE_DATA->name)?->filter(
                fn ($v, $k) => $v->data['role'] === $role
            );
        }

        return new Collection();
    }

    public function updateSteamAccount(int $userId): bool
    {
        $user = $this->userRepository->findById($userId);

        if (is_null($user)) {
            return false;
        }

        try
        {
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
                            $groups[] = array_merge(array_key_exists('groupDetails', $data) ? $data['groupDetails'] : [], array_key_exists('groupID64', $data) ? ['groupID64' => $data['groupID64']] : []);
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
        }
        catch (ClientException $e)
        {
            return false;
        }

        return false;
    }

}
