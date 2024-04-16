<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index() {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse {
        $request->only('login', 'password');

        $request->validate([
            'login' => 'required',
            'password' => 'required'
        ]);

        // $user = User::where('email', $creds['login'])->orWhere('username', $creds['login'])->first();        
        $loginValue = $request->login;
        
        $login = filter_var($loginValue, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        
        $credentials = [
            $login => $loginValue,
            'password' => $request->password
        ];


        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
 
            return redirect()->intended('dashboard');
        }

        return redirect('/login')->withErrors([
            'login' => 'Invalid credentials'
        ]);
    }

    public function logout(Request $request) {
        Auth::logout();
        return redirect('/login');
    }
}
