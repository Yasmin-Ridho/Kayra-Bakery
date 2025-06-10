<?php

/**
 * Category Routes
 * 
 * Routes untuk manajemen kategori
 */

Route::get('/categories', 'CategoryController@index');
Route::get('/categories/create', 'CategoryController@create');
Route::post('/categories', 'CategoryController@store');
Route::get('/categories/{id}', 'CategoryController@show');
Route::get('/categories/{id}/edit', 'CategoryController@edit');
Route::put('/categories/{id}', 'CategoryController@update');
Route::delete('/categories/{id}', 'CategoryController@delete');

?>