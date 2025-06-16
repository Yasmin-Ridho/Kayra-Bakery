<?php

/**
 * Helper Functions
 * 
 * Kumpulan helper functions untuk aplikasi
 * Mirip dengan Laravel helpers
 */

/**
 * Helper function untuk mendapatkan environment variable
 */
function env($key, $default = null)
{
    // Load .env file jika belum di-load
    static $envLoaded = false;
    
    if (!$envLoaded) {
        // Coba .env dulu, jika tidak ada coba config.env
        $envFiles = [
            __DIR__ . '/../.env',
            __DIR__ . '/../config.env'
        ];
        
        foreach ($envFiles as $envFile) {
            if (file_exists($envFile)) {
                $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                
                foreach ($lines as $line) {
                    // Skip komentar
                    if (strpos(trim($line), '#') === 0) {
                        continue;
                    }
                    
                    // Parse key=value
                    if (strpos($line, '=') !== false) {
                        list($envKey, $value) = explode('=', $line, 2);
                        $envKey = trim($envKey);
                        $value = trim($value);
                        
                        // Hapus quotes jika ada
                        $value = trim($value, '"\'');
                        
                        // Set environment variable
                        $_ENV[$envKey] = $value;
                        putenv("$envKey=$value");
                    }
                }
                break; // Hanya load file pertama yang ditemukan
            }
        }
        
        $envLoaded = true;
    }
    
    return $_ENV[$key] ?? getenv($key) ?: $default;
}

/**
 * Helper function untuk database path
 */
function database_path($path = '')
{
    return __DIR__ . '/../database/' . $path;
}

/**
 * Helper function untuk config path
 */
function config_path($path = '')
{
    return __DIR__ . '/../config/' . $path;
}

/**
 * Helper function untuk app path
 */
function app_path($path = '')
{
    return __DIR__ . '/../app/' . $path;
}

/**
 * Helper function untuk base path
 */
function base_path($path = '')
{
    return __DIR__ . '/../' . $path;
}

/**
 * Helper function untuk mendapatkan konfigurasi
 */
function config($key, $default = null)
{
    static $configs = [];
    
    // Parse key seperti 'database.default' atau 'database.connections.mysql'
    $keys = explode('.', $key);
    $configFile = array_shift($keys);
    
    // Load config file jika belum di-load
    if (!isset($configs[$configFile])) {
        $configPath = config_path($configFile . '.php');
        
        if (file_exists($configPath)) {
            $configs[$configFile] = require $configPath;
        } else {
            return $default;
        }
    }
    
    // Navigate through nested array
    $value = $configs[$configFile];
    
    foreach ($keys as $nestedKey) {
        if (is_array($value) && isset($value[$nestedKey])) {
            $value = $value[$nestedKey];
        } else {
            return $default;
        }
    }
    
    return $value;
}

/**
 * Helper function untuk mendapatkan database connection
 */
function DB($connection = null)
{
    return Database::connection($connection);
}

/**
 * Helper function untuk debugging
 */
function dd(...$vars)
{
    echo "<pre>";
    foreach ($vars as $var) {
        var_dump($var);
    }
    echo "</pre>";
    die();
}

/**
 * Helper function untuk dump tanpa die
 */
function dump(...$vars)
{
    echo "<pre>";
    foreach ($vars as $var) {
        var_dump($var);
    }
    echo "</pre>";
}

/**
 * Get base URL aplikasi
 */
if (!function_exists('getBaseUrl')) {
    function getBaseUrl() {
        $script_name = $_SERVER['SCRIPT_NAME'];
        $base_path = dirname($script_name);
        return $base_path === '/' ? '' : $base_path;
    }
}

/**
 * Get current URL
 */
if (!function_exists('getCurrentUrl')) {
    function getCurrentUrl() {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
        return $protocol . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    }
}

/**
 * Redirect helper
 */
if (!function_exists('redirect')) {
    function redirect($url, $permanent = false) {
        $statusCode = $permanent ? 301 : 302;
        http_response_code($statusCode);
        header('Location: ' . $url);
        exit();
    }
}

/**
 * Redirect to route helper
 */
if (!function_exists('redirectToRoute')) {
    function redirectToRoute($route, $permanent = false) {
        $url = getBaseUrl() . $route;
        redirect($url, $permanent);
    }
}

/**
 * Check if current path matches
 */
if (!function_exists('isActiveRoute')) {
    function isActiveRoute($route) {
        $currentPath = $_SERVER['REQUEST_URI'];
        $currentPath = parse_url($currentPath, PHP_URL_PATH);
        $baseUrl = getBaseUrl();
        $currentPath = str_replace($baseUrl, '', $currentPath);
        
        return $currentPath === $route || strpos($currentPath, $route) === 0;
    }
}

/**
 * Format currency (Rupiah)
 */
