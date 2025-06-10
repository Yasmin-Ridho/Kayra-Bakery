<?php

/**
 * Product Routes
 * 
 * Routes untuk halaman produk
 */

// Landing products route (untuk user)
Route::get('/products', 'ProductController@landing');

// Admin product routes
Route::get('/products/admin', 'ProductController@index');
Route::get('/products/create', 'ProductController@create');
Route::post('/products', 'ProductController@store');
Route::get('/products/{id}', 'ProductController@show');
Route::get('/products/{id}/edit', 'ProductController@edit');
Route::put('/products/{id}', 'ProductController@update');
Route::delete('/products/{id}', 'ProductController@delete');

?> 