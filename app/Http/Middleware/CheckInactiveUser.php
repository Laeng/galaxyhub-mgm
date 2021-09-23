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

        $isActive = $groups->every(function ($value, $key) {
            return Group::BANNED != $value->group_id && Group::INACTIVE != $value->group_id;
        });

        if (!$isActive) {
            return redirect()->route('lounge');
        }

        return $next($request);
    }
}
