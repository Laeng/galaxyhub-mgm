<?php

namespace App\Http\Middleware;

use App\Action\Group\Group;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class ForbidUser
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * @param Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     *
     * @throws \Exception
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $user = $this->auth->user();
        $groups = $user->groups()->get(['group_id']);

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
