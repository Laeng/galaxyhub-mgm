<?php

namespace App\Console\Commands;

use App\Enums\BanCommentType;
use App\Enums\RoleType;
use App\Enums\UserRecordType;
use App\Repositories\Updater\Interfaces\UpdaterRepositoryInterface;
use App\Repositories\User\Interfaces\UserRepositoryInterface;
use App\Services\User\Contracts\UserServiceContract;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class PauseInactiveUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:pause-auto';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(UserRepositoryInterface $userRepository, UserServiceContract $userService): int
    {
        /*
        $query = $userRepository->new()->newQuery()->leftJoin('user_missions', function ($join) {
            $join->on('user_missions.id', '=', DB::raw("(SELECT max(user_missions.id) FROM user_missions WHERE user_missions.user_id = users.id AND user_missions.attended_at IS NOT NULL)"));

                //->on('user_missions.user_id', '=', 'users.id')
                //->on('user_missions.id', '=', DB::raw("(SELECT max(id) FROM user_missions WHERE user_missions.user_id = users.id)"))
        });
        $query = $query->select(['users.id', 'users.banned_at', 'user_missions.attended_at']);

        $users = $query
            ->where(function ($query) {
                $query->whereNull('user_missions.attended_at')->where('users.agreed_at', '<=', today()->subDays(30));
            })
            ->orWhere(function ($query) {
                $query->whereNotNull('user_missions.attended_at')->where('user_missions.attended_at', '<=', today()->subDays(30));
            })
            ->get();

        foreach ($users as $user)
        {
            if (is_null($user->banned_at))
            {
                $latestUnban = $userService->getRecord($user->id, UserRecordType::UNBAN_DATA->name)->first();

                if (is_null($latestUnban) || today()->diffInDays($latestUnban->created_at) > 7)
                {
                    if (is_null($user->attended_at) && $user->hasRole([RoleType::MEMBER->name, RoleType::MAKER1->name]))
                    {
                        $userService->ban($user->id, BanCommentType::USER_INACTIVE_NEWBIE->value);
                    }
                    else
                    {
                        if ($user->hasRole([RoleType::MEMBER->name, RoleType::MAKER1->name])) {
                            $userService->ban($user->id, BanCommentType::USER_INACTIVE_MISSION->value);
                        }
                    }
                }
            }
        }
        */

        return 0;
    }
}
