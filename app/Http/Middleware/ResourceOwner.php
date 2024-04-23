<?php

namespace App\Http\Middleware;

use App\Models\Post;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Symfony\Component\HttpFoundation\Response;

class ResourceOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $resource = 'profile'): Response
    {
        if(Auth::user()->role == 'admin') {
            return $next($request);
        }

        if ($resource == 'profile' && Auth::user()->username == $request->user) {
            return $next($request);
        }

        abort(403);

    }
}
