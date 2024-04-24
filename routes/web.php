<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
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


Route::resource('user', UserController::class)->except(['create', 'index']);
Route::resource('category/{category}/post', PostController::class)->except(['store', 'update']);
Route::resource('post/{post}/comment', CommentController::class)->except('index');

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
    
    Route::post('/post', [PostController::class, 'store'])->name('post.store');

    Route::patch('/post/{post}', [PostController::class,'update'])->name('post.update');
    /* Only admins */
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin', function () {
            return view('admin.index');
        })->name('admin.index');

        Route::resource('admin/category', CategoryController::class);
        Route::resource('admin/tag', TagController::class);
        Route::resource('admin/user', UserController::class)->only('index');
    }); 
});
