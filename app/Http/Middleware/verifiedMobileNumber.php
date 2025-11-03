<?php

namespace App\Http\Middleware;
use Illuminate\Http\Request;

use Closure;

class verifiedMobileNumber
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        
        // session()->flush();
        // dd(session()->all(), session()->has('authenticationUser'));
        if(!session()->has('authenticationUser') && !$request->is('register/step-one') ) {
            return redirect()->route('register.stepOne');
        }

        return $next($request);
    }
}
