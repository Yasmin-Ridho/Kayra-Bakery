<?php

require_once 'core/Controller.php';

/**
 * Home Controller
 * 
 * Controller untuk menangani halaman-halaman utama website
 * Menggunakan base Controller class untuk helper methods
 */

class HomeController extends Controller
{
    /**
     * Halaman utama / landing page
     */
    public function index()
    {
        // Tampilkan landing page
        include 'app/views/landings/index.php';
    }
    
    /**
     * Halaman tentang kami
     */
    public function about()
    {
        // Tampilkan halaman about
        include 'app/views/pages/about.php';
    }
    
    /**
     * Halaman kontak
     */
    public function contact()
    {
        // Jika ada POST request (form kontak dikirim)
        if ($this->isPost()) {
            $name = $this->sanitize($this->post('name', ''));
            $email = $this->sanitize($this->post('email', ''));
            $message = $this->sanitize($this->post('message', ''));
            
            // Validasi input
            $requiredFields = [
                'name' => 'Nama',
                'email' => 'Email',
                'message' => 'Pesan'
            ];
            
            $errors = $this->validateRequired($requiredFields, [
                'name' => $name,
                'email' => $email,
                'message' => $message
            ]);
            
            // Validasi email format
            if (!empty($email) && !$this->validateEmail($email)) {
                $errors[] = 'Format email tidak valid!';
            }
            
            if (empty($errors)) {
                // Dalam implementasi production, kirim email atau simpan ke database
                $this->setSuccessMessage('Pesan Anda telah terkirim! Kami akan segera menghubungi Anda.');
                $this->log("Contact form submitted: {$name} ({$email})", 'info');
            } else {
                $this->setErrorMessage(implode('<br>', $errors));
            }
        }
        
        // Tampilkan halaman kontak
        include 'app/views/pages/contact.php';
    }
}

?> 