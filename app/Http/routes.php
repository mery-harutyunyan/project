<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');
Route::get('auth/verify/{token}', 'Auth\AuthController@verify');

// User routes...
Route::get('dashboard', 'UsersController@dashboard');

// Products routes...
Route::get('/', 'ShopController@shop');
Route::get('viewProduct/{id}', 'ShopController@viewProduct');

// Admin routes...
Route::get('products/data', ['as' => 'products.data', 'uses' => 'Admin\ProductsController@data']);
Route::delete('products/deleteImage', 'Admin\ProductsController@deleteImage');
Route::post('products/changeThumb', 'Admin\ProductsController@changeThumb');

Route::resource('products', 'Admin\ProductsController');

Route::resource('cart', 'CartController');

//Route::get('paypal', 'PaypalController@index');
Route::post('paypal', 'PaypalController@getCheckout');
Route::get('getDone', 'PaypalController@getDone');
Route::get('getCancel', 'PaypalController@getCancel');


Route::post('cart/updateCount', 'CartController@updateCount');
Route::get('orders', 'UsersController@orders');



