<?php

namespace App\Listeners;

use App\Enums\UserRecordType;
use App\Repositories\User\UserAccountRepository;
use App\Services\User\Contracts\UserServiceContract;
use Cog\Laravel\Ban\Events\ModelWasBanned;

class RecordBannedUser
{
    private UserServiceContract $userService;

    public function __construct(UserServiceContract $userService)
    {
        $this->userService = $userService;
    }

    public function handle(ModelWasBanned $event)
    {
        $ban = $event->model;
        $data = [
            'comment' => $ban->comment,
            'expired_at' => $ban->expired_at,
        ];

        $this->userService->createRecord($ban->bannable_id, UserRecordType::BAN_DATA->name, $data, $ban->created_by_id);
    }
}
