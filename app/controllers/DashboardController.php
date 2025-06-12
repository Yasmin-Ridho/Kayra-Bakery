<?php

require_once 'core/Controller.php';
require_once 'app/controllers/AuthController.php';

/**
 * Dashboard Controller
 * 
 * Controller untuk menangani halaman dashboard admin
 * Menggunakan base Controller class untuk helper methods
 */

class DashboardController extends Controller
{
    private $authController;
    
    public function __construct()
    {
        $this->authController = new AuthController();
    }

    /**
     * Helper method untuk check apakah user adalah admin
     */
    private function requireAdmin()
    {
        if (getCurrentUser()['role'] != 'admin') {
            setFlashMessage('error', 'Anda tidak memiliki akses ke halaman ini. Hanya admin yang diizinkan.');
            redirect(url('/'));
            exit;
        }
    }
    
    /**
     * Halaman dashboard utama
     */
    public function index()
    {
        // Pastikan user sudah login
        $this->authController->requireLogin();

        // Pastikan user adalah admin
        $this->requireAdmin();
        
        // Tampilkan dashboard
        include 'app/views/apps/dashboard/index.php';
    }
    
    /**
     * Dashboard analytics (placeholder)
     */
    public function analytics()
    {
        // Pastikan user sudah login
        $this->authController->requireLogin();

        // Pastikan user adalah admin
        $this->requireAdmin();
        
        // Set title
        $title = 'Analytics';
        
        // Content untuk analytics
        ob_start();
        ?>
        
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Analytics</h1>
            <p class="mt-1 text-sm text-gray-500">Analisis mendalam tentang performa bisnis Anda.</p>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
            <div class="text-center">
                <svg class="w-16 h-16 text-soft-pink-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Halaman Analytics</h3>
                <p class="text-gray-500">Fitur analytics akan dikembangkan di sini.</p>
                <div class="mt-6">
                    <a href="<?= $this->getBaseUrl() ?>/dashboard" class="inline-flex items-center px-4 py-2 bg-soft-pink-500 hover:bg-soft-pink-600 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali ke Dashboard
                    </a>
                </div>
            </div>
        </div>
        
        <?php
        $content = ob_get_clean();
        
        // Include layout app.php
        include 'app/views/layouts/app.php';
    }
    
    /**
     * Dashboard settings (placeholder)
     */
    public function settings()
    {
        // Pastikan user sudah login
        $this->authController->requireLogin();
        
        // Set title
        $title = 'Pengaturan Dashboard';
        
        // Content untuk settings
        ob_start();
        ?>
        
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Pengaturan Dashboard</h1>
            <p class="mt-1 text-sm text-gray-500">Kustomisasi tampilan dan preferensi dashboard Anda.</p>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Settings Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Preferensi Tampilan</h3>
                    
                    <form class="space-y-6">
                        <!-- Theme Selection -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">Tema Warna</label>
                            <div class="grid grid-cols-3 gap-3">
                                <label class="relative">
                                    <input type="radio" name="theme" value="pink" checked class="sr-only">
                                    <div class="w-full h-16 bg-gradient-to-r from-soft-pink-300 to-pink-400 rounded-lg cursor-pointer border-2 border-soft-pink-400 flex items-center justify-center">
                                        <span class="text-white font-medium text-sm">Pink</span>
                                    </div>
                                </label>
                                <label class="relative">
                                    <input type="radio" name="theme" value="blue" class="sr-only">
                                    <div class="w-full h-16 bg-gradient-to-r from-blue-300 to-blue-400 rounded-lg cursor-pointer border-2 border-gray-200 hover:border-blue-400 flex items-center justify-center">
                                        <span class="text-white font-medium text-sm">Biru</span>
                                    </div>
                                </label>
                                <label class="relative">
                                    <input type="radio" name="theme" value="green" class="sr-only">
                                    <div class="w-full h-16 bg-gradient-to-r from-green-300 to-green-400 rounded-lg cursor-pointer border-2 border-gray-200 hover:border-green-400 flex items-center justify-center">
                                        <span class="text-white font-medium text-sm">Hijau</span>
                                    </div>
                                </label>
                            </div>
                        </div>
                        
                        <!-- Dashboard Layout -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">Layout Dashboard</label>
                            <select class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-soft-pink-300 focus:border-soft-pink-400">
                                <option>Kompak</option>
                                <option>Standar</option>
                                <option>Luas</option>
                            </select>
                        </div>
                        
                        <!-- Notifications -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">Notifikasi</label>
                            <div class="space-y-3">
                                <label class="flex items-center">
                                    <input type="checkbox" checked class="rounded border-gray-300 text-soft-pink-500 focus:ring-soft-pink-300">
                                    <span class="ml-2 text-sm text-gray-700">Pesanan baru</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" checked class="rounded border-gray-300 text-soft-pink-500 focus:ring-soft-pink-300">
                                    <span class="ml-2 text-sm text-gray-700">Stok menipis</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" class="rounded border-gray-300 text-soft-pink-500 focus:ring-soft-pink-300">
                                    <span class="ml-2 text-sm text-gray-700">Review baru</span>
                                </label>
                            </div>
                        </div>
                        
                        <!-- Save Button -->
                        <div class="pt-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-soft-pink-500 hover:bg-soft-pink-600 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Simpan Pengaturan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Quick Info -->
            <div class="space-y-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Tips</h3>
                    <div class="space-y-3 text-sm text-gray-600">
                        <p>💡 Gunakan tema yang sesuai dengan brand Anda</p>
                        <p>🔔 Aktifkan notifikasi untuk update real-time</p>
                        <p>📱 Layout kompak cocok untuk mobile</p>
                    </div>
                </div>
                
                <div class="bg-soft-pink-50 rounded-xl border border-soft-pink-200 p-6">
                    <h3 class="text-lg font-semibold text-soft-pink-800 mb-2">Butuh Bantuan?</h3>
                    <p class="text-sm text-soft-pink-600 mb-4">Tim support kami siap membantu Anda.</p>
                    <a href="<?= $this->getBaseUrl() ?>/help" class="inline-flex items-center text-soft-pink-600 hover:text-soft-pink-700 text-sm font-medium">
                        Hubungi Support
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        
        <?php
        $content = ob_get_clean();
        
        // Include layout app.php
        include 'app/views/layouts/app.php';
    }
}

?>