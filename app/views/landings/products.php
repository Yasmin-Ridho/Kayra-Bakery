<?php
$title = 'Produk - Kayra Bakery & Cake';

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

<!-- Hero Section -->
<section class="relative py-16 sm:py-20 lg:py-24 bg-gradient-to-br from-soft-pink-100 via-pink-100 to-pink-200 overflow-hidden">
    <!-- Background Image Overlay -->
    <div class="absolute inset-0 bg-cover bg-center bg-no-repeat opacity-35" 
         style="background-image: url('https://images.unsplash.com/photo-1578985545062-69928b1d9587?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2089&q=80')"></div>
    
    <!-- Gradient Overlay -->
    <div class="absolute inset-0 bg-gradient-to-br from-soft-pink-200/35 via-pink-100/25 to-pink-200/35"></div>
    
    <!-- Animated Background Elements -->
    <div class="absolute inset-0 opacity-15">
        <div class="absolute top-10 left-10 w-32 h-32 bg-soft-pink-300 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute top-32 right-20 w-40 h-40 bg-pink-300 rounded-full blur-3xl animate-pulse delay-1000"></div>
        <div class="absolute bottom-20 left-1/3 w-36 h-36 bg-soft-pink-400 rounded-full blur-3xl animate-pulse delay-2000"></div>
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
            <!-- Enhanced Breadcrumb -->
            <nav class="flex justify-center mb-8 sm:mb-10" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-2 md:space-x-4 text-sm bg-white/80 backdrop-blur-lg rounded-full px-6 py-3 shadow-xl border border-white/30">
                    <li class="inline-flex items-center">
                        <a href="<?= $baseUrl ?>/" class="text-gray-600 hover:text-soft-pink-600 transition-colors duration-200 flex items-center font-medium">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                            </svg>
                            Beranda
                        </a>
                    </li>
                    <li>
                        <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </li>
                    <li>
                        <span class="text-gray-800 font-bold">Produk</span>
                    </li>
                </ol>
            </nav>
            
            <!-- Enhanced Title with Animation -->
            <div class="animate-fade-in-up">
                <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-bold text-gray-800 mb-6 sm:mb-8 leading-tight">
                    <span class="bg-gradient-to-r from-soft-pink-500 via-pink-500 to-pink-600 bg-clip-text text-transparent drop-shadow-sm">
                        Produk
                    </span>
                    <br class="hidden sm:block">
                    <span class="text-gray-700">Terbaik Kami</span>
                </h1>
                
                <p class="text-lg sm:text-xl md:text-2xl lg:text-3xl text-gray-700 max-w-4xl mx-auto leading-relaxed px-4 font-medium mb-8">
                    Temukan koleksi roti dan kue terbaik yang dibuat dengan 
                    <span class="text-soft-pink-600 font-semibold">cinta</span> dan 
                    <span class="text-pink-600 font-semibold">bahan berkualitas premium</span>
                </p>
                
                <!-- Featured Badge -->
                <div class="flex justify-center mb-8">
                    <div class="inline-flex items-center bg-gradient-to-r from-soft-pink-50 to-pink-50 border-2 border-soft-pink-200 rounded-full px-6 py-3 shadow-lg">
                        <svg class="w-5 h-5 text-soft-pink-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <span class="text-soft-pink-700 font-semibold">Dipilih Khusus untuk Anda</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Enhanced Flash Messages -->
<?php if ($successMessage = getFlashMessage('success')): ?>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
        <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-400 rounded-2xl p-6 shadow-xl animate-slide-in">
            <div class="flex items-center">
                <div class="flex-shrink-0 mr-4">
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                        <svg class="h-6 w-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="flex-1">
                    <p class="text-base font-semibold text-green-800"><?= htmlspecialchars($successMessage) ?></p>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if ($errorMessage = getFlashMessage('error')): ?>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
        <div class="bg-gradient-to-r from-red-50 to-red-50 border-l-4 border-red-400 rounded-2xl p-6 shadow-xl animate-slide-in">
            <div class="flex items-center">
                <div class="flex-shrink-0 mr-4">
                    <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                        <svg class="h-6 w-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="flex-1">
                    <p class="text-base font-semibold text-red-800"><?= htmlspecialchars($errorMessage) ?></p>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Search and Filter Section -->
