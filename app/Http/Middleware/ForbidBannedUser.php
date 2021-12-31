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
        $isNotMember = $user->groups()->get()->every(function ($value, $key) {
            return match ($value->group_id) {
                Group::ARMA_REJECT, Group::ARMA_DEFER, Group::ARMA_APPLY => true,
                default => false,
            };
        });

        if ($isNotMember) {
            return redirect()->route('lounge.index');
        }

        return parent::handle($request, $next);
    }
}
