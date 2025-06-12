<?php
$title = 'Keranjang Belanja - Kayra Bakery & Cake';

// Helper function untuk mendapatkan base URL
if (!function_exists('getBaseUrl')) {
    function getBaseUrl() {
        $script_name = $_SERVER['SCRIPT_NAME'];
        $base_path = dirname($script_name);
        return $base_path === '/' ? '' : $base_path;
    }
}
$baseUrl = getBaseUrl();

// Start session untuk flash messages
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

ob_start();
?>

<!-- Hero Section - Enhanced Responsive -->
<section class="relative py-12 sm:py-16 lg:py-20 bg-gradient-to-br from-soft-pink-100 via-pink-100 to-pink-200 overflow-hidden">
    <!-- Background Image Overlay -->
    <div class="absolute inset-0 bg-cover bg-center bg-no-repeat opacity-35" 
         style="background-image: url('https://plus.unsplash.com/premium_photo-1703794159667-184f98e7e4e8?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D')"></div>
    
    <!-- Gradient Overlay -->
    <div class="absolute inset-0 bg-gradient-to-br from-soft-pink-200/35 via-pink-100/25 to-pink-200/35"></div>
    
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-10 left-10 w-20 h-20 bg-soft-pink-300 rounded-full blur-xl"></div>
        <div class="absolute top-32 right-20 w-32 h-32 bg-pink-300 rounded-full blur-2xl"></div>
        <div class="absolute bottom-20 left-1/3 w-24 h-24 bg-soft-pink-400 rounded-full blur-xl"></div>
    </div>
    
    <!-- Floating Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-16 left-12 w-3 h-3 bg-white/50 rounded-full animate-float"></div>
        <div class="absolute top-32 right-16 w-4 h-4 bg-pink-300/60 rounded-full animate-float delay-1000"></div>
        <div class="absolute bottom-32 left-16 w-5 h-5 bg-soft-pink-400/50 rounded-full animate-float delay-2000"></div>
        <div class="absolute bottom-16 right-20 w-3 h-3 bg-white/60 rounded-full animate-float delay-3000"></div>
    </div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <!-- Breadcrumb -->
            <nav class="flex justify-center mb-6 sm:mb-8" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3 text-sm bg-white/80 backdrop-blur-lg rounded-full px-6 py-3 shadow-xl border border-white/30">
                    <li class="inline-flex items-center">
                        <a href="<?= $baseUrl ?>/" class="text-gray-600 hover:text-soft-pink-600 transition-colors duration-200 font-medium flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                            </svg>
                            Beranda
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span class="ml-1 text-gray-800 font-bold">Keranjang Belanja</span>
                        </div>
                    </li>
                </ol>
            </nav>
            
            <!-- Title -->
            <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-gray-800 mb-4 sm:mb-6 leading-tight">
                <span class="bg-gradient-to-r from-soft-pink-500 via-pink-500 to-pink-600 bg-clip-text text-transparent drop-shadow-sm">
                    Keranjang
                </span>
                <br class="hidden sm:block">
                <span class="text-gray-700">Belanja</span>
            </h1>
            
            <p class="text-base sm:text-lg md:text-xl lg:text-2xl text-gray-700 max-w-3xl mx-auto leading-relaxed px-4 font-medium mb-8">
                Kelola produk pilihan Anda dengan 
                <span class="text-soft-pink-600 font-semibold">mudah</span> dan 
                <span class="text-pink-600 font-semibold">nyaman</span> sebelum checkout
            </p>
            
            <!-- Shopping Badge -->
            <div class="flex justify-center mb-8">
                <div class="inline-flex items-center bg-gradient-to-r from-soft-pink-50 to-pink-50 border-2 border-soft-pink-200 rounded-full px-6 py-3 shadow-lg">
                    <svg class="w-5 h-5 text-soft-pink-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 11-4 0v-6m4 0V9a2 2 0 10-4 0v4.01"/>
                    </svg>
                    <span class="text-soft-pink-700 font-semibold">Siap untuk Checkout</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Flash Messages - Enhanced Responsive -->
