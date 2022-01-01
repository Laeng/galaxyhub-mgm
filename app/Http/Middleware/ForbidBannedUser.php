<?php

namespace App\Http\Middleware;

use App\Action\Group\Group;
use Closure;
use Cog\Laravel\Ban\Http\Middleware\ForbidBannedUser as ForbidBannedUserAlias;
use Illuminate\Http\Request;

class ForbidBannedUser extends ForbidBannedUserAlias
{
    public function handle($request, Closure $next)
    {
        $user = $this->auth->user();
        $groups = $user->groups()->get();

        if (count($groups) > 0) { // 권한이 없는 유저는 미가입 유저
            $isNotMember = $groups->every(function ($value, $key) {
                return match ($value->group_id) {
                    Group::ARMA_REJECT, Group::ARMA_DEFER, Group::ARMA_APPLY => true,
                    default => false,
                };
            });
        } else {
            return true;
        }

        if ($isNotMember) {
            return redirect()->route('lounge.index');
        }

        return parent::handle($request, $next);
    }
}
