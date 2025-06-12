<?php
$title = 'Kayra Bakery - Toko Roti Terbaik';

// Helper function untuk mendapatkan base URL
if (!function_exists('getBaseUrl')) {
    function getBaseUrl() {
        $script_name = $_SERVER['SCRIPT_NAME'];
        $base_path = dirname($script_name);
        return $base_path === '/' ? '' : $base_path;
    }
}
$baseUrl = getBaseUrl();

ob_start();
?>

<!-- Hero Section -->
<section id="home" class="relative py-20 flex items-center justify-center min-h-[80vh] bg-gradient-to-br from-soft-pink-100 via-pink-100 to-pink-200 overflow-hidden">
    <!-- Background Image Overlay -->
    <div class="absolute inset-0 bg-cover bg-center bg-no-repeat opacity-40" 
         style="background-image: url('https://images.unsplash.com/photo-1586985289688-ca3cf47d3e6e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80')"></div>
    
    <!-- Gradient Overlay -->
    <div class="absolute inset-0 bg-gradient-to-br from-soft-pink-200/40 via-pink-100/30 to-pink-200/40"></div>
    
    <!-- Animated Background Elements -->
    <div class="absolute inset-0 opacity-15">
        <div class="absolute top-16 left-16 w-32 h-32 bg-soft-pink-300 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute top-48 right-24 w-40 h-40 bg-pink-300 rounded-full blur-3xl animate-pulse delay-1000"></div>
        <div class="absolute bottom-32 left-1/4 w-36 h-36 bg-soft-pink-400 rounded-full blur-3xl animate-pulse delay-2000"></div>
        <div class="absolute bottom-16 right-1/3 w-28 h-28 bg-pink-400 rounded-full blur-3xl animate-pulse delay-3000"></div>
    </div>
    
    <!-- Floating Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 left-10 w-4 h-4 bg-white/40 rounded-full animate-float"></div>
        <div class="absolute top-40 right-20 w-3 h-3 bg-pink-300/60 rounded-full animate-float delay-1000"></div>
        <div class="absolute bottom-40 left-20 w-5 h-5 bg-soft-pink-400/50 rounded-full animate-float delay-2000"></div>
        <div class="absolute bottom-20 right-16 w-4 h-4 bg-white/50 rounded-full animate-float delay-3000"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
        <div class="animate-fade-in-up">
            <!-- Main Title with Enhanced Styling -->
            <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-bold text-gray-800 mb-8 leading-tight">
                <span class="bg-gradient-to-r from-soft-pink-500 via-pink-500 to-pink-600 bg-clip-text text-transparent drop-shadow-sm">
                    Kayra Bakery
                </span>
                <br>
                <span class="text-gray-700 text-3xl sm:text-4xl md:text-5xl lg:text-6xl">
                    & Cake
                </span>
            </h1>
            
            <!-- Subtitle with Better Typography -->
            <p class="text-lg sm:text-xl md:text-2xl lg:text-3xl text-gray-700 mb-12 max-w-4xl mx-auto leading-relaxed font-medium">
                Nikmati kelezatan roti dan kue terbaik yang dibuat dengan 
                <span class="text-soft-pink-600 font-semibold">cinta</span> dan 
                <span class="text-pink-600 font-semibold">bahan-bahan premium</span> 
                untuk keluarga Indonesia
            </p>
            
            <!-- Enhanced CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-6 justify-center items-center">
                <a href="#products" class="group relative bg-gradient-to-r from-soft-pink-400 to-pink-500 text-white px-10 py-4 rounded-full font-bold text-lg hover:from-soft-pink-500 hover:to-pink-600 transition-all duration-300 transform hover:scale-105 shadow-xl hover:shadow-2xl">
                    <span class="relative z-10 flex items-center">
                        <svg class="w-6 h-6 mr-3 group-hover:animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        Lihat Produk
                    </span>
                    <!-- Shine effect -->
                    <div class="absolute inset-0 rounded-full bg-gradient-to-r from-transparent via-white/20 to-transparent transform skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
                </a>
                
                <a href="#about" class="group border-3 border-gray-400 text-gray-700 px-10 py-4 rounded-full font-bold text-lg hover:bg-white/80 hover:border-soft-pink-400 hover:text-soft-pink-600 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl backdrop-blur-sm">
                    <span class="flex items-center">
                        <svg class="w-6 h-6 mr-3 group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Tentang Kami
                    </span>
                </a>
            </div>
            
            <!-- Scroll Indicator -->
            <div class="mt-16 animate-bounce">
                <svg class="w-6 h-6 mx-auto text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                </svg>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section id="about" class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-6">
                Tentang <span class="text-soft-pink-400">Kayra Bakery & Cake</span>
            </h2>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto leading-relaxed">
                Kami adalah toko roti yang berkomitmen menghadirkan produk berkualitas tinggi dengan cita rasa yang tak terlupakan untuk keluarga Indonesia
            </p>
        </div>
        
        <div class="grid md:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="text-center p-8 rounded-xl bg-white border border-gray-200 hover:shadow-lg hover:border-soft-pink-200 transition-all duration-300 transform hover:-translate-y-1">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Chef Berpengalaman</h3>
                <p class="text-gray-600 leading-relaxed">
                    Tim chef kami memiliki pengalaman puluhan tahun dalam menciptakan roti dan kue berkualitas premium dengan standar internasional
                </p>
            </div>
            
            <!-- Feature 2 -->
            <div class="text-center p-8 rounded-xl bg-white border border-gray-200 hover:shadow-lg hover:border-soft-pink-200 transition-all duration-300 transform hover:-translate-y-1">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Bahan Premium</h3>
                <p class="text-gray-600 leading-relaxed">
                    Menggunakan bahan-bahan terbaik dan segar yang dipilih secara selektif untuk memastikan kualitas dan rasa yang sempurna
                </p>
            </div>
            
            <!-- Feature 3 -->
            <div class="text-center p-8 rounded-xl bg-white border border-gray-200 hover:shadow-lg hover:border-soft-pink-200 transition-all duration-300 transform hover:-translate-y-1">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Dibuat dengan Cinta</h3>
                <p class="text-gray-600 leading-relaxed">
                    Setiap produk dibuat dengan penuh perhatian dan cinta untuk memberikan pengalaman kuliner terbaik bagi pelanggan
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Products Section -->
<section id="products" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-6">
                Produk <span class="text-soft-pink-400">Unggulan</span>
            </h2>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto leading-relaxed">
                Koleksi roti dan kue terbaik yang siap memanjakan lidah Anda dengan cita rasa yang tak terlupakan
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
            <?php if (!empty($randomProducts)): ?>
                <?php foreach ($randomProducts as $product): ?>
                    <div class="group bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-gray-100 hover:border-soft-pink-200">
                        <!-- Product Image -->
                        <div class="relative h-64 bg-gradient-to-br from-gray-50 to-gray-100 overflow-hidden">
                            <img class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" 
                                 src="<?= $product->getImageUrl() ?>" 
                                 alt="<?= htmlspecialchars($product->name) ?>"
                                 onerror="this.style.display='none'; this.parentElement.style.background='linear-gradient(to bottom right, #f9fafb, #f3f4f6)';">
                            
                            <!-- Stock Badge -->
                            <div class="absolute top-4 right-4">
                                <span class="bg-white/90 backdrop-blur-sm text-gray-700 text-sm font-medium px-4 py-2 rounded-full shadow-sm">
                                    Stok: <?= $product->stock ?>
                                </span>
                            </div>
                        </div>
                        
                        <!-- Product Info -->
                        <div class="p-8">
                            <!-- Product Name -->
                            <h3 class="text-2xl font-bold text-gray-800 mb-4 line-clamp-2 group-hover:text-soft-pink-600 transition-colors duration-200">
                                <?= htmlspecialchars($product->name) ?>
                            </h3>
                            
                            <!-- Product Description -->
                            <p class="text-gray-600 mb-6 leading-relaxed line-clamp-3">
                                <?= htmlspecialchars($product->description) ?>
                            </p>
                            
                            <!-- Price -->
                            <div class="mb-8">
                                <span class="text-3xl font-bold text-soft-pink-600"><?= $product->getFormattedPrice() ?></span>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="space-y-4">
                                <?php 
                                $currentUser = getCurrentUser();
                                $isUserRole = $currentUser && $currentUser['role'] === 'user';
                                ?>
                                
                                <?php if ($isUserRole): ?>
                                    <button onclick="addToCart(<?= $product->id ?>, '<?= htmlspecialchars($product->name) ?>', event)" 
                                            class="w-full bg-gradient-to-r from-soft-pink-500 to-pink-500 text-white px-8 py-4 rounded-xl hover:from-soft-pink-600 hover:to-pink-600 transition-all duration-200 font-semibold flex items-center justify-center group/btn transform hover:scale-105 shadow-lg hover:shadow-xl text-lg">
                                        <svg class="w-6 h-6 mr-3 group-hover/btn:animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 11-4 0v-6m4 0V9a2 2 0 10-4 0v4.01"/>
                                        </svg>
                                        Tambah ke Keranjang
                                    </button>
                                <?php elseif (isLoggedIn() && $currentUser['role'] === 'admin'): ?>
                                    <div class="w-full bg-gray-100 text-gray-500 px-8 py-4 rounded-xl font-semibold flex items-center justify-center text-lg border-2 border-dashed border-gray-300">
                                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Admin Mode - Tidak Bisa Berbelanja
                                    </div>
                                <?php else: ?>
                                    <a href="<?= $baseUrl ?>/login" 
                                       class="block w-full text-center bg-gradient-to-r from-soft-pink-500 to-pink-500 text-white px-8 py-4 rounded-xl hover:from-soft-pink-600 hover:to-pink-600 transition-all duration-200 font-semibold transform hover:scale-105 shadow-lg hover:shadow-xl text-lg">
                                        Login untuk Pesan
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Fallback static products if no products in database -->
                <div class="group bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-gray-100">
                    <div class="h-64 bg-gradient-to-br from-gray-50 to-gray-100 relative">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="w-24 h-24 bg-soft-pink-100 rounded-full flex items-center justify-center">
                                <svg class="w-12 h-12 text-soft-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="p-8">
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">Roti Tawar Premium</h3>
                        <p class="text-gray-600 mb-6 leading-relaxed">Roti tawar lembut dengan tekstur yang sempurna untuk sarapan keluarga</p>
                        <div class="mb-8">
                            <span class="text-3xl font-bold text-soft-pink-600">Rp 15.000</span>
                        </div>
                        <a href="<?= $baseUrl ?>/products" class="block w-full text-center bg-gradient-to-r from-soft-pink-500 to-pink-500 text-white px-8 py-4 rounded-xl hover:from-soft-pink-600 hover:to-pink-600 transition-all duration-200 font-semibold transform hover:scale-105 shadow-lg text-lg">
                            Lihat Produk
                        </a>
                    </div>
                </div>
                
                <div class="group bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-gray-100">
                    <div class="h-64 bg-gradient-to-br from-gray-50 to-gray-100 relative">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="w-24 h-24 bg-soft-pink-100 rounded-full flex items-center justify-center">
                                <svg class="w-12 h-12 text-soft-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="p-8">
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">Croissant Butter</h3>
                        <p class="text-gray-600 mb-6 leading-relaxed">Croissant renyah dengan lapisan butter yang lezat dan aroma menggoda</p>
                        <div class="mb-8">
                            <span class="text-3xl font-bold text-soft-pink-600">Rp 25.000</span>
                        </div>
                        <a href="<?= $baseUrl ?>/products" class="block w-full text-center bg-gradient-to-r from-soft-pink-500 to-pink-500 text-white px-8 py-4 rounded-xl hover:from-soft-pink-600 hover:to-pink-600 transition-all duration-200 font-semibold transform hover:scale-105 shadow-lg text-lg">
                            Lihat Produk
                        </a>
                    </div>
                </div>
                
                <div class="group bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-gray-100">
                    <div class="h-64 bg-gradient-to-br from-gray-50 to-gray-100 relative">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="w-24 h-24 bg-soft-pink-100 rounded-full flex items-center justify-center">
                                <svg class="w-12 h-12 text-soft-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="p-8">
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">Birthday Cake</h3>
                        <p class="text-gray-600 mb-6 leading-relaxed">Kue ulang tahun custom dengan berbagai rasa dan desain menarik</p>
                        <div class="mb-8">
                            <span class="text-3xl font-bold text-soft-pink-600">Rp 150.000</span>
                        </div>
                        <a href="<?= $baseUrl ?>/products" class="block w-full text-center bg-gradient-to-r from-soft-pink-500 to-pink-500 text-white px-8 py-4 rounded-xl hover:from-soft-pink-600 hover:to-pink-600 transition-all duration-200 font-semibold transform hover:scale-105 shadow-lg text-lg">
                            Lihat Produk
                        </a>
                    </div>
                </div>
                
                <div class="group bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-gray-100">
                    <div class="h-64 bg-gradient-to-br from-gray-50 to-gray-100 relative">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="w-24 h-24 bg-soft-pink-100 rounded-full flex items-center justify-center">
                                <svg class="w-12 h-12 text-soft-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="p-8">
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">Cupcake Vanilla</h3>
                        <p class="text-gray-600 mb-6 leading-relaxed">Cupcake lembut dengan topping cream vanilla yang manis dan lezat</p>
                        <div class="mb-8">
                            <span class="text-3xl font-bold text-soft-pink-600">Rp 12.000</span>
                        </div>
                        <a href="<?= getBaseUrl() ?>/products" class="block w-full text-center bg-gradient-to-r from-soft-pink-500 to-pink-500 text-white px-8 py-4 rounded-xl hover:from-soft-pink-600 hover:to-pink-600 transition-all duration-200 font-semibold transform hover:scale-105 shadow-lg text-lg">
                            Lihat Produk
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="text-center mt-12">
            <a href="<?= getBaseUrl() ?>/products" class="bg-gradient-to-r from-soft-pink-300 to-pink-400 text-white px-8 py-3 rounded-full font-semibold hover:from-soft-pink-400 hover:to-pink-500 transition-all duration-200 transform hover:scale-105 shadow-lg">
                Lihat Semua Produk
            </a>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section id="contact" class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-6">
                Hubungi <span class="text-soft-pink-400">Kami</span>
            </h2>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto leading-relaxed">
                Kami siap melayani Anda dengan sepenuh hati dan memberikan pelayanan terbaik
            </p>
        </div>
        
        <div class="grid md:grid-cols-2 gap-12 items-start">
            <!-- Contact Info -->
            <div class="space-y-6">
                <div class="flex items-start space-x-4 p-6 rounded-xl bg-white border border-gray-200 hover:border-soft-pink-200 transition-colors duration-200">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800 mb-2">Alamat</h3>
                        <p class="text-gray-600">Jalan Sarijadi, Bandung</p>
                    </div>
                </div>
                
                <div class="flex items-start space-x-4 p-6 rounded-xl bg-white border border-gray-200 hover:border-soft-pink-200 transition-colors duration-200">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800 mb-2">Telepon</h3>
                        <p class="text-gray-600">+62 812-3456-7890</p>
                    </div>
                </div>
                
                <div class="flex items-start space-x-4 p-6 rounded-xl bg-white border border-gray-200 hover:border-soft-pink-200 transition-colors duration-200">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800 mb-2">Email</h3>
                        <p class="text-gray-600">info@kayrabakery.com</p>
                    </div>
                </div>
                
                <div class="flex items-start space-x-4 p-6 rounded-xl bg-white border border-gray-200 hover:border-soft-pink-200 transition-colors duration-200">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800 mb-2">Jam Buka</h3>
                        <p class="text-gray-600">Senin - Minggu: 07:00 - 21:00</p>
                    </div>
                </div>
            </div>
            
            <!-- Contact Form -->
            <div class="bg-white p-8 rounded-xl border border-gray-200 shadow-lg">
                <h3 class="text-xl font-bold text-gray-800 mb-6">Kirim Pesan</h3>
                <form class="space-y-4">
                    <div>
                        <label class="block font-semibold text-gray-700 mb-2">Nama</label>
                        <input type="text" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-soft-pink-300 focus:border-soft-pink-400 transition-colors duration-200" placeholder="Nama Anda">
                    </div>
                    <div>
                        <label class="block font-semibold text-gray-700 mb-2">Email</label>
                        <input type="email" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-soft-pink-300 focus:border-soft-pink-400 transition-colors duration-200" placeholder="Email Anda">
                    </div>
                    <div>
                        <label class="block font-semibold text-gray-700 mb-2">Pesan</label>
                        <textarea rows="4" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-soft-pink-300 focus:border-soft-pink-400 transition-colors duration-200" placeholder="Pesan Anda"></textarea>
                    </div>
                    <button type="submit" class="w-full bg-gradient-to-r from-soft-pink-300 to-pink-400 text-white font-semibold py-3 px-6 rounded-lg hover:from-soft-pink-400 hover:to-pink-500 transition-all duration-200 transform hover:scale-105 shadow-lg">
                        Kirim Pesan
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
    const BASE_URL = "<?= $baseUrl ?>";
