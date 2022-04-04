<?php

namespace App\Http\Middleware;

use App\Enums\PermissionType;
use App\Enums\RoleType;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class AuthenticateAdmin extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        $this->authenticate($request, $guards);

        $user = app('auth')->user();

        if (!$user->hasRole(RoleType::ADMIN->name))
        {
            abort(404);
        }

        return $next($request);
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request): ?string
    {
        if (!$request->expectsJson()) {
            return route('auth.login');
        }

        return null;
    }
}
