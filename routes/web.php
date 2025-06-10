<?php

// Include autoloader
require_once 'core/Autoloader.php';

// Register autoloader
Autoloader::register();

// Load core classes
Autoloader::loadCore();

require_once 'routes/web/landings.php';
require_once 'routes/web/auth.php';
require_once 'routes/web/debug.php';
require_once 'routes/web/dashboard.php';
require_once 'routes/web/categories.php';
require_once 'routes/web/products.php';
require_once 'routes/web/carts.php';

// Checkout routes
Route::get('/checkout', 'CheckoutController@index');
Route::post('/checkout', 'CheckoutController@store');

// Transaction routes
Route::get('/transactions', 'TransactionController@index');
Route::get('/transactions/{id}', 'TransactionController@show');
Route::post('/transactions/{id}/update-status', 'OrderController@updateStatus');

// Order routes
Route::get('/orders', 'OrderController@index');
Route::get('/orders/my-order', 'OrderController@myOrder');
Route::get('/orders/export', 'OrderController@export');
Route::get('/orders/{id}', 'OrderController@show');

// User routes - CRUD lengkap
Route::get('/users', 'UserController@index');
Route::get('/users/create', 'UserController@create');
Route::post('/users', 'UserController@store');
Route::get('/users/{id}', 'UserController@show');
Route::get('/users/{id}/edit', 'UserController@edit');
Route::put('/users/{id}', 'UserController@update');
Route::delete('/users/{id}', 'UserController@destroy');

// Jalankan routing
Route::resolve();

?>
