<?php
$title = 'Checkout - Kayra Bakery & Cake';

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
<section class="relative py-12 sm:py-16 lg:py-20 bg-gradient-to-br from-soft-pink-50 via-pink-50 to-pink-100 overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-10 left-10 w-20 h-20 bg-soft-pink-300 rounded-full blur-xl"></div>
        <div class="absolute top-32 right-20 w-32 h-32 bg-pink-300 rounded-full blur-2xl"></div>
        <div class="absolute bottom-20 left-1/3 w-24 h-24 bg-soft-pink-400 rounded-full blur-xl"></div>
    </div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <!-- Breadcrumb -->
            <nav class="flex justify-center mb-6 sm:mb-8" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3 text-sm">
                    <li class="inline-flex items-center">
                        <a href="<?= $baseUrl ?>/" class="text-gray-500 hover:text-soft-pink-500 transition-colors duration-200">
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
                            <a href="<?= $baseUrl ?>/carts" class="ml-1 text-gray-500 hover:text-soft-pink-500 transition-colors duration-200">Keranjang</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span class="ml-1 text-gray-700 font-medium">Checkout</span>
                        </div>
                    </li>
                </ol>
            </nav>
            
            <!-- Title -->
            <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-gray-800 mb-4 sm:mb-6">
                <span class="bg-gradient-to-r from-soft-pink-500 to-pink-600 bg-clip-text text-transparent">
                    Checkout
                </span>
                <span class="text-gray-800">Pesanan</span>
            </h1>
            <p class="text-base sm:text-lg lg:text-xl text-gray-600 max-w-2xl mx-auto leading-relaxed px-4">
                Selesaikan pesanan Anda dengan upload bukti transfer untuk konfirmasi pembayaran
            </p>
        </div>
    </div>
</section>

<!-- Flash Messages -->
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

<?php if ($errorMessage = getFlashMessage('error')): ?>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6 sm:mt-8">
        <div class="bg-gradient-to-r from-red-50 to-red-100 border-l-4 border-red-400 rounded-xl p-4 sm:p-6 shadow-lg">
            <div class="flex flex-col sm:flex-row sm:items-center">
                <div class="flex-shrink-0 mb-3 sm:mb-0 sm:mr-4">
                    <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                        <svg class="h-5 w-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="flex-1">
                    <p class="text-sm sm:text-base font-medium text-red-800"><?= htmlspecialchars($errorMessage) ?></p>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Checkout Content -->
