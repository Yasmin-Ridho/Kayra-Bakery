<?php

/**
 * Dashboard Routes
 * 
 * Routes untuk halaman dashboard dan fitur-fitur terkait
 */

// Dashboard utama
Route::get('/dashboard', 'DashboardController@index');

// Dashboard analytics
Route::get('/dashboard/analytics', 'DashboardController@analytics');

// Dashboard settings
Route::get('/dashboard/settings', 'DashboardController@settings');

// Redirect dari /admin ke /dashboard
Route::get('/admin', function() {
    $baseUrl = dirname($_SERVER['SCRIPT_NAME']);
    $baseUrl = $baseUrl === '/' ? '' : $baseUrl;
    header('Location: ' . $baseUrl . '/dashboard');
    exit();
});

?>