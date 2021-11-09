<?php

namespace App\Http\Middleware;

use App\Action\Group\Group;
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

        $isNotStaff = $groups->every(function ($value, $key) {
            return match ($value->group_id) {
                Group::STAFF => false,
                default => true,
            };
        });

        if ($isNotStaff) {
            //abort(404);
        }

        return $next($request);
    }
}
