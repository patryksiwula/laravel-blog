<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::redirect('/', '/posts')->name('home');
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');

Route::middleware('auth')->group(function () {
	Route::resource('users', UserController::class)->except([
		'create', 'store'
	]);

	Route::view('/posts/create', 'posts.create-post')->name('posts.create');
	Route::resource('posts', PostController::class)->except([
		'create', 'index', 'show'
	]);

	Route::view('/posts/{post}/comments/create', 'posts.comments.create')->name('posts.comments.create');
	Route::resource('posts.comments', CommentController::class)->except([
		'create', 'index', 'show'
	]);

	Route::view('/posts/{post}/comments/{comment}/replies/create', 'posts.comments.create')->name('posts.replies.create');
});

Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
require __DIR__.'/auth.php';
