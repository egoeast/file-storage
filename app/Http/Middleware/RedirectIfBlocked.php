<?php

namespace App\Http\Middleware;

use Closure;

class RedirectIfBlocked
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
        if($request->user()->isBlocked())
            return view('errors.error')->with('message', 'Your account has been blocked');
        return $next($request);
    }
}
