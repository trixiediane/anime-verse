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

    // Route::get('/category', [AnimeController::class, 'byCategory'])->name('anime.by-category');
    Route::get('anime/category/{category_id}', [UserController::class, 'byUsersCategory'])->name('user.categories');
});

Route::group(['middleware' => 'auth', 'prefix' => 'anime'], function () {
    Route::get('/show/{id}', [AnimeController::class, 'show'])->name('anime.show');

    Route::get('/list', [AnimeController::class, 'fetchAnimeData'])->name('anime.user-list');

    Route::post('category/update', [AnimeController::class, 'update'])->name('anime.update');
    Route::post('category/create', [AnimeController::class, 'store'])->name('anime.store');
    Route::delete('category/remove', [AnimeController::class, 'destroy'])->name('anime.delete');

    Route::get('/search/view', [AnimeController::class, 'searchView'])->name('anime.search-view');
    Route::get('/search', [AnimeController::class, 'search'])->name('anime.search');

    Route::get('/characters/view', [AnimeController::class, 'characterView'])->name('anime.character-view');
    Route::get('/characters/search', [AnimeController::class, 'searchCharacters'])->name('anime.characters');
});

Route::group(['middleware' => 'auth', 'prefix' => 'category'], function () {
    Route::get('categories-list', [CategoryController::class, 'list'])->name('category.list');
    Route::resource('category', CategoryController::class);
    Route::get('info', [CategoryController::class, 'category'])->name('category.info');
    Route::post('category/update', [CategoryController::class, 'update'])->name('category.update');
    // Route::resource('category', CategoryController::class);
});

// Fallback route for unmatched routes
Route::fallback(function () {
    return redirect('/404');
});
