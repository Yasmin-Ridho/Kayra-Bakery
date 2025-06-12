<?php

require_once 'core/Controller.php';
require_once 'core/Database.php';
require_once 'app/models/User.php';

class DebugController extends Controller
{
    public function dbTest()
    {
        echo "<h1>🗄️ Database Test - Laravel Style</h1>";
    
        try {
            // Test koneksi database
            echo "<h2>📊 Database Connection Info</h2>";
            $connections = Database::getConnectionsInfo();
            echo "<pre>";
            print_r($connections);
            echo "</pre>";
            
            // Test koneksi
            echo "<h2>🔌 Connection Test</h2>";
            $testResult = Database::testConnection();
            
            if ($testResult['success']) {
                echo "<p style='color: green;'>✅ Database connection successful!</p>";
                echo "<p><strong>Timezone:</strong> " . $testResult['timezone'] . "</p>";
                
                // Test query sederhana
                try {
                $pdo = DB();
                    
                    // Query terpisah untuk kompatibilitas MariaDB
                    $timeStmt = $pdo->prepare("SELECT NOW() as current_time");
                    $timeStmt->execute();
                    $timeResult = $timeStmt->fetch();
                    
                    $dbStmt = $pdo->prepare("SELECT DATABASE() as database_name");
                    $dbStmt->execute();
                    $dbResult = $dbStmt->fetch();
                
                    echo "<p><strong>Current Time:</strong> " . $timeResult['current_time'] . "</p>";
                    echo "<p><strong>Database Name:</strong> " . ($dbResult['database_name'] ?: 'No database selected') . "</p>";
                    
                    // Test timezone query
                    $timezoneStmt = $pdo->prepare("SELECT @@session.time_zone as session_timezone, @@global.time_zone as global_timezone");
                    $timezoneStmt->execute();
                    $timezoneResult = $timezoneStmt->fetch();
                    
                    echo "<p><strong>Session Timezone:</strong> " . $timezoneResult['session_timezone'] . "</p>";
                    echo "<p><strong>Global Timezone:</strong> " . $timezoneResult['global_timezone'] . "</p>";
                    
                    // Test simple table query (jika database ada)
                    if ($dbResult['database_name']) {
                        try {
                            $tableStmt = $pdo->prepare("SHOW TABLES");
                            $tableStmt->execute();
                            $tables = $tableStmt->fetchAll(PDO::FETCH_COLUMN);
                            
                            echo "<p><strong>Tables in Database:</strong> " . (count($tables) > 0 ? implode(', ', $tables) : 'No tables found') . "</p>";
                        } catch (PDOException $e) {
                            echo "<p style='color: orange;'>⚠️ Cannot list tables: " . $e->getMessage() . "</p>";
                        }
                    }
                    
                } catch (PDOException $e) {
                    echo "<p style='color: orange;'>⚠️ Query Error: " . $e->getMessage() . "</p>";
                }
                
            } else {
                echo "<p style='color: red;'>❌ Database connection failed!</p>";
                echo "<p style='color: red;'>Error: " . $testResult['message'] . "</p>";
            }
            
            // Tampilkan konfigurasi (tanpa password)
            echo "<h2>⚙️ Database Configuration</h2>";
            echo "<p><strong>Host:</strong> " . env('DB_HOST', 'localhost') . "</p>";
            echo "<p><strong>Port:</strong> " . env('DB_PORT', '3306') . "</p>";
            echo "<p><strong>Database:</strong> " . env('DB_DATABASE', 'kayra_bakery') . "</p>";
            echo "<p><strong>Username:</strong> " . env('DB_USERNAME', 'root') . "</p>";
            echo "<p><strong>Password:</strong> " . (env('DB_PASSWORD', '') ? '***' : '(empty)') . "</p>";
            echo "<p><strong>Charset:</strong> " . env('DB_CHARSET', 'utf8mb4') . "</p>";
            echo "<p><strong>Timezone:</strong> " . env('DB_TIMEZONE', '+07:00') . "</p>";
            
        } catch (Exception $e) {
            echo "<p style='color: red;'>❌ Error: " . $e->getMessage() . "</p>";
            echo "<p>💡 Pastikan file .env sudah dibuat dan konfigurasi database sudah benar</p>";
            
            // Debug info
            echo "<h3>🔍 Debug Info</h3>";
            echo "<p><strong>Error File:</strong> " . $e->getFile() . "</p>";
            echo "<p><strong>Error Line:</strong> " . $e->getLine() . "</p>";
        }
        
        echo "<br><a href='" . $this->getBaseUrl() . "/'>Kembali ke Beranda</a>";
    }

