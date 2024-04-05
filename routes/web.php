<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Article;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/volunteer', function () {
    $articles = Article::all();
    return view('volunteer', compact('articles'));
})->name('volunteer');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');


Route::middleware('auth')->prefix('dashboard')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');

    Route::get('/volunteers', [AdminController::class, 'volunteers'])->name('dashboard.volunteers');

    Route::get('/donations', [AdminController::class, 'donates'])->name('dashboard.donations');

    Route::get('/users', [AdminController::class, 'users'])->name('dashboard.users');

    Route::get('/articles', [AdminController::class, 'articles'])->name('dashboard.articles');
    Route::get('/articles/create', [AdminController::class, 'create'])->name('articles.create');
    Route::post('/articles', [AdminController::class, 'store'])->name('articles.store');
    Route::get('/articles/{id}/edit', [AdminController::class, 'edit'])->name('articles.edit');
    Route::put('/articles/{id}', [AdminController::class, 'update'])->name('articles.update');
    Route::delete('/articles/{id}', [AdminController::class, 'destroy'])->name('articles.destroy');
});

Route::controller(UserController::class)->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'doLogin')->name('doLogin');
    Route::get('/register', 'register')->name('register');
    Route::post('/register', 'doRegister')->name('doRegister');
});
