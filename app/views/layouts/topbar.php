<?php
// Get base URL menggunakan helper function
$baseUrl = getBaseUrl();

// Get current user info from session
$currentUser = getCurrentUser();
$currentUserName = $currentUser['name'] ?? 'User';
$currentUserEmail = $currentUser['email'] ?? '';
?>

<!-- Topbar -->
<header class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-30">
    <div class="flex items-center justify-between px-4 lg:px-6 py-3">
        
        <!-- Left Side: Mobile Menu Button + Breadcrumb -->
        <div class="flex items-center space-x-4">
            <!-- Mobile Menu Button -->
            <button onclick="toggleSidebar()" class="lg:hidden p-2 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-soft-pink-500 transition-colors duration-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
            
            <!-- Breadcrumb -->
            <nav class="hidden sm:flex items-center space-x-2 text-sm">
                <a href="<?= $baseUrl ?>/" class="text-gray-500 hover:text-soft-pink-500 transition-colors duration-200">
                    Beranda
                </a>
                <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-gray-700 font-medium"><?= $title ?? 'Dashboard' ?></span>
            </nav>
        </div>
        
        <!-- Right Side: Search + Notifications + User Menu -->
        <div class="flex items-center space-x-3">
            
            <!-- User Menu Dropdown -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                    <!-- User Avatar -->
                    <div class="w-8 h-8 bg-gradient-to-r from-soft-pink-300 to-pink-400 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                        <?= strtoupper(substr($currentUserName, 0, 1)) ?>
                    </div>
                    
                    <!-- User Info (Hidden on mobile) -->
                    <div class="hidden sm:block text-left">
                        <div class="text-sm font-medium text-gray-700"><?= $currentUserName ?></div>
                        <div class="text-xs text-gray-500"><?= $currentUserEmail ?></div>
                    </div>
                    
                    <!-- Dropdown Arrow -->
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                
                <!-- Dropdown Menu -->
                <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg border border-gray-200 py-2 z-50">
                    
                    <!-- User Info (Mobile) -->
                    <div class="sm:hidden px-4 py-3 border-b border-gray-100">
                        <div class="text-sm font-medium text-gray-700"><?= $currentUserName ?></div>
                        <div class="text-xs text-gray-500"><?= $currentUserEmail ?></div>
                    </div>
                    
                    <a href="<?= $baseUrl ?>/logout" class="flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Logout
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Alpine.js for dropdown functionality -->
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
