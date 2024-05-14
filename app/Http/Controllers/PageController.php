<?php

namespace App\Http\Controllers;

use App\Http\Filters\PostFilter;
use App\Http\Utils\Utils;
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
        
        $posts = Post::whereDate('created_at', '>=', now()->subDays($days))
            ->select(DB::raw('DATE(created_at) AS date'), DB::raw('COUNT(*) as data'))
            ->groupBy('date')
            ->get();

        $comments = Comment::whereDate('created_at', '>=', now()->subDays($days))
            ->select(DB::raw('DATE(created_at) AS date'), DB::raw('COUNT(*) as data'))
            ->groupBy('date')
            ->get();
                    
        $categoryPosts = Post::select(DB::raw('COUNT(*) as data'), 'category_id')
            ->whereDate('created_at', '>=', now()->subDays($days))
            ->where('deleted', false)
            ->groupBy('category_id')
            ->with('category:id,name')
            ->get();

        $charts = (object) [
            'users' => Utils::GetChart($users, $days, 'line', 'Registered users'),
            'posts' => Utils::GetChart($posts, $days, 'line', 'Submitted posts'),
            'comments' => Utils::GetChart($comments, $days, 'line', 'Submitted comments'),
            'categoryPosts' => Utils::GetChart($categoryPosts, $days, 'pie', 'Posts by category'),
        ];

        $stats = (object) [
            'categories' => Category::count(),
            'users' => User::count(),
            'mods' => User::where('role', 'moderator')->count(),
            'banned' => User::where('role', 'banned')->count(),
            'posts' => Post::count(),
            'comments' => Comment::count()
        ];

        
        if(Auth::user()->role == 'admin') {
            $db = env('DB_DATABASE');
            $size = DB::select("SELECT mb FROM (
                SELECT
                    table_schema as name, 
                    ROUND(SUM(data_length + index_length) / 1024 / 1024, 1) as mb 
                FROM information_schema.tables 
                GROUP BY table_schema) alias_one
                WHERE name = '$db'");
            $envData = null;
            $envData = (object) [
                'storage' => $size[0]->mb,
                'db' => env('DB_CONNECTION'),
                'host' => env('DB_HOST')
            ];
        }

        return view('admin.index', [
            'users' => $users,
            'posts' => $posts,
            'comments' => $comments,
            'categoryPosts' => $categoryPosts,
            'data' => $envData,
            'charts' => $charts,
            'stats' => $stats
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
        $favCategories = [];
        $ids = [];
        $favPosts = null;

        if(Auth::check()) {
            $favCategories = Category::whereHas('users', fn ($query) => $query->where('user_id', Auth::user()->id))->get();
            $ids = $favCategories->pluck('id');

            if($request->input('page') == null || $request->input('page') == 1) {
                $favPosts = Post::filter($filter)
                    ->whereIn('category_id', $ids)
                    ->where('deleted', false)
                    ->with('likes')
                    ->withCount('comments')
                    ->limit(20)
                    ->get(); 
            }
        }

        $posts = Post::filter($filter)
            ->whereNotIn('category_id', $ids)
            ->where('deleted', false)
            ->with('likes')
            ->withCount('comments')
            ->simplePaginate(15);


        $categories = Category::whereNotIn('id', $ids)
            ->orderBy('name', 'asc')
            ->get();
        

        return view('home', compact('posts', 'favPosts', 'favCategories', 'categories'));
    }
}
