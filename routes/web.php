<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

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
    Route::get('/p/{user}', [ProfileController::class, 'profile'])->name('profile');
    
    // GET localhost:8000/feed[/1]
    Route::get('/feed/{user?}', function () {
        return view('welcome');
    })->name('feed');
    
    // GET localhost:8000/post
    Route::get('/post', function () {
        return view('welcome');
    })->name('post.create');
    
    // POST localhost:8000/post
    Route::post('/post', function () {
        return view('welcome');
    })->name('post.store');
    
    // GET localhost:8000/post/123
    Route::get('/post/{post?}', function () {
        return view('welcome');
    })->name('post.show');
    
    // DELETE localhost:8000/post/123
    Route::delete('/post/{post}', function () {
        return view('welcome');
    })->name('post.remove');
    
    // GET localhost:8000/account
    Route::get('/account', function () {
        return view('welcome');
    })->name('account.edit');
    
    // POST localhost:8000/post
    Route::post('/account', function () {
        return view('welcome');
    })->name('account.update');
    
    // GET localhost:8000/like/123
    Route::get('/like/{post}', function () {
        return view('welcome');
    })->name('likes.list');
    
    // POST localhost:8000/like/123
    Route::post('/like/{post}', function () {
        return view('welcome');
    })->name('likes.toggle');
});



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
