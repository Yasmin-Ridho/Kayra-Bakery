<?php

// Route untuk debugging
Route::get('/info', 'DebugController@info');
Route::get('/route-list', 'DebugController@routeList');
Route::get('/db-test', 'DebugController@dbTest');
Route::get('/user-test', 'DebugController@userTest');

?>