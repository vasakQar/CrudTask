<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\HomeController;

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

Auth::routes(['verify' => true]);

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::prefix('user')->name('user.')->group(function (){
    Route::get('/list',[HomeController::class,'userList'])->name('list');
    Route::delete('/delete/{id}',[HomeController::class,'deleteUser'])->name('delete');
    Route::get('/show/{id}',[HomeController::class,'showUser'])->name('show');
    Route::get('/show/post/{id}',[PostController::class,'showPost'])->name('show.post');
});

Route::resource('/posts',PostController::class);


