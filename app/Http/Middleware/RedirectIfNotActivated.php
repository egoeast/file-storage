<?php

namespace App\Http\Middleware;

use Closure;

class RedirectIfNotActivated
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
        if(!$request->user()->isActive())
            return view('errors.error')->with('message', 'Your account is not active.We have sent on your email activation link.');
        return $next($request);
    }
}
