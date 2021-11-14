<?php

namespace App\Action\PlayerHistory;

use App\Models\User;
use \App\Models\PlayerHistory as PlayerHistoryModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PlayerHistory
{
    const TYPE_USER_MEMO = 'user_memo';
    const TYPE_USER_BANNED = 'user_banned';
    const TYPE_APPLICATION_REJECTED = 'application_rejected';
    const TYPE_APPLICATION_DEFERRED = 'application_DEFERRED';

    public function add(string $identifier, string $type, mixed $description, User|null $staff = null): PlayerHistoryModel
    {
        return PlayerHistoryModel::create([
            'identifier' => $identifier,
            'type' => $type,
            'description' => $description,
            'staff_id' => (!is_null($staff)) ? $staff->id : null
        ]);
    }

    public function getModel(string $identifier, string|null $type = null): mixed
    {
        $query = PlayerHistoryModel::where('identifier', $identifier);
        if (!is_null($type)) {
            $query = $query->where('type', $type);
        }

        return $query;
    }


}
