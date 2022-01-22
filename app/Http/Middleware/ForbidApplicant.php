<?php

namespace App\Http\Middleware;

use App\Action\Group\Group;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class ForbidApplicant
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected Guard $auth;

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
        $groups = $user->groups()->get();
        $isNotMember = true;

        if (count($groups) > 0) { // 미가입 유저는 권한 자체가 없다.
            $isNotMember = $groups->every(function ($value, $key) {
                return match ($value->group_id) {
                    Group::ARMA_REJECT, Group::ARMA_DEFER, Group::ARMA_APPLY => true,
                    default => false,
                };
            });
        }

        if ($isNotMember) {
            return redirect()->route('application.index');
        }

        return $next($request);
    }
}
