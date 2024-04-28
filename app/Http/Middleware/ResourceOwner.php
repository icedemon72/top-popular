<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Post;
use App\Models\Comment;

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

        if ($resource == 'post') {
            $post = $request->route('post');
            $created = Post::where([
                    'id' => $post, 
                    'user_id' => Auth::user()->id
                ])
                ->get()
                ->first()
                ->exists();
            
            if ($created) {
                return $next($request);
            }
        }

        if($resource == 'comment') {
            $comment = $request->route('comment');
            $created = Comment::where([
                'id' => $comment,
                'user_id' => Auth::user()->id
            ])
            ->get()
            ->first()
            ->exists();

            if($created) {
                return $next($request);
            }
        }
        abort(403);

    }
}
