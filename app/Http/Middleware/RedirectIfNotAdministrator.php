<?php

namespace App\Http\Middleware;

use Closure;

class RedirectIfNotAdministrator
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
        if(!$request->user()->isAdmin())
            return view('errors.error')->with('message', 'You have no permission to edit accounts');
        return $next($request);
    }
}
