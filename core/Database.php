<?php

/**
 * Database Class - Laravel Style Database Manager
 * 
 * Class untuk menangani koneksi database menggunakan konfigurasi Laravel-style
 * Menggunakan config/database.php yang return array
 */

class Database
{
    private static $instance = null;
    private static $connections = [];
    private static $config = null;
    
    /**
     * Get database configuration
     */
    private static function getConfig()
    {
        if (self::$config === null) {
            self::$config = require 'config/database.php';
        }
        
        return self::$config;
    }
    
    /**
     * Get database connection
     */
    public static function connection($name = null)
    {
        $config = self::getConfig();
        
        // Gunakan default connection jika tidak disebutkan
        if ($name === null) {
            $name = $config['default'];
        }
        
        // Return existing connection jika sudah ada
        if (isset(self::$connections[$name])) {
            return self::$connections[$name];
        }
        
        // Buat koneksi baru
        if (!isset($config['connections'][$name])) {
            throw new Exception("Database connection '$name' tidak ditemukan dalam konfigurasi");
        }
        
        $connectionConfig = $config['connections'][$name];
        
        try {
            $pdo = self::createConnection($connectionConfig, $config);
            self::$connections[$name] = $pdo;
            
            return $pdo;
        } catch (PDOException $e) {
            throw new Exception("Koneksi database '$name' gagal: " . $e->getMessage());
        }
    }
    
    /**
     * Create PDO connection
     */
    private static function createConnection($config, $globalConfig)
    {
        $driver = $config['driver'];
        
        switch ($driver) {
            case 'mysql':
                $dsn = sprintf(
                    "mysql:host=%s;port=%s;dbname=%s;charset=%s",
                    $config['host'],
                    $config['port'],
                    $config['database'],
                    $config['charset']
                );
                break;
                
            case 'sqlite':
                $dsn = "sqlite:" . $config['database'];
                break;
                
            default:
                throw new Exception("Database driver '$driver' tidak didukung");
        }
        
        // Buat PDO connection
        $pdo = new PDO(
            $dsn,
            $config['username'] ?? null,
            $config['password'] ?? null,
            $globalConfig['options'] ?? []
        );
        
        // Set timezone jika ada (untuk MySQL)
        if (isset($globalConfig['timezone']) && $driver === 'mysql') {
            try {
                // Coba gunakan timezone name dulu
                $timezone = $globalConfig['timezone'];
                $pdo->exec("SET time_zone = '$timezone'");
            } catch (PDOException $e) {
                // Jika gagal, gunakan offset UTC
                try {
                    // Konversi timezone ke offset UTC
                    $offset = self::getTimezoneOffset($globalConfig['timezone']);
                    $pdo->exec("SET time_zone = '$offset'");
                } catch (PDOException $e2) {
                    // Jika masih gagal, gunakan default system timezone
                    $pdo->exec("SET time_zone = SYSTEM");
                }
            }
        }
        
        return $pdo;
    }
    
    /**
     * Convert timezone name to UTC offset
     */
    private static function getTimezoneOffset($timezone)
    {
        try {
            $tz = new DateTimeZone($timezone);
            $now = new DateTime('now', $tz);
            $offset = $now->getOffset();
            
            // Convert seconds to hours:minutes format
            $hours = intval($offset / 3600);
            $minutes = abs(($offset % 3600) / 60);
            
            return sprintf('%+03d:%02d', $hours, $minutes);
        } catch (Exception $e) {
            // Default ke WIB (+07:00) jika gagal
            return '+07:00';
        }
    }
    
    /**
     * Get default connection (shorthand)
     */
    public static function getConnection()
    {
        return self::connection();
    }
    
    /**
     * Test database connection
     */
    public static function testConnection($name = null)
    {
        try {
            $pdo = self::connection($name);
            $stmt = $pdo->query('SELECT 1');
            
            if ($stmt !== false) {
                // Test timezone setting
                $timezoneStmt = $pdo->query('SELECT @@session.time_zone as timezone');
                $timezone = $timezoneStmt->fetch()['timezone'];
                
                return [
                    'success' => true,
                    'message' => 'Koneksi database berhasil',
                    'timezone' => $timezone
                ];
            }
            
            return [
                'success' => false,
                'message' => 'Gagal menjalankan query test'
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
    
    /**
     * Get all connections info
     */
    public static function getConnectionsInfo()
    {
        $config = self::getConfig();
        $info = [];
        
        foreach ($config['connections'] as $name => $connection) {
            $info[$name] = [
                'driver' => $connection['driver'],
                'host' => $connection['host'] ?? 'N/A',
                'database' => $connection['database'] ?? 'N/A',
                'connected' => isset(self::$connections[$name])
            ];
        }
        
        return $info;
    }
    
    /**
     * Close all connections
     */
    public static function closeAllConnections()
    {
        self::$connections = [];
    }
    
    /**
     * Magic method untuk memanggil method PDO secara langsung
     */
    public static function __callStatic($method, $args)
    {
        $pdo = self::getConnection();
        
        if (method_exists($pdo, $method)) {
            return call_user_func_array([$pdo, $method], $args);
        }
        
        throw new Exception("Method '$method' tidak ditemukan di PDO");
    }
}

?> 