</script>

<?php
$content = ob_get_clean();

// Add JavaScript for add to cart functionality
$additional_scripts = '
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
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(40px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-float {
    animation: float 3s ease-in-out infinite;
}

.animate-fade-in-up {
    animation: fadeInUp 0.8s ease-out;
}

/* Pulse animation with delays */
.delay-1000 { animation-delay: 1000ms; }
.delay-2000 { animation-delay: 2000ms; }
.delay-3000 { animation-delay: 3000ms; }

/* Border width utility */
.border-3 {
    border-width: 3px;
}

/* Backdrop blur fallback */
@supports not (backdrop-filter: blur(4px)) {
    .backdrop-blur-sm {
        background-color: rgba(255, 255, 255, 0.9);
    }
}

/* Custom scrollbar for webkit browsers */
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

/* Enhanced hover effects */
.group:hover .group-hover\:animate-bounce {
    animation: bounce 1s infinite;
}

.group:hover .group-hover\:rotate-12 {
    transform: rotate(12deg);
}

/* Responsive text scaling */
@media (max-width: 640px) {
    .text-responsive {
        font-size: clamp(1.5rem, 8vw, 3rem);
    }
}
</style>

<script>
// Add to cart functionality
async function addToCart(productId, productName, event) {
    try {
        // Show loading state
        const button = event.target;
        const originalText = button.innerHTML;
        button.innerHTML = `
            <svg class="w-5 h-5 mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
            </svg>
            Menambahkan...
        `;
        button.disabled = true;
        
        // Send AJAX request - Try two different URL formats
        const apiUrl = BASE_URL + "/carts/add";
        const absoluteUrl = window.location.origin + BASE_URL + "/carts/add";
        
        console.log("BASE_URL:", BASE_URL);
        console.log("Trying API URL:", apiUrl);
        console.log("Absolute URL would be:", absoluteUrl);
        console.log("Current window location:", window.location.href);
        
        const response = await fetch(apiUrl, {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body: `product_id=${productId}&quantity=1`
        });
        
        // Check if response is ok
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        // Check if response is JSON
        const contentType = response.headers.get("content-type");
        if (!contentType || !contentType.includes("application/json")) {
            const text = await response.text();
            console.error("Response is not JSON:", text);
            throw new Error("Response dari server bukan format JSON yang valid");
        }
        
        const result = await response.json();
        
        if (result.success) {
            // Show success message
            showNotification("success", result.message);
            
            // Update cart count if exists
            updateCartCount(result.cart_count);
            
            // Change button to success state temporarily
            button.innerHTML = `
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Berhasil Ditambahkan!
            `;
            button.classList.remove("from-soft-pink-500", "to-pink-500", "hover:from-soft-pink-600", "hover:to-pink-600");
            button.classList.add("from-green-500", "to-green-600", "hover:from-green-600", "hover:to-green-700");
            
            // Reset button after 2 seconds
            setTimeout(() => {
                button.innerHTML = originalText;
                button.classList.remove("from-green-500", "to-green-600", "hover:from-green-600", "hover:to-green-700");
                button.classList.add("from-soft-pink-500", "to-pink-500", "hover:from-soft-pink-600", "hover:to-pink-600");
                button.disabled = false;
            }, 2000);
        } else {
            // Show error message
            showNotification("error", result.message);
            
            // Reset button
            button.innerHTML = originalText;
            button.disabled = false;
        }
    } catch (error) {
        console.error("Error adding to cart:", error);
        showNotification("error", "Terjadi kesalahan saat menambahkan ke keranjang");
        
        // Reset button
        const button = event.target;
        button.innerHTML = `
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 11-4 0v-6m4 0V9a2 2 0 10-4 0v4.01"/>
            </svg>
            Tambah ke Keranjang
        `;
        button.disabled = false;
    }
}

// Show notification with enhanced styling
function showNotification(type, message) {
    // Create notification element
    const notification = document.createElement("div");
    notification.className = `fixed top-6 right-6 z-50 p-4 rounded-xl shadow-2xl max-w-sm transform transition-all duration-300 translate-x-full`;
    
    if (type === "success") {
        notification.classList.add("bg-gradient-to-r", "from-green-500", "to-green-600", "text-white");
        notification.innerHTML = `
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="font-semibold">Berhasil!</p>
                    <p class="text-sm opacity-90">${message}</p>
                </div>
            </div>
        `;
    } else {
        notification.classList.add("bg-gradient-to-r", "from-red-500", "to-red-600", "text-white");
        notification.innerHTML = `
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="font-semibold">Oops!</p>
                    <p class="text-sm opacity-90">${message}</p>
                </div>
            </div>
        `;
    }
    
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.classList.remove("translate-x-full");
        notification.classList.add("translate-x-0");
    }, 100);
    
    // Auto remove after 4 seconds
    setTimeout(() => {
        notification.classList.remove("translate-x-0");
        notification.classList.add("translate-x-full");
        setTimeout(() => {
            if (document.body.contains(notification)) {
                document.body.removeChild(notification);
            }
        }, 300);
    }, 4000);
}

// Update cart count with enhanced animation
function updateCartCount(count) {
    const cartCountElements = document.querySelectorAll(".cart-count");
    cartCountElements.forEach(element => {
        // Check if this is the badge or the text counter
        if (element.classList.contains("absolute")) {
            // This is the badge - show number only
            element.textContent = count;
        } else {
            // This is the text counter - show "X item(s)"
            element.textContent = count + (count === 1 ? " item" : " item");
        }
        
        if (count > 0) {
            element.classList.remove("hidden");
            // Add bounce animation only once
            if (!element.classList.contains("animate-bounce")) {
                element.classList.add("animate-bounce");
                setTimeout(() => {
                    element.classList.remove("animate-bounce");
                }, 1000);
            }
        } else {
            element.classList.add("hidden");
        }
    });
}

// Add intersection observer for scroll animations
document.addEventListener("DOMContentLoaded", function() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: "0px 0px -50px 0px"
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add("animate-fade-in-up");
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    // Observe product cards
    document.querySelectorAll(".group").forEach(card => {
        observer.observe(card);
    });
});
</script>
';

require_once 'app/views/layouts/landing.php';
?> 