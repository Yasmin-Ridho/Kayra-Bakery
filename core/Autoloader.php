<?php

/**
 * Autoloader - Simple Class Autoloader
 * 
 * Autoloader sederhana untuk memuat class-class core
 * 
 */

class Autoloader
{
    /**
     * Register autoloader
     */
    public static function register()
    {
        spl_autoload_register([self::class, 'load']);
        
        // Load helpers
        self::loadHelpers();
    }
    
    /**
     * Load class file
     */
    public static function load($className)
    {
        // Daftar direktori untuk mencari class
        $directories = [
            'core/',
            'app/controllers/',
            'app/models/',
        ];
        
        foreach ($directories as $directory) {
            $file = $directory . $className . '.php';
            
            if (file_exists($file)) {
                require_once $file;
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Load semua core classes
     */
    public static function loadCore()
    {
        $coreClasses = [
            'Route',
            'Database',
            // Tambahkan class core lainnya di sini
        ];
        
        foreach ($coreClasses as $class) {
            self::load($class);
        }
    }
    
    /**
     * Load helper functions
     */
    public static function loadHelpers()
    {
        $helpersFile = 'core/Helpers.php';
        
        if (file_exists($helpersFile)) {
            require_once $helpersFile;
        }
    }
}

?> 