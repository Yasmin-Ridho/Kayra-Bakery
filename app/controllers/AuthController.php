<?php

require_once 'core/Controller.php';
require_once 'app/models/User.php';

/**
 * Auth Controller
 * 
 * Controller untuk menangani authentication (login, register, logout)
 * Menggunakan User model untuk database authentication
 */

class AuthController extends Controller
{
    /**
     * Halaman login
     */
    public function login()
    {
        // Start session
        // session_start();
        
        // Jika sudah login, redirect ke home
        if ($this->isLoggedIn()) {
            if ($this->getCurrentUser()->role == 'admin') {
                $this->redirectToRoute('/dashboard');
            } else {
                $this->redirectToRoute('/');
            }
        }
        
        // Jika ada POST request (form login dikirim)
        if ($this->isPost()) {
            $email = trim($this->post('email', ''));
            $password = $this->post('password', '');
            $remember = $this->post('remember') !== null;
            
            // Validasi input
            if (empty($email) || empty($password)) {
                $this->setErrorMessage('Email dan password harus diisi!');
            } else {
                try {
                    // Authenticate user menggunakan User model
                    $user = User::authenticate($email, $password);
                    
                    if ($user) {
                        // Set session data
                        $_SESSION['user_id'] = $user->id;
                        $_SESSION['user_name'] = $user->name;
                        $_SESSION['user_email'] = $user->email;
                        $_SESSION['user_role'] = $user->role;
                        $_SESSION['logged_in'] = true;
                        
                        // Set remember me cookie jika dipilih
                        if ($remember) {
                            $token = bin2hex(random_bytes(32));
                            setcookie('remember_token', $token, time() + (86400 * 30), '/'); // 30 hari
                            // Note: Dalam implementasi production, simpan token di database
                        }
                        
                        $this->setSuccessMessage('Login berhasil! Selamat datang, ' . $user->getDisplayName());
                        
                        // Redirect ke dashboard atau home
                        if ($user->role == 'admin') {
                            $this->redirectToRoute('/dashboard');
                        } else {
                            $this->redirectToRoute('/');
                        }
                    } else {
                        $this->setErrorMessage('Email atau password salah!');
                    }
                } catch (Exception $e) {
                    $this->setErrorMessage('Terjadi kesalahan sistem. Silakan coba lagi.');
                    $this->log('Login error: ' . $e->getMessage(), 'error');
                }
            }
        }
        
        // Tampilkan halaman login
        include 'app/views/auth/login.php';
    }
    
    /**
     * Halaman register
     */
    public function register()
    {
        // Start session
        // session_start();
        
        // Jika sudah login, redirect ke home
        if ($this->isLoggedIn()) {
            $this->redirectToRoute('/');
        }
        
        // Jika ada POST request (form register dikirim)
        if ($this->isPost()) {
            $name = $this->sanitize($this->post('name', ''));
            $email = $this->sanitize($this->post('email', ''));
            $password = $this->post('password', '');
            $confirmPassword = $this->post('confirm_password', '');
            
            // Validasi input menggunakan helper method
            $requiredFields = [
                'name' => 'Nama',
                'email' => 'Email',
                'password' => 'Password'
            ];
            
            $errors = $this->validateRequired($requiredFields, [
                'name' => $name,
                'email' => $email,
                'password' => $password
            ]);
            
            // Validasi email format
            if (!empty($email) && !$this->validateEmail($email)) {
                $errors[] = 'Format email tidak valid!';
            }
            
            // Validasi password
            if (!empty($password) && strlen($password) < 6) {
                $errors[] = 'Password minimal 6 karakter!';
            }
            
            if ($password !== $confirmPassword) {
                $errors[] = 'Konfirmasi password tidak cocok!';
            }
            
            // Jika tidak ada error, lanjutkan proses registrasi
            if (empty($errors)) {
                try {
                    // Cek apakah email sudah terdaftar
                    if (User::emailExists($email)) {
                        $this->setErrorMessage('Email sudah terdaftar! Silakan gunakan email lain.');
                    } else {
                        // Buat user baru
                        $newUser = User::createUser([
                            'name' => $name,
                            'email' => $email,
                            'password' => $password
                        ]);
                        
                        if ($newUser) {
                            $this->setSuccessMessage('Registrasi berhasil! Silakan login dengan akun Anda.');
                            
                            // Redirect ke login setelah 2 detik
                            header('refresh:2;url=' . $this->getBaseUrl() . '/login');
                        } else {
                            $this->setErrorMessage('Gagal membuat akun. Silakan coba lagi.');
                        }
                    }
                } catch (Exception $e) {
                    $this->setErrorMessage('Terjadi kesalahan sistem. Silakan coba lagi.');
                    $this->log('Register error: ' . $e->getMessage(), 'error');
                }
            } else {
                $this->setErrorMessage(implode('<br>', $errors));
            }
        }
        
        // Tampilkan halaman register
        include 'app/views/auth/register.php';
    }
    
