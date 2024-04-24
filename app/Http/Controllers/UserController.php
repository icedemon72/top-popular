<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            new Middleware(['auth', 'owner'], only: ['edit', 'update'])
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = DB::table('users')->get();
            
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
        $user = User::where('username', $id)->firstOrFail();
        // TODO: add posts, comments, etc. here...

        return view('profile.index', ['user' => $user]);
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
            'email' => 'sometimes|email|unique:users',
            'password' => 'min:4|nullable',
            'new_password' => 'min:4|nullable'
        ]);
        
        $user = User::findOrFail($id);


        if($request->email == $user->email) {
            $fields['email'] = null;
        }

        if($fields['password'] != null && $fields['new_password'] != null) {
            if($request->password != $request->new_password) {
                return redirect("/user/{$user->username}/edit")->withErrors([
                    'password' => '',
                    'new_password' => 'Passwords do not match' 
                ]);
            }
            if(Hash::make($request->password) != $user->password) {
                return redirect("/user/{$user->username}/edit")->withErrors([
                    'password' => 'Password is not correct'
                ]);
            }
        }
        
        $body = array_filter($fields);

        if(!sizeof($body)) {
            return view('profile.edit', ['user' => $user, 'id' => $id, 'username' => $user->username]);
        }

        User::where('id', $id)->update($body);
        return redirect("/user/{$user->username}/edit")->with(['edited'=>true]);
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
        $users = DB::table('users')
            ->where(['role' => 'moderator'])
            ->get();

        return view('admin.mods.index', [
            'users' => $users
        ]);
    }

    /**
     * Bans the specified user.
     */
    public function ban(string $id) 
    {
        //
    }

    /**
     * Unbans the specified user.
     */
    public function unban(string $id) 
    {
        //
    }
}
