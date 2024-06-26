<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/* Pages */
/* Anyone can access these */
Route::get('/', [PageController::class, 'home'])->name('home');

Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');

Route::get('/about', [PageController::class, 'about'])->name('about');

Route::resource('user', UserController::class)->except(['create', 'index', 'store', 'destroy']);

Route::get('post/filter', [PostController::class, 'search'])->name('post.search');
Route::resource('category/{category}/post', PostController::class)->except(['store', 'update', 'destroy']);
Route::resource('post/{post}/comment', CommentController::class)->except(['index', 'destroy']);

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
    Route::post('/post/{post}/like', [PostController::class, 'like'])->name('post.like');
    Route::post('/comment/{comment}/like', [CommentController::class, 'like'])->name('comment.like');
    Route::post('/category/{id}/join', [CategoryController::class, 'join'])->name('category.join');
    Route::patch('/user/picture/update', [UserController::class, 'changePicture'])->name('user.pic');
    
    Route::resource('message', MessageController::class)->except(['create', 'edit', 'update', 'destroy']);
    
    /* Moderators */
    Route::middleware('role:moderator')->group(function() {
        Route::patch('/post/{post}/archive/{status}', [PostController::class, 'archive'])->name('post.archive');
        Route::delete('/post/{id}', [PostController::class, 'destroy'])->middleware('owner:post')->name('post.destroy');
        Route::delete('/comment/{id}', [CommentController::class, 'destroy'])->middleware('owner:comment')->name('comment.destroy');
        
        Route::resource('admin/tag', TagController::class)->except(['show']);
        Route::get('/admin', [PageController::class, 'admin'])->name('admin.index');
        
        Route::get('/admin/bans', [UserController::class, 'showBanned'])->name('admin.user.ban');
        Route::get('admin/post', [PostController::class, 'getAll'])->name('admin.post.index');
        Route::resource('admin/user', UserController::class)->only('index');

        Route::post('/user/{id}/ban', [UserController::class, 'ban'])->name('user.ban');
        Route::post('/user/{id}/unban', [UserController::class, 'unban'])->name('user.unban');
    });

    /* Only admins */
    Route::middleware('role:admin')->group(function () {
        Route::resource('admin/category', CategoryController::class)->except(['show']);
        Route::get('admin/mod', [UserController::class, 'modIndex'])->name('mod.index');
        Route::patch('/user/{user}/role', [UserController::class, 'changeRole'])->name('user.role');
        Route::patch('/message/{message}', [MessageController::class, 'updateStatus'])->name('message.updateStatus');
    }); 
});
