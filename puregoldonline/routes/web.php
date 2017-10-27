<?php

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
})->middleware('guest');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/addToCart/{id}', 'HomeController@addToCart');
Route::get('/addToCart/{id}', 'HomeController@addToCart');
Route::get('/checkout', 'HomeController@checkout');
Route::get('/deleteProduct/{cart_id}/{product_id}/{quantity}', 'HomeController@deleteProduct');
Route::post('/placeOrders', 'HomeController@placeOrders');
Route::get('/order/{order_id}/{cart_id}', 'HomeController@order');
Route::get('/thankyou', 'HomeController@thankyou');
Route::get('/createUser', 'HomeController@createUser');


