<?php

namespace App\Action\UserData;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserData
{
    const STEAM_USER_BANS = 'steam_user_bans';
    const STEAM_USER_SUMMARIES = 'steam_user_summaries';
    const STEAM_USER_FRIENDS = 'steam_user_friends';
    const STEAM_GAME_OWNED = 'steam_game_owned';
    const STEAM_GAME_INFO_ARMA3 = 'steam_game_info_arma3';
    const STEAM_GROUP_SUMMARIES = 'steam_group_summaries';

    public function set(User $user, string $name, mixed $data)
    {
        if($user->data()->where('name', $name)->exists()) {
            $user->data()->where('name', $name)->update([
                'data' => json_encode($data)
            ]);

        } else {
            $now = now();
            $user->data()->insert([
                'user_id' => $user->id,
                'name' => $name,
                'data' => json_encode($data),
                'created_at' => $now,
                'updated_at' => $now
            ]);

        }
    }

    public function get(User $user, string $name): null|object
    {
        return $user->data()->where('name', $name)->first();
    }
}