<section class="py-12 sm:py-16 lg:py-20 bg-gradient-to-b from-white to-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Search and Filter Header -->
        <div class="mb-12">
            <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden">
                <div class="px-8 py-8 border-b border-gray-200 bg-gradient-to-r from-soft-pink-50 via-pink-50 to-soft-pink-100">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                        <div class="mb-6 lg:mb-0">
                            <h2 class="text-2xl font-bold text-gray-800 flex items-center mb-2">
                                <div class="w-12 h-12 bg-gradient-to-r from-soft-pink-500 to-pink-600 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                </div>
                                Cari Produk
                            </h2>
                            <p class="text-gray-600 ml-16">
                                Temukan produk favorit Anda dengan mudah
                            </p>
                        </div>
                        
                        <!-- Cart Button -->
                        <?php if (isLoggedIn()): ?>
                            <div class="flex items-center">
                                <a href="<?= $baseUrl ?>/carts" 
                                   class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-soft-pink-500 to-pink-600 text-white font-semibold rounded-xl hover:from-soft-pink-600 hover:to-pink-700 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 11-4 0v-6m4 0V9a2 2 0 10-4 0v4.01"/>
                                    </svg>
                                    Keranjang
                                    <span id="cart-count" class="ml-2 bg-white text-soft-pink-600 text-xs font-bold px-2 py-1 rounded-full">0</span>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Search and Filter Controls -->
                <div class="p-8">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                        <!-- Search Input -->
                        <div class="lg:col-span-6">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                </div>
                                <input type="text" 
                                       id="searchInput"
                                       class="block w-full pl-12 pr-4 py-4 border border-gray-300 rounded-xl leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-2 focus:ring-soft-pink-500 focus:border-soft-pink-500 text-lg" 
                                       placeholder="Cari nama produk...">
                            </div>
                        </div>
                        
                        <!-- Category Filter -->
                        <div class="lg:col-span-3">
                            <select id="categoryFilter" class="block w-full px-4 py-4 border border-gray-300 rounded-xl bg-white text-gray-700 focus:outline-none focus:ring-2 focus:ring-soft-pink-500 focus:border-soft-pink-500 text-lg">
                                <option value="">Semua Kategori</option>
                                <?php if (!empty($categories)): ?>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?= $category->id ?>"><?= htmlspecialchars($category->name) ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        
                        <!-- Sort Filter -->
                        <div class="lg:col-span-3">
                            <select id="sortFilter" class="block w-full px-4 py-4 border border-gray-300 rounded-xl bg-white text-gray-700 focus:outline-none focus:ring-2 focus:ring-soft-pink-500 focus:border-soft-pink-500 text-lg">
                                <option value="name_asc">Nama A-Z</option>
                                <option value="name_desc">Nama Z-A</option>
                                <option value="price_asc">Harga Terendah</option>
                                <option value="price_desc">Harga Tertinggi</option>
                                <option value="newest">Terbaru</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <div id="products-container">
            <?php if (!empty($products)): ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8" id="products-grid">
                    <?php foreach ($products as $product): ?>
                        <div class="product-card bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden"
                             data-name="<?= strtolower($product->name) ?>"
                             data-category="<?= $product->category_id ?>"
                             data-price="<?= $product->price ?>"
                             data-created="<?= strtotime($product->created_at ?? '2024-01-01') ?>">
                            
                            <!-- Product Image -->
                            <div class="relative h-64 bg-gradient-to-br from-gray-50 to-gray-100 overflow-hidden">
                                <img class="w-full h-full object-cover" 
                                     src="<?= htmlspecialchars(getBaseUrl().'/storage/products/'.$product->image ?? '') ?>" 
                                     alt="<?= htmlspecialchars($product->name) ?>"
                                     onerror="this.src='<?= $baseUrl ?>/assets/images/placeholder-product.jpg'">
                                
                                <!-- Stock Badge -->
                                <div class="absolute top-4 right-4">
                                    <?php if ($product->stock > 0): ?>
                                        <span class="bg-green-100 text-green-800 text-sm font-medium px-3 py-1 rounded-full shadow-sm">
                                            Stok: <?= $product->stock ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="bg-red-100 text-red-800 text-sm font-medium px-3 py-1 rounded-full shadow-sm">
                                            Habis
                                        </span>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Category Badge -->
                                <div class="absolute top-4 left-4">
                                    <span class="bg-white/90 backdrop-blur-sm text-gray-700 text-xs font-medium px-3 py-1 rounded-full shadow-sm">
                                        <?= htmlspecialchars($product->category_name ?? 'Umum') ?>
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Product Info -->
                            <div class="p-6">
                                <!-- Product Name -->
                                <h3 class="text-xl font-bold text-gray-800 mb-3 line-clamp-2">
                                    <?= htmlspecialchars($product->name) ?>
                                </h3>
                                
                                <!-- Product Description -->
                                <p class="text-gray-600 mb-4 leading-relaxed line-clamp-2 text-sm">
                                    <?= htmlspecialchars($product->description ?? 'Produk berkualitas tinggi dari Kayra Bakery') ?>
                                </p>
                                
                                <!-- Price -->
                                <div class="mb-6">
                                    <span class="text-2xl font-bold text-soft-pink-600">
                                        Rp <?= number_format($product->price, 0, ',', '.') ?>
                                    </span>
                                </div>
                                
                                <!-- Action Buttons -->
                                <div class="space-y-3">
                                    <?php if (isLoggedIn()): ?>
                                        <?php if ($product->stock > 0): ?>
                                            <button onclick="addToCart(<?= $product->id ?>, '<?= htmlspecialchars($product->name) ?>')" 
                                                    class="w-full bg-gradient-to-r from-soft-pink-500 to-pink-500 text-white px-6 py-3 rounded-xl hover:from-soft-pink-600 hover:to-pink-600 transition-all duration-200 font-semibold flex items-center justify-center group/btn transform hover:scale-105 shadow-lg hover:shadow-xl">
                                                <svg class="w-5 h-5 mr-2 group-hover/btn:animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 11-4 0v-6m4 0V9a2 2 0 10-4 0v4.01"/>
                                                </svg>
                                                Tambah ke Keranjang
                                            </button>
                                        <?php else: ?>
                                            <button disabled 
                                                    class="w-full bg-gray-300 text-gray-500 px-6 py-3 rounded-xl font-semibold cursor-not-allowed">
                                                Stok Habis
                                            </button>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <a href="<?= $baseUrl ?>/login" 
                                           class="block w-full text-center bg-gradient-to-r from-soft-pink-500 to-pink-500 text-white px-6 py-3 rounded-xl hover:from-soft-pink-600 hover:to-pink-600 transition-all duration-200 font-semibold transform hover:scale-105 shadow-lg hover:shadow-xl">
                                            Login untuk Pesan
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <!-- Empty State -->
                <div class="text-center py-16">
                    <div class="w-24 h-24 bg-gradient-to-r from-soft-pink-100 to-pink-100 rounded-full flex items-center justify-center mx-auto mb-8">
                        <svg class="w-12 h-12 text-soft-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Belum Ada Produk</h3>
                    <p class="text-gray-600 mb-8 max-w-md mx-auto leading-relaxed">
                        Produk sedang dalam persiapan. Silakan kembali lagi nanti untuk melihat koleksi terbaru kami.
                    </p>
                    <a href="<?= $baseUrl ?>/" 
                       class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-soft-pink-500 to-pink-600 text-white font-bold rounded-2xl hover:from-soft-pink-600 hover:to-pink-700 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Kembali ke Beranda
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <!-- No Results Message -->
        <div id="no-results" class="text-center py-16 hidden">
            <div class="w-24 h-24 bg-gradient-to-r from-gray-100 to-gray-200 rounded-full flex items-center justify-center mx-auto mb-8">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-800 mb-4">Produk Tidak Ditemukan</h3>
            <p class="text-gray-600 mb-8 max-w-md mx-auto leading-relaxed">
                Maaf, tidak ada produk yang sesuai dengan pencarian Anda. Coba gunakan kata kunci lain.
            </p>
            <button onclick="clearFilters()" 
                    class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-soft-pink-500 to-pink-600 text-white font-bold rounded-2xl hover:from-soft-pink-600 hover:to-pink-700 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Reset Filter
            </button>
        </div>
    </div>