<?php if (hasValidationErrors()): ?>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6 sm:mt-8">
        <div class="bg-gradient-to-r from-red-50 to-red-100 border-l-4 border-red-400 rounded-xl p-4 sm:p-6 shadow-lg">
            <div class="flex flex-col sm:flex-row sm:items-start">
                <div class="flex-shrink-0 mb-3 sm:mb-0 sm:mr-4">
                    <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                        <svg class="h-5 w-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="flex-1">
                    <h3 class="text-sm sm:text-base font-semibold text-red-800 mb-2">Terjadi kesalahan:</h3>
                    <div class="text-sm text-red-700 space-y-1">
                        <?php displayValidationErrors(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if ($successMessage = getFlashMessage('success')): ?>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6 sm:mt-8">
        <div class="bg-gradient-to-r from-green-50 to-green-100 border-l-4 border-green-400 rounded-xl p-4 sm:p-6 shadow-lg">
            <div class="flex flex-col sm:flex-row sm:items-center">
                <div class="flex-shrink-0 mb-3 sm:mb-0 sm:mr-4">
                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                        <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="flex-1">
                    <p class="text-sm sm:text-base font-medium text-green-800"><?= htmlspecialchars($successMessage) ?></p>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if ($warningMessage = getFlashMessage('warning')): ?>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6 sm:mt-8">
        <div class="bg-gradient-to-r from-yellow-50 to-yellow-100 border-l-4 border-yellow-400 rounded-xl p-4 sm:p-6 shadow-lg">
            <div class="flex flex-col sm:flex-row sm:items-center">
                <div class="flex-shrink-0 mb-3 sm:mb-0 sm:mr-4">
                    <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                        <svg class="h-5 w-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                    </div>
                </div>
                <div class="flex-1">
                    <p class="text-sm sm:text-base font-medium text-yellow-800"><?= htmlspecialchars($warningMessage) ?></p>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Cart Content - Enhanced Responsive -->
<section class="py-12 sm:py-16 lg:py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <?php if (empty($carts)): ?>
            <!-- Empty Cart - Enhanced -->
            <div class="text-center py-12 sm:py-16 lg:py-20">
                <div class="max-w-md mx-auto">
                    <!-- Animated Icon -->
                    <div class="mx-auto h-20 w-20 sm:h-24 sm:w-24 lg:h-32 lg:w-32 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mb-6 sm:mb-8 shadow-lg animate-pulse">
                        <svg class="h-10 w-10 sm:h-12 sm:w-12 lg:h-16 lg:w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 11-4 0v-6m4 0V9a2 2 0 10-4 0v4.01"/>
                        </svg>
                    </div>
                    
                    <h3 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-800 mb-4 sm:mb-6">
                        Keranjang Belanja Kosong
                    </h3>
                    <p class="text-base sm:text-lg text-gray-600 mb-8 sm:mb-10 leading-relaxed px-4">
                        Belum ada produk di keranjang Anda. Mari mulai berbelanja produk terbaik kami dan temukan kelezatan yang tak terlupakan!
                    </p>
                    
                    <!-- CTA Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                        <a href="<?= $baseUrl ?>/products" 
                           class="w-full sm:w-auto inline-flex items-center justify-center bg-gradient-to-r from-soft-pink-400 to-pink-500 text-white px-6 sm:px-8 py-3 sm:py-4 rounded-xl font-semibold hover:from-soft-pink-500 hover:to-pink-600 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl text-sm sm:text-base">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                            Mulai Berbelanja
                        </a>
                        <a href="<?= $baseUrl ?>/" 
                           class="w-full sm:w-auto inline-flex items-center justify-center border-2 border-gray-300 text-gray-700 px-6 sm:px-8 py-3 sm:py-4 rounded-xl font-semibold hover:bg-gray-50 hover:border-soft-pink-300 hover:text-soft-pink-500 transition-all duration-300 text-sm sm:text-base">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            Kembali ke Beranda
                        </a>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <!-- Cart Items - Enhanced Responsive Layout -->
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 lg:gap-8">
                <!-- Cart Items List -->
                <div class="xl:col-span-2 order-2 xl:order-1">
                    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                        <!-- Header -->
                        <div class="px-4 sm:px-6 py-4 sm:py-6 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                                <h3 class="text-lg sm:text-xl font-bold text-gray-800 mb-2 sm:mb-0">Item Keranjang</h3>
                                <div class="flex items-center space-x-4">
                                    <span class="text-sm text-gray-500 bg-white px-3 py-1 rounded-full">
                                        <?= count($carts) ?> item
                                    </span>
                                    <button onclick="clearCart()" 
                                            class="text-red-500 hover:text-red-700 text-sm font-medium transition-colors duration-200 hover:bg-red-50 px-3 py-1 rounded-full">
                                        Kosongkan
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Items List -->
                        <div class="divide-y divide-gray-100">
                            <?php foreach ($carts as $cart): ?>
                                <?php 
                                $product = $cart->product();
                                if (!$product) continue;
                                $subtotal = $product->price * $cart->quantity;
                                ?>
                                <div class="p-4 sm:p-6 hover:bg-gradient-to-r hover:from-gray-50 hover:to-soft-pink-50 transition-all duration-300 group">
                                    <div class="flex flex-col sm:flex-row sm:items-center space-y-4 sm:space-y-0 sm:space-x-4">
                                        <!-- Product Image -->
                                        <div class="flex-shrink-0 mx-auto sm:mx-0">
                                            <div class="relative">
                                                <img class="h-20 w-20 sm:h-24 sm:w-24 rounded-xl object-cover border-2 border-gray-200 group-hover:border-soft-pink-300 transition-all duration-300 shadow-md" 
                                                     src="<?= $product->getImageUrl() ?>" 
                                                     alt="<?= htmlspecialchars($product->name) ?>"
                                                     onerror="this.src='<?= $baseUrl ?>/assets/images/placeholder-product.jpg'">
                                                <!-- Stock Badge -->
                                                <div class="absolute -top-2 -right-2 bg-soft-pink-500 text-white text-xs font-bold px-2 py-1 rounded-full shadow-lg">
                                                    <?= $product->stock ?>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Product Info -->
                                        <div class="flex-1 text-center sm:text-left">
                                            <h4 class="text-lg sm:text-xl font-bold text-gray-800 mb-2 group-hover:text-soft-pink-600 transition-colors duration-200">
                                                <?= htmlspecialchars($product->name) ?>
                                            </h4>
                                            <p class="text-sm text-gray-600 mb-3 line-clamp-2">
                                                <?= htmlspecialchars($product->description) ?>
                                            </p>
                                            <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-4 space-y-2 sm:space-y-0">
                                                <span class="text-lg sm:text-xl font-bold bg-gradient-to-r from-soft-pink-500 to-pink-600 bg-clip-text text-transparent">
                                                    <?= $product->getFormattedPrice() ?>
                                                </span>
                                                <span class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                                                    Stok tersedia: <?= $product->stock ?>
                                                </span>
                                            </div>
                                        </div>
                                        
                                        <!-- Quantity Controls & Actions -->
                                        <div class="flex flex-col space-y-4 sm:space-y-3">
                                            <!-- Quantity Controls -->
                                            <form method="POST" action="<?= $baseUrl ?>/carts/<?= $cart->id ?>" class="flex items-center justify-center">
                                                <input type="hidden" name="_method" value="PUT">
                                                <div class="flex items-center bg-white border-2 border-gray-200 rounded-xl shadow-sm hover:border-soft-pink-300 transition-colors duration-200">
                                                    <button type="button" onclick="decreaseQuantity(this)" 
                                                            class="px-3 py-2 text-gray-600 hover:text-soft-pink-600 hover:bg-soft-pink-50 rounded-l-xl transition-all duration-200">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                                        </svg>
                                                    </button>
                                                    <input type="number" name="quantity" value="<?= $cart->quantity ?>" 
                                                           min="1" max="<?= $product->stock ?>"
                                                           class="w-16 px-3 py-2 text-center border-0 focus:ring-0 focus:outline-none font-semibold text-gray-800">
                                                    <button type="button" onclick="increaseQuantity(this)" 
                                                            class="px-3 py-2 text-gray-600 hover:text-soft-pink-600 hover:bg-soft-pink-50 rounded-r-xl transition-all duration-200">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                                        </svg>
                                                    </button>
                                                </div>
                                                <button type="submit" 
                                                        class="ml-3 px-4 py-2 bg-gradient-to-r from-soft-pink-100 to-soft-pink-200 text-soft-pink-700 rounded-xl hover:from-soft-pink-200 hover:to-soft-pink-300 transition-all duration-200 text-sm font-semibold shadow-sm hover:shadow-md">
                                                    Update
                                                </button>
                                            </form>
                                            
                                            <!-- Subtotal & Remove -->
                                            <div class="flex items-center justify-between">
                                                <div class="text-center sm:text-right">
                                                    <div class="text-lg sm:text-xl font-bold text-gray-800 mb-1">
                                                        Rp <?= number_format($subtotal, 0, ',', '.') ?>
                                                    </div>
                                                    <div class="text-xs text-gray-500">Subtotal</div>
                                                </div>
                                                <button onclick="removeItem(<?= $cart->id ?>, '<?= htmlspecialchars($product->name) ?>')" 
                                                        class="ml-4 p-2 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-xl transition-all duration-200 group/remove">
                                                    <svg class="w-5 h-5 group-hover/remove:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                
                <!-- Order Summary - Compact & Sleek -->
                <div class="xl:col-span-1 order-1 xl:order-2">
                    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-3 sm:p-4 sticky top-24 sm:top-48">
                        <!-- Header -->
                        <div class="text-center mb-3 sm:mb-4">
                            <h3 class="text-base sm:text-lg font-bold text-gray-800 mb-1">Ringkasan Pesanan</h3>
                            <div class="w-8 sm:w-12 h-0.5 bg-gradient-to-r from-soft-pink-400 to-pink-500 rounded-full mx-auto"></div>
                        </div>
                        
                        <!-- Summary Details -->
                        <div class="space-y-2 sm:space-y-3 mb-3 sm:mb-4">
                            <div class="flex justify-between items-center py-2 px-3 bg-gray-50 rounded-lg">
                                <span class="text-xs sm:text-sm text-gray-600 font-medium">Total Item</span>
                                <span class="text-xs sm:text-sm font-semibold text-gray-800 bg-soft-pink-100 text-soft-pink-700 px-2 py-0.5 rounded-full">
                                    <?= $totalItems ?> item
                                </span>
                            </div>
                            
                            <div class="flex justify-between items-center py-2 px-3 bg-gray-50 rounded-lg">
                                <span class="text-xs sm:text-sm text-gray-600 font-medium">Subtotal</span>
                                <span class="text-xs sm:text-sm font-bold text-gray-800">Rp <?= number_format($totalPrice, 0, ',', '.') ?></span>
                            </div>
                            
                            <div class="flex justify-between items-center py-2 px-3 bg-gray-50 rounded-lg">
                                <span class="text-xs sm:text-sm text-gray-600 font-medium">Ongkos Kirim</span>
                                <span class="text-xs sm:text-sm font-semibold text-green-600">Gratis</span>
                            </div>
                            
                            <div class="border-t border-gray-200 pt-2 sm:pt-3">
                                <div class="flex justify-between items-center py-2 px-3 bg-gradient-to-r from-soft-pink-50 to-pink-50 rounded-lg border border-soft-pink-200">
                                    <span class="text-sm sm:text-base font-bold text-gray-800">Total Pembayaran</span>
                                    <span class="text-sm sm:text-base font-bold bg-gradient-to-r from-soft-pink-600 to-pink-600 bg-clip-text text-transparent">
                                        Rp <?= number_format($totalPrice, 0, ',', '.') ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="space-y-2">
                            <a href="<?= $baseUrl ?>/checkout" class="block w-full bg-gradient-to-r from-soft-pink-500 to-pink-600 text-white py-2.5 sm:py-3 px-4 rounded-lg font-semibold hover:from-soft-pink-600 hover:to-pink-700 transition-all duration-300 transform hover:scale-105 shadow-md hover:shadow-lg text-xs sm:text-sm text-center">
                                <svg class="w-3 h-3 sm:w-4 sm:h-4 inline mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                                Lanjut ke Pembayaran
                            </a>
                            
                            <a href="<?= $baseUrl ?>/products" 
                               class="block w-full text-center border border-gray-300 text-gray-700 py-2.5 sm:py-3 px-4 rounded-lg font-semibold hover:bg-gray-50 hover:border-soft-pink-300 hover:text-soft-pink-600 transition-all duration-300 text-xs sm:text-sm">
                                <svg class="w-3 h-3 sm:w-4 sm:h-4 inline mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/>
                                </svg>
                                Lanjut Belanja
                            </a>
                            
                            <!-- Security Badge -->
                            <div class="flex items-center justify-center space-x-1.5 text-xs text-gray-500 pt-2 border-t border-gray-200">
                                <svg class="w-3 h-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                                <span>Pembayaran 100% Aman & Terpercaya</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Remove Item Modal - Enhanced -->
<div id="removeModal" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm overflow-y-auto h-full w-full hidden z-50 flex items-center justify-center p-4">
    <div class="relative bg-white border border-gray-200 w-full max-w-md shadow-2xl rounded-2xl transform transition-all duration-300 scale-95 opacity-0" id="removeModalContent">
        <div class="p-6 sm:p-8 text-center">
            <!-- Icon -->
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-6">
                <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                </svg>
            </div>
            
            <!-- Content -->
            <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-4">Hapus Item dari Keranjang</h3>
            <div class="mb-8">
                <p class="text-sm sm:text-base text-gray-600 leading-relaxed">
                    Apakah Anda yakin ingin menghapus <br>
                    "<span id="itemName" class="font-semibold text-gray-800"></span>" <br>
                    dari keranjang belanja?
                </p>
            </div>
            
            <!-- Buttons -->
            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                <form id="removeForm" method="POST" class="flex-1">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" 
                            class="w-full px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 text-white font-semibold rounded-xl hover:from-red-600 hover:to-red-700 focus:outline-none focus:ring-4 focus:ring-red-300 transition-all duration-200 transform hover:scale-105">
                        Ya, Hapus Item
                    </button>
                </form>
                <button onclick="closeRemoveModal()" 
                        class="flex-1 px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 focus:outline-none focus:ring-4 focus:ring-gray-300 transition-all duration-200">
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Clear Cart Modal - Enhanced -->
<div id="clearModal" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm overflow-y-auto h-full w-full hidden z-50 flex items-center justify-center p-4">
    <div class="relative bg-white border border-gray-200 w-full max-w-md shadow-2xl rounded-2xl transform transition-all duration-300 scale-95 opacity-0" id="clearModalContent">
        <div class="p-6 sm:p-8 text-center">
            <!-- Icon -->
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-yellow-100 mb-6">
                <svg class="h-8 w-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                </svg>
            </div>
            
            <!-- Content -->
            <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-4">Kosongkan Keranjang</h3>
            <div class="mb-8">
                <p class="text-sm sm:text-base text-gray-600 leading-relaxed">
                    Apakah Anda yakin ingin mengosongkan semua item dari keranjang belanja? Tindakan ini tidak dapat dibatalkan.
                </p>
            </div>
            
            <!-- Buttons -->
            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                <form method="POST" action="<?= $baseUrl ?>/carts" class="flex-1">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" 
                            class="w-full px-6 py-3 bg-gradient-to-r from-yellow-500 to-yellow-600 text-white font-semibold rounded-xl hover:from-yellow-600 hover:to-yellow-700 focus:outline-none focus:ring-4 focus:ring-yellow-300 transition-all duration-200 transform hover:scale-105">
                        Ya, Kosongkan Semua
                    </button>
                </form>
                <button onclick="closeClearModal()" 
                        class="flex-1 px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 focus:outline-none focus:ring-4 focus:ring-gray-300 transition-all duration-200">
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Enhanced CSS & JavaScript -->
<style>
/* Line clamp utilities */
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Enhanced animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

.animate-fade-in-up {
    animation: fadeInUp 0.6s ease-out;
}

.animate-float {
    animation: float 3s ease-in-out infinite;
}

/* Animation delays */
.delay-1000 { animation-delay: 1000ms; }
.delay-2000 { animation-delay: 2000ms; }
.delay-3000 { animation-delay: 3000ms; }

/* Modal animations */
.modal-enter {
    opacity: 1;
    transform: scale(1);
}

/* Custom scrollbar */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb {
    background: linear-gradient(to bottom, #f472b6, #ec4899);
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(to bottom, #ec4899, #db2777);
}

/* Responsive utilities */
@media (max-width: 640px) {
    .sticky {
        position: relative !important;
        top: auto !important;
    }
}
</style>

<script>
// Enhanced quantity controls with validation and debouncing
let quantityUpdateTimeout = null;

function increaseQuantity(button) {
    // Prevent rapid clicking
    if (button.disabled) return;
    
    const input = button.parentElement.querySelector('input[name="quantity"]');
    const max = parseInt(input.getAttribute('max'));
    const current = parseInt(input.value) || 0;
    
    if (current < max) {
        input.value = current + 1;
        // Add visual feedback
        input.classList.add('bg-soft-pink-50');
        setTimeout(() => input.classList.remove('bg-soft-pink-50'), 200);
        
        // Trigger change event for validation
        input.dispatchEvent(new Event('change'));
    } else {
        // Show max reached feedback
        button.classList.add('text-red-500', 'animate-pulse');
        setTimeout(() => {
            button.classList.remove('text-red-500', 'animate-pulse');
        }, 1000);
    }
    
    // Temporarily disable button to prevent rapid clicking
    button.disabled = true;
    setTimeout(() => {
        button.disabled = false;
    }, 200);
}

function decreaseQuantity(button) {
    // Prevent rapid clicking
    if (button.disabled) return;
    
    const input = button.parentElement.querySelector('input[name="quantity"]');
    const current = parseInt(input.value) || 0;
    
    if (current > 1) {
        input.value = current - 1;
        // Add visual feedback
        input.classList.add('bg-soft-pink-50');
        setTimeout(() => input.classList.remove('bg-soft-pink-50'), 200);
        
        // Trigger change event for validation
        input.dispatchEvent(new Event('change'));
    } else {
        // Show min reached feedback
        button.classList.add('text-red-500', 'animate-pulse');
        setTimeout(() => {
            button.classList.remove('text-red-500', 'animate-pulse');
        }, 1000);
    }
    
    // Temporarily disable button to prevent rapid clicking
    button.disabled = true;
    setTimeout(() => {
        button.disabled = false;
    }, 200);
}

// Enhanced modal functionality
function removeItem(id, name) {
    document.getElementById('itemName').textContent = name;
    document.getElementById('removeForm').action = '<?= $baseUrl ?>/carts/' + id;
    showModal('removeModal');
}

function closeRemoveModal() {
    hideModal('removeModal');
}

function clearCart() {
    showModal('clearModal');
}

function closeClearModal() {
    hideModal('clearModal');
}

// Enhanced modal show/hide with animations
function showModal(modalId) {
    const modal = document.getElementById(modalId);
    const content = modal.querySelector('[id$="Content"]');
    
    modal.classList.remove('hidden');
    
    // Trigger animation
    setTimeout(() => {
        content.classList.add('modal-enter');
    }, 10);
    
    // Prevent body scroll
    document.body.style.overflow = 'hidden';
}

function hideModal(modalId) {
    const modal = document.getElementById(modalId);
    const content = modal.querySelector('[id$="Content"]');
    
    content.classList.remove('modal-enter');
    
    setTimeout(() => {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }, 300);
}

// Enhanced click outside to close
document.getElementById('removeModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeRemoveModal();
    }
});

document.getElementById('clearModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeClearModal();
    }
});