<section class="py-12 sm:py-16 lg:py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <form method="POST" action="<?= $baseUrl ?>/checkout" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Order Items -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                    <!-- Header -->
                    <div class="px-6 py-6 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                        <h3 class="text-xl font-bold text-gray-800 flex items-center">
                            <svg class="w-6 h-6 mr-3 text-soft-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            Detail Pesanan
                        </h3>
                        <p class="text-sm text-gray-600 mt-1">Periksa kembali item yang akan Anda beli</p>
                    </div>
                    
                    <!-- Items List -->
                    <div class="divide-y divide-gray-100">
                        <?php foreach ($checkoutItems as $item): ?>
                            <?php 
                            $cart = $item['cart'];
                            $product = $item['product'];
                            $subtotal = $item['subtotal'];
                            ?>
                            <div class="p-6 hover:bg-gradient-to-r hover:from-gray-50 hover:to-soft-pink-50 transition-all duration-300">
                                <div class="flex items-center space-x-4">
                                    <!-- Product Image -->
                                    <div class="flex-shrink-0">
                                        <img class="h-20 w-20 rounded-xl object-cover border-2 border-gray-200 shadow-md" 
                                             src="<?= $product->getImageUrl() ?>" 
                                             alt="<?= htmlspecialchars($product->name) ?>"
                                             onerror="this.src='<?= $baseUrl ?>/assets/images/placeholder-product.jpg'">
                                    </div>
                                    
                                    <!-- Product Info -->
                                    <div class="flex-1">
                                        <h4 class="text-lg font-bold text-gray-800 mb-2">
                                            <?= htmlspecialchars($product->name) ?>
                                        </h4>
                                        <p class="text-sm text-gray-600 mb-3 line-clamp-2">
                                            <?= htmlspecialchars($product->description) ?>
                                        </p>
                                        <div class="flex items-center space-x-4">
                                            <span class="text-lg font-bold bg-gradient-to-r from-soft-pink-500 to-pink-600 bg-clip-text text-transparent">
                                                <?= $product->getFormattedPrice() ?>
                                            </span>
                                            <span class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                                                Qty: <?= $cart->quantity ?>
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <!-- Subtotal -->
                                    <div class="text-right">
                                        <div class="text-xl font-bold text-gray-800">
                                            Rp <?= number_format($subtotal, 0, ',', '.') ?>
                                        </div>
                                        <div class="text-xs text-gray-500">Subtotal</div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            
            <!-- Payment Form -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden sticky top-8">
                    <!-- Header -->
                    <div class="px-6 py-6 border-b border-gray-200 bg-gradient-to-r from-soft-pink-50 to-pink-50">
                        <h3 class="text-xl font-bold text-gray-800 flex items-center">
                            <svg class="w-6 h-6 mr-3 text-soft-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                            Pembayaran
                        </h3>
                    </div>
                    
                    <div class="p-6">
                        <!-- Bank Info -->
                        <div class="mb-6 p-4 bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl border border-blue-200">
                            <h4 class="font-bold text-blue-800 mb-3 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                Transfer ke Rekening:
                            </h4>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-blue-700">Bank:</span>
                                    <span class="font-semibold text-blue-800">BCA</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-blue-700">No. Rekening:</span>
                                    <span class="font-semibold text-blue-800">1234567890</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-blue-700">Atas Nama:</span>
                                    <span class="font-semibold text-blue-800">Kayra Bakery & Cake</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Order Summary -->
                        <div class="mb-6 space-y-3">
                            <div class="flex justify-between items-center py-2 px-3 bg-gray-50 rounded-lg">
                                <span class="text-sm text-gray-600 font-medium">Total Item</span>
                                <span class="text-sm font-semibold text-gray-800 bg-soft-pink-100 text-soft-pink-700 px-2 py-0.5 rounded-full">
                                    <?= $totalItems ?> item
                                </span>
                            </div>
                            
                            <div class="flex justify-between items-center py-2 px-3 bg-gray-50 rounded-lg">
                                <span class="text-sm text-gray-600 font-medium">Subtotal</span>
                                <span class="text-sm font-bold text-gray-800">Rp <?= number_format($totalPrice, 0, ',', '.') ?></span>
                            </div>
                            
                            <div class="flex justify-between items-center py-2 px-3 bg-gray-50 rounded-lg">
                                <span class="text-sm text-gray-600 font-medium">Ongkos Kirim</span>
                                <span class="text-sm font-semibold text-green-600">Gratis</span>
                            </div>
                            
                            <div class="border-t border-gray-200 pt-3">
                                <div class="flex justify-between items-center py-3 px-4 bg-gradient-to-r from-soft-pink-50 to-pink-50 rounded-xl border border-soft-pink-200">
                                    <span class="text-base font-bold text-gray-800">Total Pembayaran</span>
                                    <span class="text-lg font-bold bg-gradient-to-r from-soft-pink-600 to-pink-600 bg-clip-text text-transparent">
                                        Rp <?= number_format($totalPrice, 0, ',', '.') ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Upload Payment Proof -->
                        <div class="mb-6">
                            <label class="block text-sm font-bold text-gray-800 mb-3">
                                <svg class="w-5 h-5 inline mr-2 text-soft-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                                Upload Bukti Transfer *
                            </label>
                            <div class="relative">
                                <input type="file" 
                                       name="payment_proof" 
                                       id="payment_proof"
                                       accept="image/*"
                                       required
                                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-3 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-gradient-to-r file:from-soft-pink-50 file:to-pink-50 file:text-soft-pink-700 hover:file:from-soft-pink-100 hover:file:to-pink-100 border border-gray-300 rounded-xl focus:ring-2 focus:ring-soft-pink-500 focus:border-soft-pink-500 transition-all duration-200">
                                <div class="mt-2 text-xs text-gray-500">
                                    Format: JPG, PNG, GIF. Maksimal 5MB
                                </div>
                            </div>
                            
                            <!-- Preview -->
                            <div id="imagePreview" class="mt-4 hidden">
                                <div class="relative inline-block">
                                    <img id="previewImg" class="h-32 w-32 object-cover rounded-xl border-2 border-gray-200 shadow-md">
                                    <button type="button" onclick="removePreview()" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600 transition-colors duration-200">
                                        ×
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Submit Button -->
                        <button type="submit" 
                                class="w-full bg-gradient-to-r from-soft-pink-500 to-pink-600 text-white py-4 px-6 rounded-xl font-bold hover:from-soft-pink-600 hover:to-pink-700 focus:outline-none focus:ring-4 focus:ring-soft-pink-300 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Konfirmasi Pesanan
                        </button>
                        
                        <!-- Security Badge -->
                        <div class="flex items-center justify-center space-x-2 text-xs text-gray-500 pt-4 border-t border-gray-200 mt-6">
                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            <span>Data Anda 100% Aman & Terpercaya</span>
                        </div>
                    </div>
                </div>
            </div>
        </form>
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

