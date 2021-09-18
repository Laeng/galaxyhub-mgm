<?php

namespace App\Action\Group;

use App\Models\UserGroup;
use Auth;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group
{


    const ARMA_MEMBER = 20;
    const ARMA_MAKER1 = 25;
    const ARMA_MAKER2 = 26;

    const STAFF = 90;

    public function hasPermission(int $requireGroup): bool
    {
        $groups = $this->getUserGroups();

        if (is_null($groups)) {
           return false;
        }

        return $groups->where('group_id', $requireGroup)->count() > 0;
    }


    public function put(int $groupId): bool
    {
        $group = $this->getUserGroups();


    }

    public function delete(int $groupId): bool
    {

    }

    private function getUserGroups(): ?HasMany
    {
        $user = Auth::user();
        return (!is_null($user)) ? $user->groups() : null;
    }
}
