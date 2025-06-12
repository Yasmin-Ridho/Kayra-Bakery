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

// Get current user info
$isLoggedIn = isLoggedIn();
$currentUser = $isLoggedIn ? getCurrentUser() : null;
?>

<!-- Navigation -->
<nav class="bg-white/95 backdrop-blur-md shadow-lg sticky top-0 z-50 border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo/Brand -->
            <div class="flex items-center">
                <a href="<?= $baseUrl ?>/" class="flex items-center hover:opacity-80 transition-opacity duration-200">
                    <div>
                        <h1 class="text-lg font-bold text-gray-800">Kayra Bakery & Cake</h1>
                        <p class="text-sm text-gray-500 font-medium">Premium Bakery</p>
                    </div>
                </a>
            </div>
            
            <!-- Right Side Menu -->
            <div class="flex items-center space-x-4">
                <?php if ($isLoggedIn): ?>
                    <?php if ($currentUser && $currentUser['role'] === 'user'): ?>
                        <!-- Cart Dropdown -->
                        <div class="relative" id="cart-dropdown">
                            <button id="cart-btn" class="relative p-2 text-gray-700 hover:text-soft-pink-500 transition-colors duration-200 focus:outline-none">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 11-4 0v-6m4 0V9a2 2 0 10-4 0v4.01"/>
                                </svg>
                                <!-- Cart Count Badge -->
                                <span class="cart-count absolute -top-1 -right-1 bg-soft-pink-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-semibold hidden">0</span>
                            </button>
                            
                            <!-- Cart Dropdown Menu -->
                            <div id="cart-menu" class="absolute right-0 mt-2 w-96 max-w-[calc(100vw-2rem)] bg-white rounded-xl shadow-2xl border border-gray-100 z-50 hidden overflow-hidden transform transition-all duration-200 opacity-0 scale-95">
                                <div class="p-6">
                                    <div class="flex items-center justify-between mb-6">
                                        <h3 class="text-xl font-bold text-gray-800">Keranjang</h3>
                                        <span class="cart-count text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full font-medium">0 item</span>
                                    </div>
                                    
                                    <!-- Cart Items Container -->
                                    <div id="cart-items" class="space-y-4 max-h-80 overflow-y-auto mb-6 scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                                        <div class="text-center py-12 text-gray-500">
                                            <div class="w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 11-4 0v-6m4 0V9a2 2 0 10-4 0v4.01"/>
                                                </svg>
                                            </div>
                                            <p class="font-medium">Keranjang kosong</p>
                                            <p class="text-sm text-gray-400 mt-1">Mulai belanja sekarang!</p>
                                        </div>
                                    </div>
                                    
                                    <!-- Cart Actions -->
                                    <div class="pt-4 border-t border-gray-100">
                                        <div class="grid grid-cols-2 gap-3">
                                            <a href="<?= $baseUrl ?>/carts" class="bg-soft-pink-500 text-white text-center py-3 px-4 rounded-lg hover:bg-soft-pink-600 transition-all duration-200 font-semibold text-sm transform hover:scale-105">
                                                Keranjang
                                            </a>
                                            <a href="<?= $baseUrl ?>/products" class="border border-gray-300 text-gray-700 text-center py-3 px-4 rounded-lg hover:bg-gray-50 hover:border-soft-pink-300 transition-all duration-200 font-medium text-sm">
                                                Belanja
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <!-- User Menu -->
                    <div class="relative" id="user-dropdown">
                        <button id="user-btn" class="flex items-center space-x-2 text-gray-700 hover:text-soft-pink-500 transition-colors duration-200 focus:outline-none">
                            <div class="w-8 h-8 bg-soft-pink-400 rounded-full flex items-center justify-center">
                                <span class="text-white font-semibold text-sm">
                                    <?= strtoupper(substr($currentUser['name'] ?? 'U', 0, 1)) ?>
                                </span>
                            </div>
                            <span class="hidden md:block font-medium"><?= htmlspecialchars($currentUser['name'] ?? 'User') ?></span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        
                        <!-- User Dropdown Menu -->
                        <div id="user-menu" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-gray-200 z-50 hidden transform transition-all duration-200 opacity-0 scale-95">
                            <div class="py-2">
                                <?php if ($currentUser && $currentUser['role'] === 'user'): ?>
                                <a href="<?= $baseUrl ?>/orders/my-order" class="block px-4 py-2 text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                        </svg>
                                        <span>Pesanan</span>
                                    </div>
                                </a>
                                <?php else: ?>
                                    <a href="<?= $baseUrl ?>/dashboard" class="block px-4 py-2 text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                            </svg>
                                            <span>Dashboard</span>
                                        </div>
                                    </a>
                                <?php endif; ?>
                                <div class="border-t border-gray-200 my-1"></div>
                                <a href="<?= $baseUrl ?>/logout" class="block px-4 py-2 text-red-600 hover:bg-red-50 transition-colors duration-200">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                        </svg>
                                        <span>Logout</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- Login Button -->
                    <a href="<?= $baseUrl ?>/login" class="bg-gradient-to-r from-soft-pink-300 to-pink-400 text-white px-6 py-2 rounded-full font-semibold hover:from-soft-pink-400 hover:to-pink-500 transition-all duration-200 transform hover:scale-105 shadow-lg">
                        Masuk
                    </a>
                <?php endif; ?>
                
                <!-- Mobile Menu Button -->
                <div class="md:hidden">
                    <button id="mobile-menu-btn" class="text-gray-700 hover:text-soft-pink-500 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- show only for user role == 'user' -->
    <?php if ($currentUser && $currentUser['role'] === 'user'): ?>
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="md:hidden hidden bg-white border-t border-gray-200">
            <div class="px-4 py-4 space-y-3">
                <?php if ($isLoggedIn): ?>
                    <?php if ($currentUser && $currentUser['role'] === 'user'): ?>
                        <a href="<?= $baseUrl ?>/carts" class="block text-gray-700 hover:text-soft-pink-500 font-medium">
                            <div class="flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 11-4 0v-6m4 0V9a2 2 0 10-4 0v4.01"/>
                                </svg>
                                <span>Keranjang</span>
                                <span class="cart-count bg-soft-pink-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-semibold hidden">0</span>
                            </div>
                        </a>
                        <a href="<?= $baseUrl ?>/orders/my-order" class="block text-gray-700 hover:text-soft-pink-500 font-medium">Pesanan</a>
                    <?php else: ?>
                        <a href="<?= $baseUrl ?>/dashboard" class="block text-gray-700 hover:text-soft-pink-500 font-medium">
                            <div class="flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                            </div>
                            <span>Dashboard</span>
                        </a>
                    <?php endif; ?>
                    <a href="<?= $baseUrl ?>/logout" class="block bg-red-500 text-white px-4 py-2 rounded-lg font-semibold text-center">Logout</a>
                <?php else: ?>
                    <a href="<?= $baseUrl ?>/login" class="block bg-gradient-to-r from-soft-pink-300 to-pink-400 text-white px-4 py-2 rounded-lg font-semibold text-center">Masuk</a>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</nav>

