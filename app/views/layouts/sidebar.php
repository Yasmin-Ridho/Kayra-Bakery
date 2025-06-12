<?php
// Helper function untuk mendapatkan base URL
if (!function_exists('getBaseUrl')) {
    function getBaseUrl() {
        $script_name = $_SERVER['SCRIPT_NAME'];
        $base_path = dirname($script_name);
        return $base_path === '/' ? '' : $base_path;
    }
}
$baseUrl = getBaseUrl();

// Get current path untuk active menu
$currentPath = $_SERVER['REQUEST_URI'];
$currentPath = parse_url($currentPath, PHP_URL_PATH);
$currentPath = str_replace($baseUrl, '', $currentPath);

// Function untuk check active menu
function isActiveMenu($path, $currentPath) {
    return $currentPath === $path || strpos($currentPath, $path) === 0;
}
?>

<!-- Sidebar -->
<aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-lg border-r border-gray-200 transform -translate-x-full lg:translate-x-0 sidebar-transition flex flex-col">
    
    <!-- Sidebar Header -->
    <div class="flex items-center justify-between h-16 px-6 border-b border-gray-200 flex-shrink-0">
        <div class="flex items-center space-x-3">
            <!-- Logo -->
            <div class="w-8 h-8 bg-gradient-to-r from-soft-pink-300 to-pink-400 rounded-lg flex items-center justify-center">
                <span class="text-white font-bold text-sm">K</span>
            </div>
            <div>
                <h1 class="text-lg font-bold text-gray-800">Kayra Bakery & Cake</h1>
                <p class="text-xs text-gray-500">Dashboard Admin</p>
            </div>
        </div>
        
        <!-- Close Button (Mobile) -->
        <button onclick="toggleSidebar()" class="lg:hidden p-1 rounded-lg text-gray-400 hover:text-gray-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
    
    <!-- Sidebar Navigation -->
    <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
        
        <!-- Dashboard -->
        <a href="<?= url('dashboard') ?>" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors duration-200 <?= isActiveMenu('/dashboard', $currentPath) ? 'bg-soft-pink-50 text-soft-pink-600 border-r-2 border-soft-pink-400' : 'text-gray-700 hover:bg-gray-50 hover:text-soft-pink-500' ?>">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
            </svg>
            Dashboard
        </a>
        
        <?php if (getCurrentUser()['role'] == 'admin'): ?>
        <!-- Products Section -->
            <div class="space-y-1">
                <div class="px-4 py-2">
                    <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Produk</h3>
                </div>
                
                <a href="<?= url('products/admin') ?>" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors duration-200 <?= isActiveMenu('/products', $currentPath) ? 'bg-soft-pink-50 text-soft-pink-600 border-r-2 border-soft-pink-400' : 'text-gray-700 hover:bg-gray-50 hover:text-soft-pink-500' ?>">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    Semua Produk
                </a>
                
                <a href="<?= url('products/create') ?>" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors duration-200 <?= isActiveMenu('/products/create', $currentPath) ? 'bg-soft-pink-50 text-soft-pink-600 border-r-2 border-soft-pink-400' : 'text-gray-700 hover:bg-gray-50 hover:text-soft-pink-500' ?>">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Tambah Produk
                </a>
                
                <a href="<?= url('categories') ?>" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors duration-200 <?= isActiveMenu('/categories', $currentPath) ? 'bg-soft-pink-50 text-soft-pink-600 border-r-2 border-soft-pink-400' : 'text-gray-700 hover:bg-gray-50 hover:text-soft-pink-500' ?>">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    Kategori
                </a>
            </div>
        <?php endif; ?>
        
        <!-- Orders Section -->
        <div class="space-y-1">
            <div class="px-4 py-2">
                <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Pesanan</h3>
            </div>
            
            <a href="<?= url('orders') ?>" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors duration-200 <?= isActiveMenu('/orders', $currentPath) ? 'bg-soft-pink-50 text-soft-pink-600 border-r-2 border-soft-pink-400' : 'text-gray-700 hover:bg-gray-50 hover:text-soft-pink-500' ?>">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                Semua Pesanan
            </a>
            
            <a href="<?= url('orders/pending') ?>" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors duration-200 <?= isActiveMenu('/orders/pending', $currentPath) ? 'bg-soft-pink-50 text-soft-pink-600 border-r-2 border-soft-pink-400' : 'text-gray-700 hover:bg-gray-50 hover:text-soft-pink-500' ?>">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Menunggu
            </a>
        </div>
        
        <!-- Settings Section -->
        <div class="space-y-1">
            <div class="px-4 py-2">
                <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Pengaturan</h3>
            </div>
            
            <a href="<?= url('dashboard/settings') ?>" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors duration-200 <?= isActiveMenu('/dashboard/settings', $currentPath) ? 'bg-soft-pink-50 text-soft-pink-600 border-r-2 border-soft-pink-400' : 'text-gray-700 hover:bg-gray-50 hover:text-soft-pink-500' ?>">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                Pengaturan Dashboard
            </a>
            
            <a href="<?= url('users') ?>" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors duration-200 <?= isActiveMenu('/users', $currentPath) ? 'bg-soft-pink-50 text-soft-pink-600 border-r-2 border-soft-pink-400' : 'text-gray-700 hover:bg-gray-50 hover:text-soft-pink-500' ?>">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                </svg>
                Manajemen User
            </a>
        </div>
    </nav>
    
    <!-- Sidebar Footer - Now Sticky at Bottom -->
    <div class="p-4 border-t border-gray-200 flex-shrink-0 mt-auto">
        <div class="flex items-center space-x-3 p-3 bg-soft-pink-50 rounded-lg">
            <div class="w-8 h-8 bg-gradient-to-r from-soft-pink-300 to-pink-400 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                🍰
            </div>
            <div class="flex-1">
                <p class="text-sm font-medium text-gray-700">Kayra Bakery & Cake</p>
                <p class="text-xs text-gray-500">v1.0.0</p>
            </div>
        </div>
    </div>
</aside>
