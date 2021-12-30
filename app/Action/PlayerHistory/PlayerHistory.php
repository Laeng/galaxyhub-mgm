<?php

namespace App\Action\PlayerHistory;

use App\Models\User;
use \App\Models\PlayerHistory as PlayerHistoryModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PlayerHistory
{
    const TYPE_USER_MEMO = 'user_memo';
    const TYPE_USER_JOIN = 'user_join';
    const TYPE_USER_APPLY = 'user_apply';
    const TYPE_USER_LEAVE = 'user_leave';
    const TYPE_USER_BANNED = 'user_banned';
    const TYPE_USER_UNBANNED = 'user_unbanned';
    const TYPE_USER_CHANGED_GROUP = 'user_changed_group';
    const TYPE_APPLICATION_REJECTED = 'application_rejected';
    const TYPE_APPLICATION_DEFERRED = 'application_deferred';
    const TYPE_STEAM_DISPLAY_NAME_CHANGED = 'steam_display_name_changed';

    public array $names = [
        'user_memo' => '메모',
        'user_join' => '가입 승인',
        'user_apply' => '가입 신청',
        'user_leave' => '탈퇴',
        'user_banned' => '활동 정지',
        'user_unbanned' => '활동 정지 해제',
        'user_changed_group' => '등급 변경',
        'application_rejected' => '가입 거절',
        'application_deferred' => '가입 보류',
        'steam_display_name_changed' => '닉네임 변경'
    ];

    public function getName(string $type): ?string
    {
        if (array_key_exists($type, $this->names)) {
            return $this->names[$type];
        } else {
            return null;
        }
    }

    public function add(string $identifier, string $type, mixed $description, User|null $staff = null): PlayerHistoryModel
    {
        return PlayerHistoryModel::create([
            'identifier' => $identifier,
            'type' => $type,
            'description' => $description,
            'staff_id' => (!is_null($staff)) ? $staff->id : null
        ]);
    }

    public function getModel(string $identifier, string|null $type = null): Builder
    {
        $query = PlayerHistoryModel::where('identifier', $identifier);
        if (!is_null($type)) {
            $query = $query->where('type', $type);
        }

        return $query;
    }

    public function getIdentifierFromUser(User|int $user): string
    {
        if (is_int($user)) $user = User::find($user);

        return $user->socials()->where('social_provider', 'steam')->latest()->first()->social_id;
    }


}
