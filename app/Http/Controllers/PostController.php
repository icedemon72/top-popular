<?php

namespace App\Http\Controllers;

use App\Http\Utils\Utils;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Models\Tag;
use Error;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class PostController extends Controller implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            new Middleware(['auth'], only: ['create', 'like']),
            new Middleware(['auth', 'owner:post'], only: ['edit', 'update', 'destroy'])
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index($category)
    {   
        $categoryData = Category::where('id', $category)->first();
        
        if(!$categoryData) {
            abort(404);
        }
        
        $posts = Post::filter()
            ->sort()
            ->where('category_id', $category)
            ->with('poster', 'likes')
            ->withCount('comments')
            ->get();

        $posts = Utils::GetLikes($posts);

        return view('posts.index', [
            'posts' => $posts,
            'category' => $categoryData
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $tags = Tag::get();

        return view('posts.create', [
            'categories' => $categories,
            'tags' => $tags
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->only('title', 'body', 'category', 'tags');
        
        $request->validate([
            'title' => 'required|string|max:256',
            'category' => 'required',
            'tags' => 'sometimes'
        ]);

        if(!Category::where('id', $request->category)->exists()) {
            abort(404, 'Bad request');
        }

        $tags = array();

        if(isset($request->tags)) {
            $tags = array_values(array_unique(explode(',', $request->tags)));
        }

        $tagIds = Tag::findMany($tags);

        if(sizeof($tagIds) !== sizeof($tags)) {
            abort(400);
        }

        $post = Post::create([
            'title' => $request->title,
            'body' => $request->body,
            'category_id' => $request->category,
            'user_id' => Auth::user()->id
        ]);

        if(sizeof($tagIds)) {
            $post->tags()->attach($tags);
        }

        return redirect()->route('post.show', ['post' => $post->id, 'category' => $request->category]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $category, string $id)
    {
        $post = Post::where(['id' => $id, 'category_id' => $category])->get()->first();

        if(!$post) {
            abort(404);
        }

        $data = Post::where('id', $id)
            ->with('tags:id,name', 'category:id,name', 'poster:id,username,role')
            ->get()
            ->first();

        $comments = Comment::sort()
            ->where(['post_id' => $id])
            ->with('replies', 'user', 'likes')
            ->get();
        
        $comments = Utils::GetLikes($comments); 

        $count = Like::whereHasMorph('likeable', Post::class)
            ->toBase()
            ->selectRaw('count(IF(type = "like", 0, null)) as likes')
            ->selectRaw('count(IF(type = "dislike", 0, null)) as dislikes')
            ->where('likeable_id', $id)
            ->get()
            ->first();

        $likeObj = null;

        if(Auth::check()) {
            $likeObj = Like::whereHasMorph('likeable', Post::class)
                ->where([
                    'user_id' => Auth::user()->id,  
                    'likeable_id' => $post->id
                ])
                ->get()
                ->first();
        }

        return view('posts.show', [
            'data' => $data,
            'comments' => $comments,
            'likes' => $count->likes,
            'dislikes' => $count->dislikes,
            'likeObj' => $likeObj ?? null
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $category, string $id)
    {
        $post = Post::where(['id' => $id, 'category_id' => $category])
            ->with('category:id,name', 'tags:id,name')
            ->get()
            ->first();
        
        if(!$post) {
            abort(404);
        }

        $categories = Category::get();

        $tags = Tag::get();

        $selected = array();

        foreach($post->tags as $tag) {
            array_push($selected, $tag->id);
        }
        
        unset($post['tags']);

        return view('posts.edit', [
            'post'=> $post,
            'categories'=> $categories,
            'tags' => $tags,
            'selected' => join(', ', $selected)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->only('title', 'body', 'category', 'tags');
        
        $request->validate([
            'title' => 'required|string',
            'body' => 'required|string',
            'category' => 'required',
            'tags' => 'nullable'
        ]);

        $category = Category::where('id', $request->category)
            ->get()
            ->first();

        if(!$category) {
            abort(403);
        }

        $tags = array();

        if(isset($request->tags)) {
            $tags = array_values(array_unique(explode(',', $request->tags)));
        }

        $tagIds = Tag::findMany($tags);

        if(sizeof($tagIds) !== sizeof($tags)) {
            abort(403);
        }

        try {
            $post = Post::find($id);

            if($post->category_id != $request->category && (Auth::user()->role != 'admin' || Auth::user()->role != 'moderator')) {
                abort(403);
            }

            Post::find($id)->update([
                'title' => $request->title,
                'body'=> $request->body,
                'category_id' => $request->category
            ]);

            if(sizeof($tagIds)) {
                $post->tags()->sync($tags);
            }
        } catch (Error $e) {
            abort(404);
        }
        
        return redirect(route('post.show', [
            'post' => $id, 'category' => $request->category
        ]))->with('edited', true);
    }

    public function like(Request $request, string $post) 
    {
        $type = $request->type ?? 'like';

        $postObj = Post::findOrFail($post);

        if($postObj->archived) {
            abort(403, 'Cannot like archived post...');
        }

        $alreadyLiked = Like::whereHasMorph('likeable', Post::class)->where([
            'user_id' => Auth::user()->id,  
            'likeable_id' => $post
        ])
            ->get()
            ->first();

        $switched = false;
        if(!$alreadyLiked) {
            $like = new Like([
                'user_id' => Auth::user()->id,
                'type' => $type
            ]);

            $like->likeable()->associate($postObj);
            $like->save();
        }  else {
            $switched = $alreadyLiked->type != $type;

            (!$switched) 
                ? Like::find($alreadyLiked->id)->delete()
                : Like::find($alreadyLiked->id)->update(['type' => $type]);
        }
        
        $count = Like::whereHasMorph('likeable', Post::class)->toBase()
            ->selectRaw('count(IF(type = "like", 0, null)) as likes')
            ->selectRaw('count(IF(type = "dislike", 0, null)) as dislikes')
            ->where('likeable_id', $post)
            ->get()
            ->first();

        return Response::json([
            'likes' => $count->likes,
            'dislikes' => $count->dislikes,
            'type' => $type,
            'alreadyLiked' => !$alreadyLiked,
            'post' => $post,
            'switched' => $switched
        ]);        
    }

    /** 
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getAll()
    {
        $posts = Post::with('category:id,name', 'poster:id,username')
            ->withCount('comments')
            ->get();
        
        return view('admin.posts.index', [
            'posts' => $posts
        ]);
    }

    // public function search(Request $request)
    // {
    //     $search = $request->query('search');
    //     $category = $request->query('category');

    //     $categoryData = Category::where('id', $category)
    //         ->get()
    //         ->first();

        
    //     if(!$categoryData) {
    //         abort(404);
    //     }
        
    //     $posts = DB::table('posts')
    //         ->select([
    //             'posts.*',
    //             'users.username',
    //             DB::raw('COUNT(comments.id) AS comments')
    //         ])
    //         ->join('users', 'users.id', '=', 'posts.user_id')
    //         ->leftJoin('comments', 'comments.post_id', '=', 'posts.id')
    //         ->where('posts.category_id', $category)
    //         ->where('title', 'like', "%$search%")
    //         ->where('category_id', $category)
    //         ->groupBy(DB::raw('1, 2'))
    //         ->get();
        
    //     $posts

    //     return view('posts.index', [
    //         'posts' => $posts, 
    //         'category' => $categoryData
    //     ]);
    // }

    public function archive(Request $request, string $post, bool $status)
    {

        $post = Post::findOrFail($post);
        $post->timestamps = false;
        $post->update([
            'archived' => $status
        ]);

        return redirect(route('post.show', ['category' => $post->category_id, 'post' => $post]));
    }
}
