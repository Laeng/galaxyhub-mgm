<?php

namespace App\Http\Middleware;

use App\Action\UserGroup\UserGroup;
use Closure;
use Illuminate\Http\Request;

class AllowOnlyStaff
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

        $isUser = $groups->every(function ($value, $key) {
            return UserGroup::STAFF != $value->group_id;
        });

        if ($isUser) {
            //abort(404);
        }

        return $next($request);
    }
}
