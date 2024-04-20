<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.tags.index', [
            'tags' => Tag::get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::get();
        return view('admin.tags.create', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTagRequest $request)
    {
        $request->only(['name', 'categories']);
        $request->validate([
            'name' => 'required|string|unique:categories',
            'categories' => 'sometimes'
        ]);

        $tagExists = Tag::where(['name' => $request->name])->exists();

        if($tagExists) {
            return redirect('/admin/tag/create')->withErrors([
                'name' => 'Tag with this name already exists!'
            ]);
        }

        $categories = array();

        if(isset($request->categories)) {
            $categories = array_values(array_unique(explode(',', $request->categories)));
        }

        $categoryIds = Category::findMany($categories);

        if(sizeof($categoryIds) !== sizeof($categories)) {
            abort(400);
        }

        $tag = Tag::create([
            'name' => $request->name
        ]);

        if(sizeof($categoryIds)) {
            $tag->categories()->attach($categories);
        }

        return redirect('/admin/tag/create')->with('success', true);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $tag)
    {
        // $categories = Category::where("id", "=", function($query){
        //     $query->from("category_tag")
        //     ->where("tag_id", "not", );
        // })
        // ->get();
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTagRequest $request, Tag $tag)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        //
    }
}
