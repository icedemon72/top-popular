<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        $stats = (object) [
            'categories' => Category::count(),
            'users' => User::count(),
            'posts' => Post::count(),
            'comments' => Comment::count()
        ];

        return view('pages.about')->with([
            'stats' => $stats
        ]);
    }
}