// Enhanced keyboard navigation
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        if (!document.getElementById('removeModal').classList.contains('hidden')) {
            closeRemoveModal();
        }
        if (!document.getElementById('clearModal').classList.contains('hidden')) {
            closeClearModal();
        }
    }
});

// Enhanced form validation
document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', function(e) {
        const quantityInputs = form.querySelectorAll('input[name="quantity"]');
        quantityInputs.forEach(input => {
            const value = parseInt(input.value);
            const min = parseInt(input.getAttribute('min'));
            const max = parseInt(input.getAttribute('max'));
            
            if (value < min || value > max) {
                e.preventDefault();
                input.classList.add('border-red-500', 'bg-red-50');
                setTimeout(() => {
                    input.classList.remove('border-red-500', 'bg-red-50');
                }, 2000);
            }
        });
    });
});

// Smooth scroll for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Enhanced loading states for forms
document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', function() {
        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn) {
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = `
                <svg class="w-5 h-5 mr-2 animate-spin inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Memproses...
            `;
            submitBtn.disabled = true;
        }
    });
});

// Page reload after form submission to update cart counts
document.addEventListener('DOMContentLoaded', function() {
    // Check if we need to reload cart data after operations
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('updated') === 'true') {
        // Remove the parameter from URL
        window.history.replaceState({}, document.title, window.location.pathname);
    }
    
    // Add event listeners for quantity input changes with validation
    document.querySelectorAll('input[name="quantity"]').forEach(input => {
        // Store original value
        input.dataset.originalValue = input.value;
        
        // Input validation on change
        input.addEventListener('input', function() {
            const value = parseInt(this.value) || 0;
            const min = parseInt(this.getAttribute('min')) || 1;
            const max = parseInt(this.getAttribute('max')) || 999;
            
            // Validate range
            if (value < min) {
                this.value = min;
            } else if (value > max) {
                this.value = max;
                // Show warning
                this.classList.add('border-red-500', 'bg-red-50');
                setTimeout(() => {
                    this.classList.remove('border-red-500', 'bg-red-50');
                }, 2000);
            }
        });
        
        // Visual feedback for changed values
        input.addEventListener('change', function() {
            const currentValue = parseInt(this.value) || 0;
            const originalValue = parseInt(this.dataset.originalValue) || 0;
            
            if (currentValue !== originalValue) {
                this.classList.add('bg-yellow-50', 'border-yellow-300');
                // Update original value
                this.dataset.originalValue = this.value;
            } else {
                this.classList.remove('bg-yellow-50', 'border-yellow-300');
            }
        });
        
        // Prevent non-numeric input
        input.addEventListener('keypress', function(e) {
            // Allow only numbers, backspace, delete, tab, escape, enter
            if ([46, 8, 9, 27, 13].indexOf(e.keyCode) !== -1 ||
                // Allow Ctrl+A, Ctrl+C, Ctrl+V, Ctrl+X
                (e.keyCode === 65 && e.ctrlKey === true) ||
                (e.keyCode === 67 && e.ctrlKey === true) ||
                (e.keyCode === 86 && e.ctrlKey === true) ||
                (e.keyCode === 88 && e.ctrlKey === true)) {
                return;
            }
            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });
        
        // Prevent paste of non-numeric values
        input.addEventListener('paste', function(e) {
            const paste = (e.clipboardData || window.clipboardData).getData('text');
            if (!/^\d+$/.test(paste)) {
                e.preventDefault();
            }
        });
    });
    
    // Add form submission validation
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function(e) {
            const quantityInputs = form.querySelectorAll('input[name="quantity"]');
            let hasError = false;
            
            quantityInputs.forEach(input => {
                const value = parseInt(input.value) || 0;
                const min = parseInt(input.getAttribute('min')) || 1;
                const max = parseInt(input.getAttribute('max')) || 999;
                
                if (value < min || value > max) {
                    hasError = true;
                    input.classList.add('border-red-500', 'bg-red-50');
                    input.focus();
                    
                    // Show error message
                    let errorMsg = input.parentElement.querySelector('.error-message');
                    if (!errorMsg) {
                        errorMsg = document.createElement('div');
                        errorMsg.className = 'error-message text-red-500 text-xs mt-1';
                        input.parentElement.appendChild(errorMsg);
                    }
                    errorMsg.textContent = `Jumlah harus antara ${min} dan ${max}`;
                    
                    setTimeout(() => {
                        input.classList.remove('border-red-500', 'bg-red-50');
                        if (errorMsg) errorMsg.remove();
                    }, 3000);
                }
            });
            
            if (hasError) {
                e.preventDefault();
                return false;
            }
        });
    });
});
</script>

<?php
$content = ob_get_clean();
require_once 'app/views/layouts/landing.php';
?>
