<?php

/**
 * Database Configuration
 * 
 * Konfigurasi database
 * Return array konfigurasi yang bisa digunakan oleh aplikasi
 */

return [
    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Nama koneksi database default yang akan digunakan
    |
    */
    'default' => env('DB_CONNECTION', 'mysql'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Konfigurasi untuk berbagai koneksi database
    |
    */
    'connections' => [
        'mysql' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'kayra_bakery'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => env('DB_CHARSET', 'utf8mb4'),
            'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],

        'sqlite' => [
            'driver' => 'sqlite',
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | Nama tabel untuk menyimpan informasi migration
    |
    */
    'migrations' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Redis Databases (Optional)
    |--------------------------------------------------------------------------
    |
    | Konfigurasi Redis jika diperlukan untuk caching
    |
    */
    'redis' => [
        'client' => env('REDIS_CLIENT', 'phpredis'),
        'default' => [
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            'database' => env('REDIS_DB', 0),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Database Options
    |--------------------------------------------------------------------------
    |
    | Opsi tambahan untuk PDO
    |
    */
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4",
    ],

    /*
    |--------------------------------------------------------------------------
    | Timezone
    |--------------------------------------------------------------------------
    |
    | Timezone untuk database
    | Gunakan offset UTC untuk kompatibilitas yang lebih baik
    | Asia/Jakarta = +07:00
    |
    */
    'timezone' => env('DB_TIMEZONE', '+07:00'),
];
