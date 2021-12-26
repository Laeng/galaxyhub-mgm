<?php

namespace App\Action\Group;

use App\Exceptions\InstanceNotFoundException;
use App\Models\User;
use App\Models\UserGroup;
use Auth;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\RelationNotFoundException;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group implements GroupContract
{
    const ARMA_APPLY = 20;
    const ARMA_DEFER = 21;
    const ARMA_REJECT = 22;

    const ARMA_MEMBER = 30;

    const ARMA_MAKER1 = 50;
    const ARMA_MAKER2 = 51;

    const ARMA_SENIOR = 70;

    const STAFF = 90;

    public array $names = [
        20 => '가입 신청',
        21 => '가입 보류',
        22 => '가입 거절',
        30 => '멤버',
        50 => '예비 메이커',
        51 => '정식 메이커',
        90 => '관리자'
    ];

    public function getName(int $group_id): ?string
    {
        if (array_key_exists($group_id, $this->names)) {
            return $this->names[$group_id];
        } else {
            return null;
        }
    }

    public function add(int $groupId, User|int|null $user = null, string|null $reason = null, User|int|null $by = null): bool
    {
        $user = $this->validateUser($user);
        $by = $this->validateUser($by);

        if ($this->has($groupId, $user)) return false;

        $group = $user->groups()->create(['user_id' => $user->id, 'group_id' => $groupId]);
        $group->reason()->create(['user_id' => $user->id, 'user_group_id' => $group->id, 'reason' => $reason, 'staff_id' => !is_null($by) ? $by->id : null]);

        return true;
    }

    public function delete(int $groupId, User|int|null $user = null, string|null $reason = null, User|int|null $by = null): bool
    {
        $user = $this->validateUser($user);
        $by = $this->validateUser($by, true);

        if (!$this->has($groupId, $user)) return false;

        $q = $user->groups()->where('group_id', $groupId);
        $group = $q->first();
        $group->reason()->create(['user_id' => $user->id, 'user_group_id' => $group->id, 'reason' => $reason, 'staff_id' => !is_null($by) ? $by->id : null]);
        $q->delete();

        return true;
    }

    public function has(int|array $groupId, User|int|null $user = null): bool
    {
        $user = $this->validateUser($user);

        if (is_array($groupId)) {
            return $user->groups()->whereIn('group_id', $groupId)->exists();
        } else {
            return $user->groups()->where('group_id', $groupId)->exists();
        }
    }

    public function getUserGroups(User|int|null $user = null): Collection
    {
        $user = $this->validateUser($user);
        return UserGroup::where('user_id', $user->id)->get();
    }

    public function getSpecificGroupUsers(int $groupId, $offset = 0, $limit = 200, $latest = false): Collection
    {
        $q = UserGroup::where('group_id', $groupId);

        if ($latest) $q->latest();

        return $q->offset($offset)->limit($limit)->get();
    }

    public function countSpecificGroupUsers(int $groupId, $offset = 0, $limit = 200): int
    {
        return UserGroup::where('group_id', $groupId)->count();
    }

    private function validateUser(User|int|null $user): ?User
    {
        $instance = $user;

        if (is_null($user)) $instance = auth()->user();
        if (is_int($user)) $instance = User::find($user);

        if (is_null($instance)) {
            return null;
        }

        return $instance;
    }
}
