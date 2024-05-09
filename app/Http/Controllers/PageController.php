<?php

namespace App\Http\Controllers;

use App\Http\Filters\PostFilter;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    public function admin(Request $request) 
    {
        $days = 30;
        if ($request->has('time')) {
            $time = $request->input('time');
            if($time == 'week') {
                $days = 7;
            } else if ($time == 'three_months') {
                $days = 90;
            } else if ($time == 'year') {
                $days = 365;
            }
        }
        $users = User::whereDate('created_at', '>=', now()->subDays($days))
            ->select(DB::raw('DATE(created_at) AS date'), DB::raw('COUNT(*) as data'))
            ->groupBy('date')
            ->get();

        // $data = $users->pluck("data")->toArray();
        // $labels = $users->pluck("date")->toArray();

        $posts = Post::whereDate('created_at', '>=', now()->subDays($days))
            ->select(DB::raw('DATE(created_at) AS date'), DB::raw('COUNT(*) as data'))
            ->groupBy('date')
            ->get();

        $comments = Comment::whereDate('created_at', '>=', now()->subDays($days))
            ->select(DB::raw('DATE(created_at) AS date'), DB::raw('COUNT(*) as data'))
            ->groupBy('date')
            ->get();
                    
        $categoryPosts = Post::select(DB::raw('COUNT(*) as data'))
            ->groupBy('category_id')
            ->with('category:id,name')
            ->get();


        // $chart = app()
        //     ->chartjs->name("UserRegistrationsChart")
        //     ->type("line")
        //     ->size(["width" => 400, "height" => 200])
        //     ->labels($labels)
        //     ->datasets([
        //         [
        //             "label" => "User Registrations",
        //             "backgroundColor" => "rgba(38, 185, 154, 0.31)",
        //             "borderColor" => "rgba(38, 185, 154, 0.7)",
        //             "data" => $data
        //         ]
        //     ]);

        return view('admin.index', [
            'users' => $users,
            'posts' => $posts,
            'comments' => $comments,
            'categoryPosts' => $categoryPosts,
            // 'chart' => $chart
        ]);

    }

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

    public function home(Request $request, PostFilter $filter)
    {
        $favCategories = Category::whereHas('users', fn ($query) => $query->where('user_id', Auth::user()->id))->get();

        $ids = $favCategories->pluck('id');
        $favPosts = null;


        $posts = Post::filter($filter)
            ->whereNotIn('category_id', $ids)
            ->where('deleted', false)
            ->with('likes')
            ->withCount('comments')
            ->simplePaginate(15);

        if($request->input('page') == null || $request->input('page') == 1) {
            $favPosts = Post::filter($filter)
                ->whereIn('category_id', $ids)
                ->where('deleted', false)
                ->with('likes')
                ->withCount('comments')
                ->limit(20)
                ->get(); 
        }

        $categories = Category::whereNotIn('id', $ids)
            ->orderBy('name', 'asc')
            ->get();
        

        return view('home', compact('posts', 'favPosts', 'favCategories', 'categories'));
    }
}
