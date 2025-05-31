<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
class RedirectIfNotAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle($request, Closure $next, $guard = 'admin')
    {
        \Log::info('admin guard?', ['auth' => auth('admin')->check()]);
        if (!Auth::guard($guard)->check()) {
            return to_route('admin.login');
        }

        return $next($request);
    }
}
