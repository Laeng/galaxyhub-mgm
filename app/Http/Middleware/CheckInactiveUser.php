<?php

namespace App\Http\Middleware;

use App\Action\Group\Group;
use Closure;
use Illuminate\Http\Request;

class CheckInactiveUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $groups = $request->user()->groups()->get(['group_id']);

        if (count($groups) > 0) {
            $isNotMember = $groups->every(function ($value, $key) {
                return match ($value->group_id) {
                    Group::ARMA_REJECT, Group::ARMA_DEFER, Group::ARMA_APPLY, Group::INACTIVE, Group::BANNED => true,
                    default => false,
                };
            });

        } else {
            $isNotMember = true;
        }

        if ($isNotMember) {
            return redirect()->route('lounge.index');
        }

        return $next($request);
    }
}
