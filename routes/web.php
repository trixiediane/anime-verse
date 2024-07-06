<?php

use App\Http\Controllers\AnimeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth/login');
});

Auth::routes();


Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/top-anime', [AnimeController::class, 'getTopAnime'])->name('top-anime');
});

Route::group(['middleware' => 'auth', 'prefix' => 'anime'], function () {
    Route::get('/show/{id}', [AnimeController::class, 'show'])->name('anime.show');
});
