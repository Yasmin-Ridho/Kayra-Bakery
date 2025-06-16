<?php

/**
 * Base Controller Class
 * 
 * Controller dasar yang berisi helper methods yang bisa digunakan
 * oleh semua controller lainnya
 */

class Controller
{
    /**
     * Helper function untuk mendapatkan base URL
     */
    protected function getBaseUrl()
    {
        $script_name = $_SERVER['SCRIPT_NAME'];
        $base_path = dirname($script_name);
        return $base_path === '/' ? '' : $base_path;
    }
    
    /**
     * Redirect ke URL tertentu
     */
    protected function redirect($url, $permanent = false)
    {
        $statusCode = $permanent ? 301 : 302;
        http_response_code($statusCode);
        header('Location: ' . $url);
        exit();
    }
    
    /**
     * Redirect ke route dengan base URL
     */
    protected function redirectToRoute($route, $permanent = false)
    {
        $url = $this->getBaseUrl() . $route;
        $this->redirect($url, $permanent);
    }
    
    /**
     * Redirect kembali ke halaman sebelumnya
     */
    protected function redirectBack()
    {
        $referer = $_SERVER['HTTP_REFERER'] ?? $this->getBaseUrl() . '/';
        $this->redirect($referer);
    }
    
    /**
     * Set flash message untuk session
     */
    protected function setFlashMessage($type, $message)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION[$type] = $message;
    }
    
    /**
     * Set success message
     */
    protected function setSuccessMessage($message)
    {
        $this->setFlashMessage('success', $message);
    }
    
    /**
     * Set error message
     */
    protected function setErrorMessage($message)
    {
        $this->setFlashMessage('error', $message);
    }
    
    /**
     * Set info message
     */
    protected function setInfoMessage($message)
    {
        $this->setFlashMessage('info', $message);
    }
    
    /**
     * Set warning message
     */
    protected function setWarningMessage($message)
    {
        $this->setFlashMessage('warning', $message);
    }
    
    /**
     * Get flash message dan hapus dari session
     */
    protected function getFlashMessage($type)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        $message = $_SESSION[$type] ?? null;
        if ($message) {
            unset($_SESSION[$type]);
        }
        return $message;
    }
    
    /**
     * Check apakah request adalah POST
     */
    protected function isPost()
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }
    
    /**
     * Check apakah request adalah GET
     */
    protected function isGet()
    {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }
    
    /**
     * Check apakah request adalah AJAX
     */
    protected function isAjax()
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }
    
    /**
     * Get input dari POST/GET dengan default value
     */
    protected function input($key, $default = null)
    {
        return $_POST[$key] ?? $_GET[$key] ?? $default;
    }
    
    /**
     * Get input dari POST dengan default value
     */
    protected function post($key, $default = null)
    {
        return $_POST[$key] ?? $default;
    }
    
    /**
     * Get input dari GET dengan default value
     */
    protected function get($key, $default = null)
    {
        return $_GET[$key] ?? $default;
    }
    
    /**
     * Validate required fields
     */
    protected function validateRequired($fields, $data)
    {
        $errors = [];
        
        foreach ($fields as $field => $label) {
            if (empty($data[$field])) {
                $errors[] = $label . ' harus diisi!';
            }
        }
        
        return $errors;
    }
    
    /**
     * Validate email format
     */
    protected function validateEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
    
    /**
     * Sanitize input string
     */
    protected function sanitize($input)
    {
        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
    }
    
    /**
     * Return JSON response
     */
    protected function jsonResponse($data, $statusCode = 200)
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }
    
    /**
     * Return success JSON response
     */
    protected function jsonSuccess($message = 'Success', $data = null)
    {
        $response = [
            'success' => true,
            'message' => $message
        ];
        
        if ($data !== null) {
            $response['data'] = $data;
        }
        
        $this->jsonResponse($response);
    }
    
    /**
     * Return error JSON response
     */
    protected function jsonError($message = 'Error', $statusCode = 400)
    {
        $this->jsonResponse([
            'success' => false,
            'message' => $message
        ], $statusCode);
    }
    
    /**
     * Load view dengan data
     */
    protected function view($viewPath, $data = [])
    {
        // Extract data menjadi variables
        extract($data);
        
        // Include view file
        $viewFile = 'app/views/' . $viewPath . '.php';
        if (file_exists($viewFile)) {
            include $viewFile;
        } else {
            throw new Exception("View file not found: " . $viewFile);
        }
    }
    
    /**
     * Load layout dengan content
     */
    protected function layout($layoutPath, $content, $data = [])
    {
        // Set content ke data
        $data['content'] = $content;
        
        // Extract data menjadi variables
        extract($data);
        
        // Include layout file
        $layoutFile = 'app/views/layouts/' . $layoutPath . '.php';
        if (file_exists($layoutFile)) {
            include $layoutFile;
        } else {
            throw new Exception("Layout file not found: " . $layoutFile);
        }
    }
    
    /**
     * Get current URL
     */
    protected function getCurrentUrl()
    {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
        return $protocol . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    }
    
    /**
     * Get client IP address
     */
    protected function getClientIp()
    {
        $ipKeys = ['HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'REMOTE_ADDR'];
        
        foreach ($ipKeys as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip);
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                        return $ip;
                    }
                }
            }
        }
        
        return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    }
    
    /**
     * Log activity atau error
     */
    protected function log($message, $level = 'info')
    {
        $timestamp = date('Y-m-d H:i:s');
        $logMessage = "[{$timestamp}] [{$level}] {$message}" . PHP_EOL;
        
        // Log ke file atau error_log
        error_log($logMessage);
    }
}

?> 