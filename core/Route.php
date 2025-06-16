<?php

/**
 * Route Class - Laravel Style Routing
 * 
 * Class untuk menangani routing sistem
 * Mirip dengan Laravel routing tapi lebih sederhana
 */

class Route
{
    private static $routes = [];
    
    /**
     * Register GET route
     */
    public static function get($path, $action)
    {
        self::$routes['GET'][$path] = $action;
    }
    
    /**
     * Register POST route
     */
    public static function post($path, $action)
    {
        self::$routes['POST'][$path] = $action;
    }
    
    /**
     * Register PUT route
     */
    public static function put($path, $action)
    {
        self::$routes['PUT'][$path] = $action;
    }
    
    /**
     * Register DELETE route
     */
    public static function delete($path, $action)
    {
        self::$routes['DELETE'][$path] = $action;
    }
    
    /**
     * Register route untuk semua HTTP methods
     */
    public static function any($path, $action)
    {
        self::$routes['GET'][$path] = $action;
        self::$routes['POST'][$path] = $action;
        self::$routes['PUT'][$path] = $action;
        self::$routes['DELETE'][$path] = $action;
    }
    
    /**
     * Resolve dan jalankan route
     */
    public static function resolve()
    {
        // Ambil HTTP method - default ke GET jika tidak ada
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        
        // Ambil URL yang diminta - default ke '/' jika tidak ada
        $request_uri = $_SERVER['REQUEST_URI'] ?? '/';
        
        // Ambil base path
        $script_name = $_SERVER['SCRIPT_NAME'] ?? '/index.php';
        $base_path = dirname($script_name);
        
        // Hapus base path dari request URI
        if ($base_path !== '/') {
            $path = str_replace($base_path, '', $request_uri);
        } else {
            $path = $request_uri;
        }
        
        // Parse URL untuk menghilangkan query string
        $path = parse_url($path, PHP_URL_PATH);
        
        // Hapus slash di awal dan akhir
        $path = trim($path, '/');
        
        // Jika path kosong, set ke home
        if (empty($path)) {
            $path = '/';
        } else {
            $path = '/' . $path;
        }
        
        // Handle method override untuk PUT/DELETE via POST
        if ($method === 'POST' && isset($_POST['_method'])) {
            $method = strtoupper($_POST['_method']);
        }
        
        // Cari route yang cocok
        $matchedRoute = self::findMatchingRoute($method, $path);
        
        if ($matchedRoute) {
            self::executeAction($matchedRoute['action'], $matchedRoute['params']);
        } else {
            // Route tidak ditemukan - 404
            self::notFound($path, $base_path);
        }
    }
    
    /**
     * Cari route yang cocok dengan path, termasuk parameter dinamis
     */
    private static function findMatchingRoute($method, $path)
    {
        if (!isset(self::$routes[$method])) {
            return null;
        }
        
        // Cek exact match dulu
        if (isset(self::$routes[$method][$path])) {
            return [
                'action' => self::$routes[$method][$path],
                'params' => []
            ];
        }
        
        // Cek pattern match untuk parameter dinamis
        foreach (self::$routes[$method] as $routePath => $action) {
            $params = self::matchRoute($routePath, $path);
            if ($params !== false) {
                return [
                    'action' => $action,
                    'params' => $params
                ];
            }
        }
        
        return null;
    }
    
    /**
     * Match route dengan parameter dinamis seperti {id}
     */
    private static function matchRoute($routePath, $requestPath)
    {
        // Convert route pattern ke regex
        $pattern = preg_replace('/\{([^}]+)\}/', '([^/]+)', $routePath);
        $pattern = '#^' . $pattern . '$#';
        
        if (preg_match($pattern, $requestPath, $matches)) {
            // Hapus full match dari hasil
            array_shift($matches);
            
            // Extract parameter names dari route path
            preg_match_all('/\{([^}]+)\}/', $routePath, $paramNames);
            $paramNames = $paramNames[1];
            
            // Combine parameter names dengan values
            $params = [];
            foreach ($paramNames as $index => $name) {
                $params[$name] = $matches[$index] ?? null;
            }
            
            return $params;
        }
        
        return false;
    }
    
    /**
     * Execute action (controller@method atau closure)
     */
    private static function executeAction($action, $params = [])
    {
        if (is_string($action)) {
            // Format: 'ControllerName@methodName'
            if (strpos($action, '@') !== false) {
                list($controller, $method) = explode('@', $action);
                
                if (class_exists($controller)) {
                    $controllerInstance = new $controller();
                    if (method_exists($controllerInstance, $method)) {
                        // Pass parameters ke method
                        $reflection = new ReflectionMethod($controllerInstance, $method);
                        $methodParams = $reflection->getParameters();
                        
                        $args = [];
                        foreach ($methodParams as $param) {
                            $paramName = $param->getName();
                            if (isset($params[$paramName])) {
                                $args[] = $params[$paramName];
                            } elseif ($param->isDefaultValueAvailable()) {
                                $args[] = $param->getDefaultValue();
                            } else {
                                $args[] = null;
                            }
                        }
                        
                        call_user_func_array([$controllerInstance, $method], $args);
                    } else {
                        self::error("Method $method tidak ditemukan di $controller");
                    }
                } else {
                    self::error("Controller $controller tidak ditemukan");
                }
            }
        } elseif (is_callable($action)) {
            // Closure/function
            $action($params);
        }
    }
    
    /**
     * Handle 404 - Route tidak ditemukan
     */
    private static function notFound($path, $base_path)
    {
        http_response_code(404);
        echo "<h1>404 - Halaman Tidak Ditemukan</h1>";
        echo "<p>Halaman yang Anda cari tidak tersedia.</p>";
        echo "<p>Path yang diminta: <code>$path</code></p>";
        echo "<a href='$base_path/'>Kembali ke Beranda</a>";
    }
    
    /**
     * Handle error
     */
    private static function error($message)
    {
        http_response_code(500);
        echo "<h1>500 - Server Error</h1>";
        echo "<p>$message</p>";
        echo "<a href='javascript:history.back()'>Kembali</a>";
    }
    
    /**
     * Get all registered routes (untuk debugging)
     */
    public static function getRoutes()
    {
        return self::$routes;
    }
    
    /**
     * Clear all routes (untuk testing)
     */
    public static function clearRoutes()
    {
        self::$routes = [];
    }
}

?> 