<?php

namespace App\Http\Middleware;

use Closure;
use Cog\Laravel\Ban\Http\Middleware\ForbidBannedUser as ForbidBannedUserAlias;
use Illuminate\Http\Request;

class ForbidBannedUser extends ForbidBannedUserAlias
{
    public function handle($request, Closure $next)
    {
        if (config('app.debug')) {
            \Barryvdh\Debugbar\Facade::alert("bypassed by debug mode!!!");

            return $next($request);
        }

        return parent::handle($request, $next);
    }
}
