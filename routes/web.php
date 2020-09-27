<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\TagController;


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

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::group(['prefix' => 'user', 'middleware' => 'auth'], function () {
    Route::get('dashboard', function () {
        return view('dashboard');
    });
    Route::resource('index', ArticleController::class)->only(['index']);
    Route::get('/searchArticle', [ArticleController::class, 'search'])->name('searchArticle');
    //Route::resource('tag', TagController::class)->only(['index', 'show']);
    // Route::get('/content', [TableOfContentController::class, 'index'])->name('content');
    // Route::get('/searchContent', [TableOfContentController::class, 'search'])->name('searchContent');
});
