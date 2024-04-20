<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;

class PostController extends Controller implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            new Middleware(['auth'], only: ['create', 'store']),
            new Middleware(['auth', 'owner'], only: ['edit', 'update', 'destroy'])
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index($category)
    {   

        $categoryData = DB::table('categories')->where('id', $category)->first();
        $posts = Post::with('poster')->where('category_id', $category)->get();

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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
