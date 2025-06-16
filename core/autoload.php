<?php

/**
 * Autoload Core Classes
 * 
 * File ini akan memuat semua core classes yang diperlukan
 * Sehingga tidak perlu require manual di setiap file
 */

// Core classes
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Model.php';
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/Request.php';
require_once __DIR__ . '/Storage.php';
require_once __DIR__ . '/Paginator.php';
require_once __DIR__ . '/Helpers.php';

// Set error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?> 