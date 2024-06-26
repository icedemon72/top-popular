<?php

namespace App\Http\Controllers;

use App\Http\Filters\CommentFilter;
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
use App\Http\Filters\PostFilter;
use App\Models\User;

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
    public function index($category, PostFilter $filter)
    {   
        $categoryData = Category::where('id', $category)->first();

        if(!$categoryData) {
            abort(404);
        }
        
        $posts = Post::filter($filter)->where([
            'category_id' => $category,
            'deleted' => false
            ])
            ->with('poster:id,image,username')
            ->withCount('comments');
        
        $posts = $posts->simplePaginate(10);
        $posts = Utils::GetLikes($posts);

        $fav = Category::find($categoryData->id)->users()->where('user_id', '=', Auth::user()->id ?? 0)->exists();

        return view('posts.index', [
            'posts' => $posts,
            'category' => $categoryData,
            'fav' => $fav
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
    public function show(CommentFilter $filter, string $category, string $id)
    {
        $post = Post::where(['id' => $id, 'category_id' => $category])->get()->first();

        if(!$post) {
            abort(404);
        }

        $data = Post::where('id', $id)
            ->with('tags:id,name', 'category:id,name', 'poster:id,username,role,image')
            ->get()
            ->first();

        $comments = Comment::filter($filter)
            ->where(['post_id' => $id])
            ->with('replies', 'user', 'likes')
            ->get();
        
        $comments = Utils::GetLikes($comments); 
        
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

        if($postObj->archived || $postObj->deleted) {
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
        $post = Post::find($id);
        $category = $post->category_id;

        $post->timestamps = false;
        $post->deleted = true;
        $post->save();


        $commentCount = Comment::where([
            'post_id' => $post->id,
            'deleted' => false
        ])->count();

        if($commentCount == 0) {
            $post->delete();
            return redirect(route('post.index', ['category' => $category]))->with('deleted', true);
        }

        return redirect()->back()->with('post_deleted', true);
    }

    public function getAll(PostFilter $filter)
    {
        $posts = Post::filter($filter)
            ->with('category:id,name', 'poster:id,username,image')
            ->withCount('comments')
            ->paginate(15);
                

        $categories = Category::withCount('posts')->having('posts_count', '>', '0')->get();
        
        return view('admin.posts.index', [
            'posts' => $posts,
            'categories' => $categories
        ]);
    }
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
