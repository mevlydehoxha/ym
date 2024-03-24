<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;


Auth::routes(['verify' => true]);


Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create')->middleware('verified');
Route::post('/posts', [PostController::class, 'store'])->name('posts.store')->middleware('verified');
Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit')->middleware('verified');
Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update')->middleware('verified');
Route::patch('/posts/{post}', [PostController::class, 'update'])->middleware('verified');
Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy')->middleware('verified');

Route::resource('comments', CommentController::class);
Route::get('/comments/{comment}/edit', [CommentController::Class, 'edit'])->name('comments.edit');
Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');

Route::get('/posts/search', [PostController::class, 'search'])->name('posts.search');

Route::get('/verify-email', function () {
    return view('auth.verify-email');
})->name('auth.verify-email');