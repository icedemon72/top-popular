<?php

namespace App\Http\Controllers;


use League\HTMLToMarkdown\HtmlConverter;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostController extends Controller implements HasMiddleware
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
    public function index($category)
    {   
        $categoryData = DB::table('categories')->where('id', $category)->first();
        
        $posts = DB::table('posts')
                    ->select([
                        'posts.*',
                        'users.username',
                        DB::raw('COUNT(comments.id) AS comments')
                    ])
                    ->join('users', 'users.id', '=', 'posts.user_id')
                    ->leftJoin('comments', 'comments.post_id', '=', 'posts.id')
                    ->where('posts.category_id', $category)
                    ->groupBy(DB::raw('1, 2'))
                    ->get();

        if(!$categoryData) {
            abort(404);
        }
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
        $categories = DB::table('categories')->orderBy('name')->get();
        $tags = DB::table('tags')->get();

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
        $converter = new HtmlConverter(array('preserve_comments' => true, 'header_style' => 'atx'));

        $converted = $converter->convert($request->body);

        $category = DB::table('categories')->where('id', $request->category)->exists();

        if(!$category) {
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
        $post = DB::table('posts')->where(['id' => $id, 'category_id' => $category])->get()->first();

        if(!$post) {
            abort(404);
        }

        $tags = DB::table('post_tag')
            ->select(['tags.name', 'tags.id'])
            ->join('tags', 'tags.id', '=', 'post_tag.tag_id')
            ->where('post_id', $id)
            ->get();

        $data = DB::table('posts')
            ->select([
                'posts.*',
                'categories.name AS category',
                'users.username AS username',
                'users.role AS role'
            ])
            ->join('categories', 'categories.id', '=', 'posts.category_id')
            ->join('users', 'users.id', '=', 'posts.user_id')
            ->where('posts.id', $id)
            ->get()
            ->first();

        $comments = DB::table('comments')
            ->select([
                'comments.*',
                'users.username AS username'
            ])
            ->join('users', 'users.id', '=', 'comments.user_id')
            ->where('post_id', $id)
            ->orderBy('created_at', 'asc')
            ->get();

        return view('posts.show', [
            'data' => $data,
            'tags' => $tags,
            'comments' => $comments
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = DB::table('posts')
            ->select(['posts.*', 'categories.name AS category'])
            ->join('categories', 'categories.id', '=', 'posts.category_id')
            ->where('posts.id', $id)
            ->get()
            ->first();

        $categories = DB::table('categories')->get();

        $tags = DB::table('tags')->get();

        return view('posts.edit', [
            'post'=> $post,
            'categories'=> $categories,
            'tags' => $tags
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

        $category = DB::table('categories')
            ->where('id', $request->category)
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
            abort(400);
        }

        $post = Post::findOrFail($id)
            ->update([
                'title' => $request->title,
                'body'=> $request->body,
                'category_id' => $request->category
            ]);

        if(sizeof($tagIds)) {
            $post->tags()->attach($tags);
        }
        
        return redirect(route('post.show', [
            'post' => $id, 'category' => $request->category
        ]))->with('edited', true);
    }

    /** 
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
