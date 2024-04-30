<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Http\Requests\StoreTagRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // add filters
        $tags = Tag::with('user:id,name', 'categories:id,name')->paginate(15);

        return view('admin.tags.index', [
            'tags' => $tags
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
            return redirect(route('tag.create'))->withErrors([
                'name' => 'Tag with this name already exists!'
            ]);
        }

        $categories = array();

        if(isset($request->categories)) {
            $categories = array_values(array_unique(explode(',', $request->categories)));
        }

        $categoryIds = Category::findMany($categories);

        if(sizeof($categoryIds) !== sizeof($categories)) {
            abort(404);
        }

        $tag = Tag::create([
            'name' => $request->name,
            'created_by' => Auth::user()->id
        ]);

        if(sizeof($categoryIds)) {
            $tag->categories()->attach($categories);
        }

        return redirect(route('tag.create'))->with('success', true);
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
    public function edit(string $id)
    {
        // $categories = Category::where("id", "=", function($query){
        //     $query->from("category_tag")
        //     ->where("tag_id", "not", );
        // })
        // ->get();
        //
        $tag = Tag::where(['id' => $id])->with('categories')->first();
        
        if(!$tag) {
            abort(404);
        }
        
        $categories = Category::get();

        $selectedCategories = array();

        foreach($tag->categories as $category) {
            array_push($selectedCategories, $category->id);
        }

        return view('admin.tags.edit', [
            'tag' => $tag,
            'categories' => $categories,
            'selected' => join(', ', $selectedCategories)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->only(['name', 'categories']);
        $request->validate([
            'name' => 'required|string',
            'categories' => 'required'
        ]);

        $tagExists = Tag::where('id', $id)
            ->get()
            ->first();

        if(!$tagExists) {
            abort(404);
        }

        $categories = explode(',', $request->categories);

        $categoryIds = Category::findMany($categories);

        if(sizeof($categoryIds) !== sizeof($categories)) {
            return redirect(route('tag.edit', [
                'tag' => $id
            ]))->withErrors([
                'category' => __('Wrong category ID provided.')
            ]);
        }
        
        Tag::where('id', $id)->update([
            'name' => $request->name,
        ]);

        $tag = Tag::find($id);
        
        $tag->categories()->sync($categoryIds);

        return redirect(route('tag.edit', [
            'tag' => $id
        ]))->with('edited', true);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        $tag->deleteOrFail();
        return redirect(route('tag.index'))->with('deleted', true);
    }
}
