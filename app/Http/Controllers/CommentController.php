<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class CommentController extends Controller implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            new Middleware(['auth'], only: ['create', 'store']),
            new Middleware(['auth', 'owner:comment'], only: ['edit', 'update', 'destroy'])
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $post)
    {
        $request->only(['body', 'parent']);

        $request->validate([
            'body' => 'required|string',
            'parent' => 'nullable|string'
        ]);
        
        $postExists = Post::where(['id' => $post, 'archived' => false])->get()->first();

        if(!$postExists) {
            abort(404);
        }

        if($request->parent !== null) {       
            if(!Comment::where(['id' => $request->parent, 'post_id' => $post])->exists()) {
                abort(404);
            }
        }

        Comment::create([
            'body' => $request->body,
            'post_id' => $post,
            'user_id' => Auth::user()->id,
            'parent' => $request->parent,
        ]);

        return redirect()->route('post.show', [
            'category' => $postExists->category_id,
            'post' => $post
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $post, string $id)
    {
        $comment = Comment::where([
            'id' => $id,
            'post_id' => $post
        ])
        ->with('post.poster', 'parent')
        ->firstOrFail();

        return view('comments.edit')->with([
            'comment' => $comment
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $comment = Comment::find($id);
        $comment->timestamps = false;
        $comment->deleted = true;
        $comment->save();

        return redirect()->back()->with('comment_deleted', true);
    }
    
    public function like(Request $request, string $comment)
    {
        $type = $request->type ?? 'like';

        $commentObj = Comment::findOrFail($comment);

        if($commentObj->with('post:id,archived')->get()->first()->post->archived) {
            abort(403, 'Cannot like archived post\'s comment');
        }
            
        $alreadyLiked = Like::whereHasMorph('likeable', Comment::class)
            ->where([
                'user_id' => Auth::user()->id,  
                'likeable_id' => $comment
            ])
            ->get()
            ->first();

        $switched = false;
        if(!$alreadyLiked) {
            $like = new Like([
                'user_id' => Auth::user()->id,
                'type' => $type
            ]);

            $like->likeable()->associate($commentObj);
            $like->save();
        }  else {
            $switched = $alreadyLiked->type != $type;

            (!$switched) 
                ? Like::find($alreadyLiked->id)->delete()
                : Like::find($alreadyLiked->id)->update(['type' => $type]);
        }
        
        $count = Like::whereHasMorph('likeable', Comment::class)->toBase()
            ->selectRaw('count(IF(type = "like", 0, null)) as likes')
            ->selectRaw('count(IF(type = "dislike", 0, null)) as dislikes')
            ->where('likeable_id', $comment)
            ->get()
            ->first();
    
        return Response::json([
            'likes' => $count->likes,
            'dislikes' => $count->dislikes,
            'type' => $type,
            'alreadyLiked' => !$alreadyLiked,
            'comment' => $comment,
            'switched' => $switched
        ]);
    }
}
