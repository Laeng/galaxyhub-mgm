<?php

namespace App\Action\UserData;

use App\Models\User;

class UserData
{
    const STEAM_USER_BANS = 'steam_user_bans';
    const STEAM_USER_SUMMARIES = 'steam_user_summaries';

    public function set(User $user, string $name, mixed $data) : bool
    {
        return $user->data()->updateOrInsert([
            'user_id',
            'name',
            'data'
        ], [
            $user->id,
            $name,
            $data
        ]);
    }

    public function get(User $user, string $name): null|object
    {
        return $user->data()->where('name', $name)->first();
    }
}