</section>

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

/* Enhanced scrollbar */
::-webkit-scrollbar {
    width: 10px;
}

::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 6px;
}

::-webkit-scrollbar-thumb {
    background: linear-gradient(to bottom, #f472b6, #ec4899);
    border-radius: 6px;
}

::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(to bottom, #ec4899, #db2777);
}

/* Enhanced backdrop blur */
.backdrop-blur-sm {
    backdrop-filter: blur(4px);
}

/* Loading animation */
.loading {
    opacity: 0.5;
    pointer-events: none;
}

/* Fade transition for filtering */
.product-card {
    transition: opacity 0.3s ease-in-out;
}

.product-card.hidden {
    opacity: 0;
    pointer-events: none;
}
</style>

<script>
// Search and filter functionality
let products = [];
let filteredProducts = [];

// Initialize products array from DOM
document.addEventListener('DOMContentLoaded', function() {
    const productCards = document.querySelectorAll('.product-card');
    products = Array.from(productCards).map(card => ({
        element: card,
        name: card.dataset.name,
        category: card.dataset.category,
        price: parseFloat(card.dataset.price),
        created: parseInt(card.dataset.created)
    }));
    
    filteredProducts = [...products];
    
    // Add event listeners
    document.getElementById('searchInput').addEventListener('input', filterProducts);
    document.getElementById('categoryFilter').addEventListener('change', filterProducts);
    document.getElementById('sortFilter').addEventListener('change', filterProducts);
    
    // Update cart count on page load
    updateCartCount();
});

function filterProducts() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    const categoryFilter = document.getElementById('categoryFilter').value;
    const sortFilter = document.getElementById('sortFilter').value;
    
    // Filter products
    filteredProducts = products.filter(product => {
        const matchesSearch = product.name.includes(searchTerm);
        const matchesCategory = categoryFilter === '' || product.category === categoryFilter;
        
        return matchesSearch && matchesCategory;
    });
    
    // Sort products
    sortProducts(sortFilter);
    
    // Display results
    displayProducts();
}