if (!function_exists('formatCurrency')) {
    function formatCurrency($amount) {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
}

/**
 * Format date Indonesian
 */
if (!function_exists('formatDateIndonesian')) {
    function formatDateIndonesian($date, $format = 'd F Y') {
        $months = [
            1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];
        
        $days = [
            'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'
        ];
        
        $timestamp = is_string($date) ? strtotime($date) : $date;
        $formatted = date($format, $timestamp);
        
        // Replace English month names with Indonesian
        foreach ($months as $num => $month) {
            $formatted = str_replace(date('F', mktime(0, 0, 0, $num, 1)), $month, $formatted);
        }
        
        // Replace English day names with Indonesian
        foreach ($days as $eng => $ind) {
            $formatted = str_replace($eng, $ind, $formatted);
        }
        
        return $formatted;
    }
}

/**
 * Sanitize input
 */
if (!function_exists('sanitizeInput')) {
    function sanitizeInput($input) {
        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
    }
}

/**
 * Generate random string
 */
if (!function_exists('generateRandomString')) {
    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}

/**
 * Check if user is logged in
 */
if (!function_exists('isLoggedIn')) {
    function isLoggedIn() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }
}

/**
 * Get current user data
 */
if (!function_exists('getCurrentUser')) {
    function getCurrentUser() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isLoggedIn()) {
            return null;
        }
        
        return [
            'id' => $_SESSION['user_id'] ?? null,
            'name' => $_SESSION['user_name'] ?? null,
            'email' => $_SESSION['user_email'] ?? null,
            'role' => $_SESSION['user_role'] ?? null
        ];
    }
}

/**
 * Flash message helpers
 */
if (!function_exists('setFlashMessage')) {
    function setFlashMessage($type, $message) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION[$type] = $message;
    }
}

if (!function_exists('getFlashMessage')) {
    function getFlashMessage($type) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        $message = $_SESSION[$type] ?? null;
        if ($message) {
            unset($_SESSION[$type]);
        }
        return $message;
    }
}

/**
 * Asset helper
 */
if (!function_exists('asset')) {
    function asset($path) {
        return getBaseUrl() . '/assets/' . ltrim($path, '/');
    }
}

/**
 * URL helper
 */
if (!function_exists('url')) {
    function url($path = '') {
        return getBaseUrl() . '/' . ltrim($path, '/');
    }
}

/**
 * Validation error helpers
 */
if (!function_exists('hasValidationError')) {
    function hasValidationError($field) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $errors = isset($_SESSION['validation_errors']) ? $_SESSION['validation_errors'] : [];
        return isset($errors[$field]);
    }
}

if (!function_exists('getValidationError')) {
    function getValidationError($field) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $errors = isset($_SESSION['validation_errors']) ? $_SESSION['validation_errors'] : [];
        return isset($errors[$field]) ? $errors[$field][0] : '';
    }
}

if (!function_exists('getAllValidationErrors')) {
    function getAllValidationErrors() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        return isset($_SESSION['validation_errors']) ? $_SESSION['validation_errors'] : [];
    }
}

if (!function_exists('hasValidationErrors')) {
    function hasValidationErrors() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $errors = isset($_SESSION['validation_errors']) ? $_SESSION['validation_errors'] : [];
        return !empty($errors);
    }
}

if (!function_exists('displayValidationErrors')) {
    function displayValidationErrors($field = null) {
        if ($field) {
            // Display errors for specific field
            if (hasValidationError($field)) {
                $error = getValidationError($field);
                echo "<div class='alert alert-danger'>{$error}</div>";
            }
        } else {
            // Display all errors
            $errors = getAllValidationErrors();
            if (!empty($errors)) {
                echo "<div class='alert alert-danger'>";
                echo "<ul class='mb-0'>";
                foreach ($errors as $fieldErrors) {
                    foreach ($fieldErrors as $error) {
                        echo "<li>{$error}</li>";
                    }
                }
                echo "</ul>";
                echo "</div>";
            }
        }
    }
}

/**
 * Set validation error for specific field
 */
if (!function_exists('setValidationError')) {
    function setValidationError($field, $message) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['validation_errors'])) {
            $_SESSION['validation_errors'] = [];
        }
        
        if (!isset($_SESSION['validation_errors'][$field])) {
            $_SESSION['validation_errors'][$field] = [];
        }
        
        $_SESSION['validation_errors'][$field][] = $message;
    }
}

/**
 * Request helper function
 */
if (!function_exists('request')) {
    function request() {
        return Request::getInstance();
    }
}

/**
 * File upload request helpers
 */
if (!function_exists('hasFile')) {
    function hasFile($field) {
        return isset($_FILES[$field]) && $_FILES[$field]['error'] !== UPLOAD_ERR_NO_FILE;
    }
}

if (!function_exists('getUploadedFile')) {
    function getUploadedFile($field) {
        if (!hasFile($field)) {
            return null;
        }
        return $_FILES[$field];
    }
}