<script>
// Navbar JavaScript functionality
document.addEventListener('DOMContentLoaded', function() {
    // Add custom scrollbar styles
    const style = document.createElement('style');
    style.textContent = `
        .scrollbar-thin::-webkit-scrollbar {
            width: 6px;
        }
        .scrollbar-thin::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 3px;
        }
        .scrollbar-thin::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }
        .scrollbar-thin::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        
        /* Firefox scrollbar */
        .scrollbar-thin {
            scrollbar-width: thin;
            scrollbar-color: #cbd5e1 #f1f5f9;
        }
    `;
    document.head.appendChild(style);
    
    // Mobile menu toggle
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    
    if (mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    }
    
    // Cart dropdown toggle
    const cartBtn = document.getElementById('cart-btn');
    const cartMenu = document.getElementById('cart-menu');
    
    if (cartBtn && cartMenu) {
        cartBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            
            // Close user menu if open
            const userMenu = document.getElementById('user-menu');
            if (userMenu && !userMenu.classList.contains('hidden')) {
                hideDropdown(userMenu);
            }
            
            // Toggle cart menu
            if (cartMenu.classList.contains('hidden')) {
                showDropdown(cartMenu);
                // Load cart items when opened
                loadCartItems();
            } else {
                hideDropdown(cartMenu);
            }
        });
    }
    
    // User dropdown toggle
    const userBtn = document.getElementById('user-btn');
    const userMenu = document.getElementById('user-menu');
    
    if (userBtn && userMenu) {
        userBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            
            // Close cart menu if open
            if (cartMenu && !cartMenu.classList.contains('hidden')) {
                hideDropdown(cartMenu);
            }
            
            // Toggle user menu
            if (userMenu.classList.contains('hidden')) {
                showDropdown(userMenu);
            } else {
                hideDropdown(userMenu);
            }
        });
    }
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', () => {
        if (cartMenu && !cartMenu.classList.contains('hidden')) {
            hideDropdown(cartMenu);
        }
        if (userMenu && !userMenu.classList.contains('hidden')) {
            hideDropdown(userMenu);
        }
    });
    
    // Helper functions for smooth dropdown animations
    function showDropdown(dropdown) {
        dropdown.classList.remove('hidden');
        // Force reflow
        dropdown.offsetHeight;
        dropdown.classList.remove('opacity-0', 'scale-95');
        dropdown.classList.add('opacity-100', 'scale-100');
    }
    
    function hideDropdown(dropdown) {
        dropdown.classList.remove('opacity-100', 'scale-100');
        dropdown.classList.add('opacity-0', 'scale-95');
        setTimeout(() => {
            dropdown.classList.add('hidden');
        }, 200);
    }
    
    // Load cart count on page load
    <?php if ($isLoggedIn): ?>
        loadCartCount();
    <?php endif; ?>
});

