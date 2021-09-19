<?php

namespace App\Http\Middleware;

use App\Action\UserGroup\UserGroup;
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

        $isActive = $groups->every(function ($value, $key) {
            return UserGroup::BANNED != $value->group_id && UserGroup::INACTIVE != $value->group_id;
        });

        if (!$isActive) {
            return redirect()->route('lounge');
        }

        return $next($request);
    }
}