if (!function_exists('validateUploadedFile')) {
    function validateUploadedFile($field, $rules = []) {
        if (!hasFile($field)) {
            return false;
        }

        $file = $_FILES[$field];
        $errors = [];

        // Check file upload errors
        if ($file['error'] !== UPLOAD_ERR_OK) {
            switch ($file['error']) {
                case UPLOAD_ERR_INI_SIZE:
                    $errors[] = 'File terlalu besar (melebihi upload_max_filesize di php.ini)';
                    break;
                case UPLOAD_ERR_FORM_SIZE:
                    $errors[] = 'File terlalu besar (melebihi MAX_FILE_SIZE di form)';
                    break;
                case UPLOAD_ERR_PARTIAL:
                    $errors[] = 'File hanya terupload sebagian';
                    break;
                case UPLOAD_ERR_NO_TMP_DIR:
                    $errors[] = 'Tidak ada temporary directory';
                    break;
                case UPLOAD_ERR_CANT_WRITE:
                    $errors[] = 'Gagal menulis file ke disk';
                    break;
                default:
                    $errors[] = 'Terjadi error saat upload file';
            }
            return false;
        }

        // Validate file type if specified
        if (isset($rules['mimes'])) {
            $allowedTypes = explode(',', $rules['mimes']);
            $fileType = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            if (!in_array($fileType, $allowedTypes)) {
                $errors[] = 'Tipe file tidak diizinkan';
                return false;
            }
        }

        // Validate file size if specified (in KB)
        if (isset($rules['max_size'])) {
            $maxSize = $rules['max_size'] * 1024; // Convert to bytes
            if ($file['size'] > $maxSize) {
                $errors[] = 'Ukuran file terlalu besar (maksimal ' . $rules['max_size'] . 'KB)';
                return false;
            }
        }

        return empty($errors);
    }
}

/**
 * Old input helper (untuk form repopulation)
 */
if (!function_exists('old')) {
    function old($key, $default = '') {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $oldInput = isset($_SESSION['old_input']) ? $_SESSION['old_input'] : [];
        return isset($oldInput[$key]) ? htmlspecialchars($oldInput[$key], ENT_QUOTES, 'UTF-8') : $default;
    }
}

/**
 * CSRF Token helpers
 */
if (!function_exists('generateCSRFToken')) {
    function generateCSRFToken() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $token = bin2hex(random_bytes(32));
        $_SESSION['csrf_token'] = $token;
        return $token;
    }
}

if (!function_exists('getCSRFToken')) {
    function getCSRFToken() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        return $_SESSION['csrf_token'] ?? generateCSRFToken();
    }
}

if (!function_exists('verifyCSRFToken')) {
    function verifyCSRFToken($token) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }
}

if (!function_exists('validateCsrfToken')) {
    function validateCsrfToken() {
        $token = $_POST['_token'] ?? $_GET['_token'] ?? '';
        return verifyCSRFToken($token);
    }
}

if (!function_exists('csrfField')) {
    function csrfField() {
        $token = getCSRFToken();
        return "<input type='hidden' name='_token' value='{$token}'>";
    }
}

/**
 * Method spoofing helper (untuk PUT, PATCH, DELETE)
 */
if (!function_exists('methodField')) {
    function methodField($method) {
        return "<input type='hidden' name='_method' value='{$method}'>";
    }
}

/**
 * File upload helpers
 */
if (!function_exists('uploadPath')) {
    function uploadPath($path = '') {
        return base_path('public/uploads/' . ltrim($path, '/'));
    }
}

if (!function_exists('uploadUrl')) {
    function uploadUrl($path = '') {
        return url('uploads/' . ltrim($path, '/'));
    }
}

/**
 * String helpers
 */
if (!function_exists('str_slug')) {
    function str_slug($string, $separator = '-') {
        // Convert to lowercase
        $string = strtolower($string);
        
        // Replace spaces and special characters
        $string = preg_replace('/[^a-z0-9\-]/', $separator, $string);
        
        // Remove multiple separators
        $string = preg_replace('/[' . preg_quote($separator) . ']+/', $separator, $string);
        
        // Trim separators from ends
        return trim($string, $separator);
    }
}

if (!function_exists('str_limit')) {
    function str_limit($string, $limit = 100, $end = '...') {
        if (strlen($string) <= $limit) {
            return $string;
        }
        
        return substr($string, 0, $limit) . $end;
    }
}

/**
 * Array helpers
 */
if (!function_exists('array_get')) {
    function array_get($array, $key, $default = null) {
        if (is_null($key)) {
            return $array;
        }
        
        if (isset($array[$key])) {
            return $array[$key];
        }
        
        // Support dot notation
        foreach (explode('.', $key) as $segment) {
            if (is_array($array) && array_key_exists($segment, $array)) {
                $array = $array[$segment];
            } else {
                return $default;
            }
        }
        
        return $array;
    }
}

?> 