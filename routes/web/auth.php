<?php

// Route untuk authentication
Route::get('/login', 'AuthController@login');
Route::post('/login', 'AuthController@login');

Route::get('/register', 'AuthController@register');
Route::post('/register', 'AuthController@register');

Route::get('/forgot-password', 'AuthController@forgotPassword');
Route::post('/forgot-password', 'AuthController@forgotPassword');

Route::any('/logout', 'AuthController@logout');

?>