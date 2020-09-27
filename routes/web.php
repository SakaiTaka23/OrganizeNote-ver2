<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\TableOfContentController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;


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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'user', 'middleware' => 'auth'], function () {
    Route::get('index', [ArticleController::class, 'index'])->name('userIndex');
    Route::get('searchArticle', [ArticleController::class, 'search'])->name('searchArticle');
    Route::resource('tag', TagController::class)->only(['index', 'show']);
    Route::get('status', [UserController::class, 'index'])->name('status');
    Route::get('content', [TableOfContentController::class, 'index'])->name('content');
    Route::get('searchContent', [TableOfContentController::class, 'search'])->name('searchContent');
});
