<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Tag;

class CategoryController extends Controller 
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::filter()->sort()->withCount('posts')->paginate(15);
        return view('admin.categories.index', ['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tags = Tag::get();
        return view('admin.categories.create', ['tags' => $tags]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $request->only(['name', 'tags', 'icon']);
        $request->validate([
            'name' => 'required|string|unique:categories',
            'icon' => 'sometimes|mimes:svg|max:1024',
            'tags' => 'sometimes'
        ]);

        $categoryExists = Category::where(['name' => $request->name])->exists();

        if($categoryExists) {
            return redirect('/admin/category/create')->withErrors([
                'name' => 'Category with this name already exists!'
            ]);
        }

        $iconName = '';

        if(isset($request->icon)) {
            $iconName = time().'.svg';
            $request->icon->storeAs('public/images/category/'.$request->name, $iconName);
        }

        $tags = array();

        if(isset($request->tags)) {
            $tags = array_values(array_unique(explode(',', $request->tags)));
        }

        $tagIds = Tag::findMany($tags);

        if(sizeof($tagIds) !== sizeof($tags)) {
            abort(403);
        }

        $category = Category::create([
            'name' => $request->name,
            'icon' => 'images/category/'.$request->name.'/'.$iconName
        ]);

        if(sizeof($tagIds)) {
            $category->tags()->attach($tags);
        }

        return redirect('/admin/category/create')->with('success', true);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::where(['id' => $id])->with('tags')->first();
        
        if(!$category) {
            abort(404);
        }
        
        $tags = Tag::get();
        $selectedTags = array();

        foreach($category->tags as $tag) {
            array_push($selectedTags, $tag->id);
        }

        return view('admin.categories.edit', [
            'category' => $category,
            'tags' => $tags,
            'selected' => join(', ', $selectedTags)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->deleteOrFail();
        return redirect(route('category.index'))->with('deleted', true);
    }
}
