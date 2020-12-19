<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;

class CheckIsDriver
{

    public function handle($request, Closure $next)
    {
        if (auth('api')->user()->type != User::DRIVER)
            return apiError(api('you have no permission'));
        return $next($request);
    }
}
