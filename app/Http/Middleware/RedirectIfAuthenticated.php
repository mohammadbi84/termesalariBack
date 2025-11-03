<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
                // dd(111);
        if (Auth::guard($guard)->check()) 
        {
            //     dd(222);
            // return redirect()->route('dashboard');
            if(Auth::user()->isAdmin()) {
                // dd(333);
                return redirect()->route('dashboard');
            }
            return redirect(RouteServiceProvider::HOME);
        }
        return $next($request);
    }
}
