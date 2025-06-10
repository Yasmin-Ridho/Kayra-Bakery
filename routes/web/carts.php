<?php

/**
 * Cart Routes
 * 
 * Routes untuk menangani cart/keranjang belanja
 */

// Cart routes
Route::get('/carts', 'CartController@index');
Route::get('/carts/create', 'CartController@create');
Route::post('/carts', 'CartController@store');
Route::put('/carts/{id}', 'CartController@update');
Route::delete('/carts/{id}', 'CartController@delete');
Route::delete('/carts', 'CartController@clear');

// AJAX routes
Route::get('/api/carts/count', 'CartController@count');
Route::get('/api/carts/items', 'CartController@items');
Route::post('/api/carts/add', 'CartController@addAjax');

// Additional AJAX routes for frontend
Route::post('/carts/add', 'CartController@addAjax');
Route::get('/carts/count', 'CartController@count');

?> 