/* File input styling */
input[type="file"]::-webkit-file-upload-button {
    cursor: pointer;
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

.animate-fade-in-up {
    animation: fadeInUp 0.6s ease-out;
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

/* Loading state */
.loading {
    opacity: 0.7;
    pointer-events: none;
}

.loading button {
    position: relative;
}

.loading button::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 20px;
    height: 20px;
    margin: -10px 0 0 -10px;
    border: 2px solid transparent;
    border-top: 2px solid #ffffff;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>

<script>
// Image preview functionality
document.getElementById('payment_proof').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');
    
    if (file) {
        // Validate file type
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        if (!allowedTypes.includes(file.type)) {
            alert('Format file harus berupa gambar (JPG, PNG, GIF)');
            e.target.value = '';
            return;
        }
        
        // Validate file size (5MB)
        const maxSize = 5 * 1024 * 1024;
        if (file.size > maxSize) {
            alert('Ukuran file maksimal 5MB');
            e.target.value = '';
            return;
        }
        
        // Show preview
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    } else {
        preview.classList.add('hidden');
    }
});

// Remove preview
function removePreview() {
    document.getElementById('payment_proof').value = '';
    document.getElementById('imagePreview').classList.add('hidden');
}

// Form submission with loading state
document.querySelector('form').addEventListener('submit', function(e) {
    const fileInput = document.getElementById('payment_proof');
    
    if (!fileInput.files[0]) {
        e.preventDefault();
        alert('Silakan upload bukti transfer terlebih dahulu');
        fileInput.focus();
        return;
    }
    
    // Add loading state
    const form = this;
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    
    submitBtn.innerHTML = `
        <svg class="w-5 h-5 inline mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
        </svg>
        Memproses Pesanan...
    `;
    submitBtn.disabled = true;
    form.classList.add('loading');
    
    // If there's an error, restore the button
    setTimeout(() => {
        if (form.classList.contains('loading')) {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
            form.classList.remove('loading');
        }
    }, 30000); // 30 seconds timeout
});

// Drag and drop functionality
const fileInput = document.getElementById('payment_proof');
const dropZone = fileInput.parentElement;

['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    dropZone.addEventListener(eventName, preventDefaults, false);
});

function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
}

['dragenter', 'dragover'].forEach(eventName => {
    dropZone.addEventListener(eventName, highlight, false);
});

['dragleave', 'drop'].forEach(eventName => {
    dropZone.addEventListener(eventName, unhighlight, false);
});

function highlight(e) {
    dropZone.classList.add('border-soft-pink-500', 'bg-soft-pink-50');
}

function unhighlight(e) {
    dropZone.classList.remove('border-soft-pink-500', 'bg-soft-pink-50');
}

dropZone.addEventListener('drop', handleDrop, false);

function handleDrop(e) {
    const dt = e.dataTransfer;
    const files = dt.files;
    
    if (files.length > 0) {
        fileInput.files = files;
        fileInput.dispatchEvent(new Event('change'));
    }
}

// Auto-scroll to error messages
document.addEventListener('DOMContentLoaded', function() {
    const errorElement = document.querySelector('.bg-gradient-to-r.from-red-50');
    if (errorElement) {
        errorElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
});
</script>

<?php
$content = ob_get_clean();
require_once 'app/views/layouts/landing.php';
?> 