    public function userTest()
    {
        echo "<h1>👤 User Model Test</h1>";
        
        try {
            // Test koneksi database dulu
            $testResult = Database::testConnection();
            if (!$testResult['success']) {
                echo "<p style='color: red;'>❌ Database connection failed: " . $testResult['message'] . "</p>";
                echo "<a href='" . $this->getBaseUrl() . "/'>Kembali ke Beranda</a>";
                return;
            }
            
            echo "<p style='color: green;'>✅ Database connected successfully!</p>";
            
            // Test 1: Get all users
            echo "<h2>📋 Test 1: Get All Users</h2>";
            try {
                $users = User::all();
                echo "<p><strong>Total Users:</strong> " . count($users) . "</p>";
                
                if (count($users) > 0) {
                    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
                    echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Created At</th></tr>";
                    foreach ($users as $user) {
                        echo "<tr>";
                        echo "<td>" . $user->id . "</td>";
                        echo "<td>" . $user->name . "</td>";
                        echo "<td>" . $user->email . "</td>";
                        echo "<td>" . $user->getCreatedAtFormatted() . "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<p>Tidak ada user ditemukan. Silakan buat tabel users terlebih dahulu.</p>";
                }
            } catch (Exception $e) {
                echo "<p style='color: red;'>❌ Error getting users: " . $e->getMessage() . "</p>";
            }
            
            // Test 2: Find user by ID
            echo "<h2>🔍 Test 2: Find User by ID</h2>";
            try {
                $user = User::find(1);
                if ($user) {
                    echo "<p><strong>User Found:</strong></p>";
                    echo "<ul>";
                    echo "<li><strong>ID:</strong> " . $user->id . "</li>";
                    echo "<li><strong>Name:</strong> " . $user->name . "</li>";
                    echo "<li><strong>Email:</strong> " . $user->email . "</li>";
                    echo "<li><strong>Display Name:</strong> " . $user->getDisplayName() . "</li>";
                    echo "<li><strong>Created:</strong> " . $user->getCreatedAtFormatted() . "</li>";
                    echo "</ul>";
                } else {
                    echo "<p>User dengan ID 1 tidak ditemukan.</p>";
                }
            } catch (Exception $e) {
                echo "<p style='color: red;'>❌ Error finding user: " . $e->getMessage() . "</p>";
            }
            
            // Test 3: Find user by email
            echo "<h2>📧 Test 3: Find User by Email</h2>";
            try {
                $user = User::findByEmail('admin@kayrabakery.com');
                if ($user) {
                    echo "<p><strong>User Found by Email:</strong></p>";
                    echo "<ul>";
                    echo "<li><strong>ID:</strong> " . $user->id . "</li>";
                    echo "<li><strong>Name:</strong> " . $user->name . "</li>";
                    echo "<li><strong>Email:</strong> " . $user->email . "</li>";
                    echo "</ul>";
                } else {
                    echo "<p>User dengan email 'admin@kayrabakery.com' tidak ditemukan.</p>";
                }
            } catch (Exception $e) {
                echo "<p style='color: red;'>❌ Error finding user by email: " . $e->getMessage() . "</p>";
            }
            
            // Test 4: Create new user
            echo "<h2>➕ Test 4: Create New User</h2>";
            try {
                $testEmail = 'test_' . time() . '@kayrabakery.com';
                $newUser = User::createUser([
                    'name' => 'Test User',
                    'email' => $testEmail,
                    'password' => 'testpassword123'
                ]);
                
                if ($newUser) {
                    echo "<p style='color: green;'>✅ User created successfully!</p>";
                    echo "<ul>";
                    echo "<li><strong>ID:</strong> " . $newUser->id . "</li>";
                    echo "<li><strong>Name:</strong> " . $newUser->name . "</li>";
                    echo "<li><strong>Email:</strong> " . $newUser->email . "</li>";
                    echo "<li><strong>Created:</strong> " . $newUser->getCreatedAtFormatted() . "</li>";
                    echo "</ul>";
                } else {
                    echo "<p style='color: red;'>❌ Failed to create user.</p>";
                }
            } catch (Exception $e) {
                echo "<p style='color: red;'>❌ Error creating user: " . $e->getMessage() . "</p>";
            }
            
            // Test 5: Authentication test
            echo "<h2>🔐 Test 5: Authentication Test</h2>";
            try {
                $authUser = User::authenticate('admin@kayrabakery.com', 'password');
                if ($authUser) {
                    echo "<p style='color: green;'>✅ Authentication successful!</p>";
                    echo "<p><strong>Authenticated User:</strong> " . $authUser->getDisplayName() . "</p>";
                } else {
                    echo "<p style='color: orange;'>⚠️ Authentication failed or user not found.</p>";
                }
            } catch (Exception $e) {
                echo "<p style='color: red;'>❌ Error during authentication: " . $e->getMessage() . "</p>";
            }
            
            // Test 6: Model to Array/JSON
            echo "<h2>📄 Test 6: Model Serialization</h2>";
            try {
                $user = User::find(1);
                if ($user) {
                    echo "<p><strong>User as Array:</strong></p>";
                    echo "<pre>";
                    print_r($user->toArray());
                    echo "</pre>";
                    
                    echo "<p><strong>User as JSON:</strong></p>";
                    echo "<pre>";
                    echo $user->toJson();
                    echo "</pre>";
                }
            } catch (Exception $e) {
                echo "<p style='color: red;'>❌ Error serializing user: " . $e->getMessage() . "</p>";
            }
            
        } catch (Exception $e) {
            echo "<p style='color: red;'>❌ General Error: " . $e->getMessage() . "</p>";
            echo "<p><strong>File:</strong> " . $e->getFile() . "</p>";
            echo "<p><strong>Line:</strong> " . $e->getLine() . "</p>";
        }
        
        echo "<br><br>";
        echo "<p><strong>💡 Tips:</strong></p>";
        echo "<ul>";
        echo "<li>Pastikan tabel 'users' sudah dibuat di database</li>";
        echo "<li>Jalankan SQL dari file 'database/create_users_table.sql'</li>";
        echo "<li>Password default untuk sample data adalah 'password'</li>";
        echo "</ul>";
        
        echo "<br><a href='" . $this->getBaseUrl() . "/'>Kembali ke Beranda</a> | <a href='" . $this->getBaseUrl() . "/db-test'>Test Database</a>";
    }

    public function routeList()
    {
        echo "<h1>🛣️ Registered Routes</h1>";
        echo "<pre>";
        print_r(Route::getRoutes());
        echo "</pre>";
        echo "<a href='" . $this->getBaseUrl() . "/'>Kembali ke Beranda</a>";
    }

    public function info()
    {
        echo "<h1>🍰 Kayra Bakery - System Info</h1>";
        echo "<p><strong>PHP Version:</strong> " . PHP_VERSION . "</p>";
        echo "<p><strong>Server:</strong> " . $_SERVER['SERVER_SOFTWARE'] . "</p>";
        echo "<p><strong>Document Root:</strong> " . $_SERVER['DOCUMENT_ROOT'] . "</p>";
        echo "<p><strong>Script Name:</strong> " . $_SERVER['SCRIPT_NAME'] . "</p>";
        echo "<a href='" . $this->getBaseUrl() . "/'>Kembali ke Beranda</a>";
    }
}

?> 