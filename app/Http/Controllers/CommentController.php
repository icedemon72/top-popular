<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            new Middleware(['auth'], only: ['create']),
            new Middleware(['auth', 'owner'], only: ['edit', 'update', 'destroy'])
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
        
        $postExists = DB::table('posts')->where(['id' => $post, 'archived' => false])->get()->first();

        if(!$postExists) {
            abort(404);
        }

        if($request->parent !== null) {
            $parentExists = DB::table('comments')->where(['id' => $request->parent, 'post_id' => $post]);            
            
            if(!$parentExists) {
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
        //
    }
}
