<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserDetailsController;
use App\Http\Controllers\PostController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth'])->group(function () {
    
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });
    
    // GET localhost:8000/p/1
    Route::get('/p/{user?}', [ProfileController::class, 'profile'])->name('profile');
    
    // GET localhost:8000/feed[/1]
    Route::get('/feed/{user?}', function () {
        return view('welcome');
    })->name('feed');
    
    // GET localhost:8000/post
    Route::get('/post', [PostController::class, 'create'])->name('post.create');
    
    // POST localhost:8000/post
    Route::post('/post', [PostController::class, 'store'])->name('post.store');
    
    // GET localhost:8000/post/123
    Route::get('/post/{post?}', function () {
        return view('welcome');
    })->name('post.show');
    
    // DELETE localhost:8000/post/123
    Route::delete('/post/{post}', function () {
        return view('welcome');
    })->name('post.remove');
    
    // GET localhost:8000/account
    Route::get('/account', [UserDetailsController::class, 'edit'])->name('account.edit');
    
    // POST localhost:8000/post
    Route::post('/account', [UserDetailsController::class, 'update'])->name('account.update');
    
    // GET localhost:8000/like/123
    Route::get('/like/{post}', function () {
        return view('welcome');
    })->name('likes.list');
    
    // POST localhost:8000/like/123
    Route::post('/like/{post}', function () {
        return view('welcome');
    })->name('likes.toggle');
    
    // GET localhost:8000/following/1
    Route::get('/following/{user}', function () {
        return view('welcome');
    })->name('following');
    
    // GET localhost:8000/followers/1
    Route::get('/followers/{user}', function () {
        return view('welcome');
    })->name('followers');
    
    // POST localhost:8000/follow/1
    Route::post('/follow/{user}', function () {
        return view('welcome');
    })->name('follow');
    
    // GET localhost:8000/search
    Route::get('/search', function () {
        return view('welcome');
    })->name('search.show');
    
    // GET localhost:8000/search/users?keywords=asdasd
    Route::get('/search/users', function () {
        return view('welcome');
    })->name('search.users');
    
    // comments.store -> POST
    // comments.destroy -> DELETE
});



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
