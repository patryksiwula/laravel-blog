<?php

use App\Http\Controllers\PostController;
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
	Route::get('/dashboard', function () {
		return view('dashboard');
	})->name('dashboard');

	Route::view('/posts/create', 'posts.create-post')->name('posts.create');

	Route::controller(PostController::class)->group(function () {
		Route::get('/posts/{post}/edit', 'edit')->name('posts.edit');
		Route::post('/posts', 'store')->name('posts.store');
		Route::patch('/posts/{post}', 'update')->name('posts.update');
		Route::delete('/posts/{post}', 'destroy')->name('posts.destroy');
	});
});

Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
require __DIR__.'/auth.php';
