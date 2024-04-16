<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleGuard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param mixed $roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (Auth::user()->role == 'admin') {
			return $next($request);
		}
        
        foreach ($roles as $role) {
            if(Auth::user()->role == $role) {
                return $next($request);
            }
        }
        
		abort(404);
    }
}
