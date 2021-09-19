<?php

namespace App\Action\UserGroup;

use App\Models\User;
use Auth;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserGroup implements UserGroupContract
{
    const BANNED = 10;
    const INACTIVE = 11;

    const ARMA_APPLY = 20;
    const ARMA_MEMBER = 30;
    const ARMA_MAKER1 = 31;
    const ARMA_MAKER2 = 32;

    const STAFF = 90;

    public function put(int $groupId): bool
    {
        if (!$this->has($groupId)) {
            $user = $this->getUser();
            $group = $this->getUserGroups();
            $group->create(['user_id' => $user->id, 'group_id' => $groupId]);

            return true;
        }

        return false;
    }

    public function delete(int $groupId): bool
    {
        if (!$this->has($groupId)) {
            $group = $this->getUserGroups();
            $group->where('group_id', $groupId)->delete();

            return true;
        }

        return false;
    }

    public function has(int|array $groupId): bool
    {
        $group = $this->getUserGroups();

        if (is_array($groupId)) {
            return $group->whereIn('group_id', $groupId)->exists();
        }

        return $group->where('group_id', $groupId)->exists();
    }

    private function getUser(): User
    {
        return Auth::user();
    }

    private function getUserGroups(): ?HasMany
    {
        $user = $this->getUser();
        return (!is_null($user)) ? $user->groups() : null;
    }
}