    /**
     * Logout
     */
    public function logout()
    {
        // Start session
        session_start();
        
        // Hapus remember me cookie
        if (isset($_COOKIE['remember_token'])) {
            setcookie('remember_token', '', time() - 3600, '/');
        }
        
        // Hapus semua data session
        session_destroy();
        
        // Set success message untuk halaman selanjutnya
        session_start();
        $this->setSuccessMessage('Anda telah berhasil logout.');
        
        // Redirect ke home
        $this->redirectToRoute('/');
    }
    
    /**
     * Check apakah user sudah login
     */
    public function isLoggedIn()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }
    
    /**
     * Get current logged in user
     */
    public function getCurrentUser()
    {
        if (!$this->isLoggedIn()) {
            return null;
        }
        
        try {
            return User::find($_SESSION['user_id']);
        } catch (Exception $e) {
            // Jika error, logout user
            $this->logout();
            return null;
        }
    }
    
    /**
     * Get current user ID
     */
    public function getCurrentUserId()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        return $_SESSION['user_id'] ?? null;
    }
    
    /**
     * Get current user name
     */
    public function getCurrentUserName()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        return $_SESSION['user_name'] ?? null;
    }
    
    /**
     * Redirect ke login jika belum login
     */
    public function requireLogin()
    {
        if (!$this->isLoggedIn()) {
            session_start();
            $this->setErrorMessage('Anda harus login terlebih dahulu.');
            $this->redirectToRoute('/login');
        }
    }
    
    /**
     * Check remember me token (untuk auto login)
     */
    public function checkRememberToken()
    {
        if (!$this->isLoggedIn() && isset($_COOKIE['remember_token'])) {
            // Dalam implementasi production, verifikasi token dari database
            // Untuk sekarang, kita skip fitur ini
        }
    }
    
    /**
     * Forgot password (placeholder)
     */
    public function forgotPassword()
    {
        session_start();
        
        if ($this->isPost()) {
            $email = $this->sanitize($this->post('email', ''));
            
            if (empty($email)) {
                $this->setErrorMessage('Email harus diisi!');
            } elseif (!$this->validateEmail($email)) {
                $this->setErrorMessage('Format email tidak valid!');
            } else {
                try {
                    $user = User::findByEmail($email);
                    if ($user) {
                        // Dalam implementasi production, kirim email reset password
                        $this->setSuccessMessage('Link reset password telah dikirim ke email Anda.');
                    } else {
                        $this->setErrorMessage('Email tidak ditemukan dalam sistem.');
                    }
                } catch (Exception $e) {
                    $this->setErrorMessage('Terjadi kesalahan sistem. Silakan coba lagi.');
                    $this->log('Forgot password error: ' . $e->getMessage(), 'error');
                }
            }
        }
        
        // Tampilkan halaman forgot password
        include 'app/views/auth/forgot-password.php';
    }
}

?>
