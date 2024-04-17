<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\RoleGuard;
use Illuminate\Support\Facades\Route;

/* Pages */
/* Anyone can access these */
Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');

Route::get('/about', function () {
    return view('pages.about');
})->name('about');


Route::resource('user', UserController::class)->except('create');

/* AUTH */
/* Not logged in users */
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('auth.login');
    Route::post('/login', [LoginController::class, 'login'])->name('login');

    Route::get('/register', [RegisterController::class, 'index'])->name('auth.register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register');
});

/* Only logged in users can access these */
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    /* Only admins */
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin', function () {
            return view('admin.index');
        })->name('admin.index');
    });
});
