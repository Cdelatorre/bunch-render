<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class GymMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        if ($user->gm === 0) {
            $notify[] = ['error','You are not allowed Gym management.'];
            return to_route('user.home')->withNotify($notify);
        }

        return $next($request);
    }
}
