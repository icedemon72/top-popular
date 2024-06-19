<?php

namespace App\Http\Controllers;

use App\Http\Filters\UserFilter;
use App\Http\Utils\Utils;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            new Middleware(['auth', 'owner:profile'], only: ['edit', 'update'])
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index(UserFilter $filter)
    {
        $users = User::filter($filter)->where('role', '!=', 'banned')->paginate(15);
            
        // dd($users);
        return view('admin.users.index', [
            'users' => $users
        ]);
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
        $user = User::where('username', $id)
            ->with([
                'posts' => fn ($query) => $query->where('deleted', '=', 0)->orderBy('posts.created_at', 'DESC')->limit(10), 
                'posts.likes',
                'comments' => fn ($query) => $query->where('deleted', '=', 0)->orderBy('comments.created_at', 'DESC')->limit(10), 
                'comments.likes',
            ])
            ->withCount('categories')
            ->get()
            ->first();

        if(!$user) {
            abort(404);
        }
        
        $stats = (object) [
            'likes' => 0,
            'dislikes' => 0,
            'liked' => 0,
            'disliked' => 0,
            'replies' => 0,
            'posts' => 0,
            'comments' => 0,
            'posts_count' => 0,
            'comments_count' => 0
        ];

        $likes = Like::where('user_id', $user->id)->get();
        
        foreach($likes as $like) {
            ($like->type == 'like') ? $stats->liked++ : $stats->disliked++;
        }

        $user->posts = Utils::GetLikes($user->posts); 
        $user->comments = Utils::GetLikes($user->comments);    

        foreach($user->posts as $post) {
            $stats->likes += $post->likeCount;
            $stats->dislikes += $post->dislikeCount;
        }

        foreach($user->comments as $comment) {
            $stats->likes += $comment->likeCount;
            $stats->dislikes += $comment->dislikeCount;
        }

        $stats->posts_count = Post::where([
            'user_id' => $user->id,
            'deleted' => false
        ])
        ->count();

        $stats->comments_count = Comment::where([
            'user_id' => $user->id,
            'deleted' => false
        ])
        ->count();      

        return view('profile.index', [
            'user' => $user,
            'stats' => $stats
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::where('username', $id)->firstOrFail();

        return view('profile.edit', ['user' => $user]);
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $fields = $request->only([
            'email',
            'name',
            'desc',
            'github',
            'instagram',
            'facebook',
            'x',
            'password',
            'new_password'
        ]);

        $request->validate([
            'email' => 'sometimes|email',
            'password' => 'sometimes|min:4|nullable',
            'new_password' => 'sometimes|min:4|nullable'
        ]);
        
        $user = User::where('username', $id);

        $userData = $user->get()->first();

        if($request->email ?? $user->email == $user->email) {
            $fields['email'] = null;
        } else {
            $request->validate(['email' => 'unique:users']);
        }

				if($userData->id == Auth::user()->id) {
					if($fields['password'] != null && $fields['new_password'] != null) {
							if($request->password != $request->new_password) {
									return redirect("/user/{$userData->username}/edit")->withErrors([
											'password' => '',
											'new_password' => 'Passwords do not match' 
									]);
							}
							if(Hash::make($request->password) != $user->password) {
									return redirect("/user/{$userData->username}/edit")->withErrors([
											'password' => 'Password is not correct'
									]);
							}
					}
				}
        
        $body = array_filter($fields);

        if(!sizeof($body)) {
            return view('profile.edit', ['user' => $user, 'id' => $id, 'username' => $user->username]);
        }

        User::where('username', $id)->update($body);
        return redirect(route('user.edit', ['user' => $userData->username]))->with(['edited'=>true]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function modIndex()
    {
        $users = User::where(['role' => 'moderator'])->get();

        return view('admin.mods.index', [
            'users' => $users
        ]);
    }

    /**
     * Bans the specified user.
     */
    public function ban(string $id) 
    {
        $user = User::findOrFail($id);

        if($user->role == 'admin' || (Auth::user()->role == $user->role)) {
            abort(403);
        }

        $user->role = 'banned';
        $user->save();

        return redirect()->back()->with('banned', true);
    }

    /**
     * Unbans the specified user.
     */
    public function unban(string $id) 
    {
        $user = User::where(['id' => $id, 'role' => 'banned'])->get()->first();

        $user->role = 'user';
        $user->save();

        return redirect()->back()->with('unbanned', true);
    }

    public function showBanned(UserFilter $filter)
    {
        $users = User::filter($filter)->where(['role' => 'banned'])->paginate(15);

        return view('admin.bans.index', [
            'users' => $users
        ]);
    }

    public function changePicture(Request $request)
    {
        $request->validate([
            'image' => 'required|mimes:jpg,jpeg,png,svg|max:2048'
        ]);

        $user = User::find(Auth::user()->id);
        $username = Auth::user()->username;
        $img = time().'.'.$request->file('image')->extension();

        $request->image->storeAs("public/images/profile/$username", $img);

        $user->image = "images/profile/$username/$img";
        $user->save();

        return redirect(route('user.show', ['user' => $user->username]))->with('upload', true);
    }

    public function changeRole(Request $request, string $user)
    {
        $request->only('role');

        $request->validate([
            'role' => 'required|in:moderator,user'
        ]);

        $user = User::find($user);
        $user->role = $request->role;
        $user->save();
        
        return redirect()->back()->with('role_changed', true);
    }
}