// Load cart count
async function loadCartCount() {
    try {
        const response = await fetch('<?= $baseUrl ?>/api/carts/count');
        const result = await response.json();
        
        if (result.success) {
            updateCartCount(result.count);
        }
    } catch (error) {
        console.error('Error loading cart count:', error);
    }
}

// Load cart items for dropdown
async function loadCartItems() {
    try {
        const response = await fetch('<?= $baseUrl ?>/api/carts/items');
        const result = await response.json();
        
        if (result.success) {
            displayCartItems(result.items, result.total);
        }
    } catch (error) {
        console.error('Error loading cart items:', error);
    }
}

// Display cart items in dropdown
function displayCartItems(items, total) {
    const cartItemsContainer = document.getElementById('cart-items');
    
    if (!items || items.length === 0) {
        cartItemsContainer.innerHTML = `
            <div class="text-center py-12 text-gray-500">
                <div class="w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 11-4 0v-6m4 0V9a2 2 0 10-4 0v4.01"/>
                    </svg>
                </div>
                <p class="font-medium">Keranjang kosong</p>
                <p class="text-sm text-gray-400 mt-1">Mulai belanja sekarang!</p>
            </div>
        `;
        return;
    }
    
    let itemsHtml = '';
    items.forEach(item => {
        itemsHtml += `
            <div class="flex items-center space-x-4 p-3 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors duration-200">
                <div class="flex-shrink-0">
                    <img src="${item.product_image || '<?= $baseUrl ?>/assets/images/placeholder-product.jpg'}" 
                         alt="${item.product_name}" 
                         class="w-14 h-14 object-cover rounded-lg shadow-sm" 
                         onerror="this.src='<?= $baseUrl ?>/assets/images/placeholder-product.jpg'">
                </div>
                <div class="flex-1 min-w-0">
                    <h4 class="text-sm font-semibold text-gray-800 truncate mb-1">${item.product_name}</h4>
                    <div class="flex items-center justify-between">
                        <p class="text-xs text-gray-500">${item.quantity}x ${item.product_price}</p>
                        <div class="text-sm font-bold text-soft-pink-600">
                            ${item.subtotal}
                        </div>
                    </div>
                </div>
            </div>
        `;
    });
    
    // Add total section if there are items
    if (items.length > 0) {
        itemsHtml += `
            <div class="mt-4 pt-4 border-t border-gray-200">
                <div class="flex justify-between items-center">
                    <span class="text-sm font-medium text-gray-600">Total:</span>
                    <span class="text-lg font-bold text-soft-pink-600">${total}</span>
                </div>
            </div>
        `;
    }
    
    cartItemsContainer.innerHTML = itemsHtml;
}

// Update cart count globally
function updateCartCount(count) {
    const cartCountElements = document.querySelectorAll('.cart-count');
    cartCountElements.forEach(element => {
        // Check if this is the badge or the text counter
        if (element.classList.contains('absolute')) {
            // This is the badge - show number only
            element.textContent = count;
        } else {
            // This is the text counter - show "X item(s)"
            element.textContent = count + (count === 1 ? ' item' : ' item');
        }
        
        if (count > 0) {
            element.classList.remove('hidden');
        } else {
            element.classList.add('hidden');
        }
    });
}
</script>
