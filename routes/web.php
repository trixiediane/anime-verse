<?php

use App\Http\Controllers\AnimeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth/login');
});

Route::get('/404', function () {
    return view('auth/404');
});

Auth::routes();


Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/top-anime', [AnimeController::class, 'getTopAnime'])->name('top-anime');
});

Route::post('/me', [UserController::class, 'getUserDetails'])->middleware('auth')->name('me');

Route::group(['middleware' => 'auth', 'prefix' => 'user'], function () {
    Route::get('profile', [UserController::class, 'index'])->name('user.index');
    Route::post('profile/{id}', [UserController::class, 'update'])->name('user.update');
    Route::get('profile/{id}', [UserController::class, 'edit'])->name('user.edit');
});

Route::group(['middleware' => 'auth', 'prefix' => 'anime'], function () {
    Route::get('/show/{id}', [AnimeController::class, 'show'])->name('anime.show');
    // Route::get('/category', [AnimeController::class, 'byCategory'])->name('anime.by-category');
    Route::get('category/{category_id}', [AnimeController::class, 'byCategory'])->name('anime.by-category');
});

Route::group(['middleware' => 'auth', 'prefix' => 'category'], function () {
    Route::get('categories-list', [CategoryController::class, 'list'])->name('category.list');
    Route::resource('category', CategoryController::class);
});
