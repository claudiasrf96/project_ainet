<?php

namespace App\Http\Middleware;

use Closure;

class IsWaiter
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

     /* if ($request->user() && strcmp($request->user()->type "waiter"))
            return $next($request);
        throw new AccessDeniedHttpException('Unauthorized.');
*/
        return $next($request);
    }
}