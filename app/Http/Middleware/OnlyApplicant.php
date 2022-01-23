<?php

namespace App\Http\Middleware;

use App\Action\Group\Group;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class OnlyApplicant
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
        $user = $request->user();
        $groups = $user->groups()->get();
        $isNotApplicant = false;

        if (!is_null($groups) && is_null($user->agreed_at) && $groups->count() > 0) {
            if ($groups->has([Group::STAFF], $user)) {
                $isNotApplicant = true;
            }

        } else {
            $isNotApplicant = true;
        }

        if ($isNotApplicant && !config('app.debug')) {
            abort(404);
        }

        return $next($request);
    }
}
