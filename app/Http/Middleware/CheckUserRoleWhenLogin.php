<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CheckUserRoleWhenLogin
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
        // return (Auth::user()->role);
        if(Auth::user()->role == 'admin')
        {
            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}
