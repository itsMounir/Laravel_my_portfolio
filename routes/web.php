<?php

use App\Http\Controllers\PostController;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\PostCommentsController;


use App\Models\Post;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',[PostController::class,'index']);
Route::get('posts/{post:slug}',[PostController::class,'show']);

Route::post('posts/{post:slug}/comments',[PostCommentsController::class,'store']);


Route::get('/register',[RegisterController::class,'create'])->middleware('guest');
Route::post('/register',[RegisterController::class,'store'])->middleware('guest');

Route::post('/logout',[SessionsController::class,'destroy'])->middleware('auth');

Route::get('/login',function (){
    return view('sessions.create');
})->middleware('guest');
Route::post('/login',[SessionsController::class,'store'])->middleware('guest');

Route::get('admin/posts/create',[PostController::class,'create'])->middleware('admin');
Route::post('admin/posts',[PostController::class,'store'])->middleware('admin');
