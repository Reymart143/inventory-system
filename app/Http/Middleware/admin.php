<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class admin
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
        // 0 = admin
        // 1 = staff
        // 2 = seller
        if(Auth::check()){
            if(Auth::user()->role == '0'){
                return $next($request);
            }else{
                return redirect('/login')->with('message', 'Access Denied Admin Access Only!');
            }
        }else{
            return redirect('/login')->with('message', 'Please login first.');
        }
        return $next($request);
    }
}