function sortProducts(sortType) {
    switch (sortType) {
        case 'name_asc':
            filteredProducts.sort((a, b) => a.name.localeCompare(b.name));
            break;
        case 'name_desc':
            filteredProducts.sort((a, b) => b.name.localeCompare(a.name));
            break;
        case 'price_asc':
            filteredProducts.sort((a, b) => a.price - b.price);
            break;
        case 'price_desc':
            filteredProducts.sort((a, b) => b.price - a.price);
            break;
        case 'newest':
            filteredProducts.sort((a, b) => b.created - a.created);
            break;
    }
}

function displayProducts() {
    const grid = document.getElementById('products-grid');
    const noResults = document.getElementById('no-results');
    
    // Hide all products first
    products.forEach(product => {
        product.element.classList.add('hidden');
    });
    
    if (filteredProducts.length === 0) {
        // Show no results message
        if (grid) grid.style.display = 'none';
        noResults.classList.remove('hidden');
    } else {
        // Show filtered products
        if (grid) grid.style.display = 'grid';
        noResults.classList.add('hidden');
        
        // Clear grid and re-append in sorted order
        if (grid) {
            // Remove all children
            while (grid.firstChild) {
                grid.removeChild(grid.firstChild);
            }
            
            // Add filtered products in order
            filteredProducts.forEach(product => {
                product.element.classList.remove('hidden');
                grid.appendChild(product.element);
            });
        }
    }
}

function clearFilters() {
    document.getElementById('searchInput').value = '';
    document.getElementById('categoryFilter').value = '';
    document.getElementById('sortFilter').value = 'name_asc';
    filterProducts();
}

// Add to cart functionality
function addToCart(productId, productName) {
    // Show loading state
    const button = event.target;
    const originalText = button.innerHTML;
    button.innerHTML = '<svg class="w-5 h-5 mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>Menambahkan...';
    button.disabled = true;
    
    // Send AJAX request
    fetch('<?= $baseUrl ?>/carts/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `product_id=${productId}&quantity=1&_token=<?= getCSRFToken() ?>`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message
            showNotification('success', `${productName} berhasil ditambahkan ke keranjang!`);
            
            // Update cart count
            updateCartCount();
            
            // Restore button
            button.innerHTML = originalText;
            button.disabled = false;
        } else {
            throw new Error(data.message || 'Gagal menambahkan ke keranjang');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('error', error.message || 'Terjadi kesalahan saat menambahkan ke keranjang');
        
        // Restore button
        button.innerHTML = originalText;
        button.disabled = false;
    });
}

// Update cart count
function updateCartCount() {
    fetch('<?= $baseUrl ?>/carts/count', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        const cartCount = document.getElementById('cart-count');
        if (cartCount && data.count !== undefined) {
            cartCount.textContent = data.count;
        }
    })
    .catch(error => {
        console.error('Error updating cart count:', error);
    });
}

// Show notification
function showNotification(type, message) {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 max-w-sm w-full bg-white rounded-lg shadow-lg border-l-4 ${
        type === 'success' ? 'border-green-400' : 'border-red-400'
    } p-4 animate-slide-in`;
    
    notification.innerHTML = `
        <div class="flex items-center">
            <div class="flex-shrink-0 mr-3">
                <div class="w-8 h-8 ${type === 'success' ? 'bg-green-100' : 'bg-red-100'} rounded-full flex items-center justify-center">
                    <svg class="h-5 w-5 ${type === 'success' ? 'text-green-500' : 'text-red-500'}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        ${type === 'success' 
                            ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>'
                            : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>'
                        }
                    </svg>
                </div>
            </div>
            <div class="flex-1">
                <p class="text-sm font-medium ${type === 'success' ? 'text-green-800' : 'text-red-800'}">${message}</p>
            </div>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-3 text-gray-400 hover:text-gray-600">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (notification.parentElement) {
            notification.style.opacity = '0';
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => notification.remove(), 300);
        }
    }, 5000);
}

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
</script>

<?php
$content = ob_get_clean();
require_once 'app/views/layouts/landing.php';
?>
