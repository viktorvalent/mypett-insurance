<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsMember
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
        if((!auth()->check() && !$request->expectsJson()) || !auth()->user()->role==2){
            return redirect()->route('sign-in.member');
        }
        return $next($request);
    }
}
