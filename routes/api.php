<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//php artisan route:list
//filtro de rutas de recurso
Route::resource('buyers', 'Buyer\BuyerController', ['only' => ['index','show']]);

// category
Route::resource('Categories', 'Category\CategoryController', ['except' => ['create','edit']]);

// Product

Route::resource('products', 'Product\ProductController', ['only' => ['index','show']]);

// Seller
Route::resource('sellers', 'Seller\SellerController', ['only' => ['index','show']]);

//Transactio

Route::resource('transactions', 'Transaction\TransactionController', ['only' => ['index','show']]);

//User

Route::resource('users', 'User\UserController', ['except' => ['create','edit']]);

