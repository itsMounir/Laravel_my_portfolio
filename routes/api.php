<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\PharmacistController;
use App\Http\Controllers\StorehouseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SessionsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('products',[ProductsController::class,'index'])->middleware('auth:api'); // show all
Route::get('products/{id}',[ProductsController::class,'show'])->middleware('auth:api'); // show one
Route::delete('products/{id}',[ProductsController::class,'destroy'])->middleware('auth:api'); // delete
Route::post('products',[ProductsController::class,'store'])->middleware('auth:api'); // create
Route::get('orders',[OrderController::class,'show'])->middleware('auth:api');// show user orders


// pharmacist auth
Route::post('register',[SessionsController::class , 'create'])->middleware('guest:api'); // register (working)
Route::post('login',[SessionsController::class , 'store'])->middleware('guest:api')->name('login'); // login
Route::post('logout',[SessionsController::class , 'destroy'])->middleware('auth:api'); // login


// owner auth
Route::post('owner/register',[OwnerController::class , 'create'])->middleware('guest:api'); // register (working)
Route::post('owner/login',[OwnerController::class , 'store'])->middleware('guest:api'); // login
Route::post('owner/logout',[OwnerController::class , 'destroy'])->middleware('auth:api'); // login
Route::get('owner/orders/{storehouse_id}',[OrderController::class,'index'])->middleware('auth:api'); // show storehouse orders
Route::post('owner/orders/{storehouse_id}',[OrderController::class,'update'])->middleware('auth:api'); // show storehouse orders


// order routs
Route::post('orders/{storehouse_id}',[OrderController::class,'store'])->middleware('auth:api');
Route::delete('orders/delete/{storehouse_id}',[OrderController::class,'delete'])->middleware('auth:api');


//storehouses
Route::get('storehouses',[StorehouseController::class,'index'])->middleware('auth:api'); // show all

//Route::post('order',[OrderController::class,'store']);

/*
     <<<<< TO DO LIST>>>>>>>>>>
    4) cascade on delete & update
*/
/*
    RESPONSE FORM :
    [
        data :
        message :
        status : (like: 200, 404 ,403 ....)
    ]
*/
