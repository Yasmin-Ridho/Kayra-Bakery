<?php
$title = 'Tambah ke Keranjang - Kayra Bakery & Cake';

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
<section class="relative py-16 bg-gradient-to-br from-soft-pink-50 to-pink-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
                Tambah ke <span class="text-soft-pink-400">Keranjang</span>
            </h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Pilih jumlah produk yang ingin Anda tambahkan ke keranjang belanja
            </p>
        </div>
    </div>
</section>

<!-- Add to Cart Form -->
<section class="py-16 bg-white">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-8">
            <form method="POST" action="<?= $baseUrl ?>/carts" class="space-y-6">
                <div>
                    <label for="product_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Pilih Produk
                    </label>
                    <select name="product_id" id="product_id" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-soft-pink-300 focus:border-soft-pink-400 transition-colors duration-200">
                        <option value="">-- Pilih Produk --</option>
                        <?php if (isset($products) && !empty($products)): ?>
                            <?php foreach ($products as $product): ?>
                                <option value="<?= $product->id ?>" 
                                        data-price="<?= $product->price ?>"
                                        data-stock="<?= $product->stock ?>"
                                        <?= old('product_id') == $product->id ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($product->name) ?> - <?= $product->getFormattedPrice() ?> (Stok: <?= $product->stock ?>)
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                    <?php if (hasValidationError('product_id')): ?>
                        <p class="mt-1 text-sm text-red-600"><?= getValidationError('product_id') ?></p>
                    <?php endif; ?>
                </div>

                <div>
                    <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">
                        Jumlah
                    </label>
                    <div class="flex items-center space-x-3">
                        <button type="button" onclick="decreaseQuantity()" 
                                class="px-3 py-2 border border-gray-300 rounded-lg text-gray-600 hover:text-gray-800 hover:bg-gray-100 transition-colors duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                            </svg>
                        </button>
                        <input type="number" name="quantity" id="quantity" 
                               value="<?= old('quantity', 1) ?>" 
                               min="1" max="999" required
                               class="w-24 px-4 py-3 text-center border border-gray-300 rounded-lg focus:ring-2 focus:ring-soft-pink-300 focus:border-soft-pink-400 transition-colors duration-200">
                        <button type="button" onclick="increaseQuantity()" 
                                class="px-3 py-2 border border-gray-300 rounded-lg text-gray-600 hover:text-gray-800 hover:bg-gray-100 transition-colors duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                        </button>
                    </div>
                    <?php if (hasValidationError('quantity')): ?>
                        <p class="mt-1 text-sm text-red-600"><?= getValidationError('quantity') ?></p>
                    <?php endif; ?>
                </div>

                <div id="productInfo" class="hidden bg-gray-50 rounded-lg p-4">
                    <h4 class="font-semibold text-gray-800 mb-2">Informasi Produk</h4>
                    <div class="space-y-2 text-sm text-gray-600">
                        <div class="flex justify-between">
                            <span>Harga per item:</span>
                            <span id="pricePerItem">-</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Stok tersedia:</span>
                            <span id="stockAvailable">-</span>
                        </div>
                        <div class="flex justify-between font-semibold text-gray-800 border-t border-gray-200 pt-2">
                            <span>Total harga:</span>
                            <span id="totalPrice">-</span>
                        </div>
                    </div>
                </div>

                <div class="flex space-x-4">
                    <button type="submit" 
                            class="flex-1 bg-gradient-to-r from-soft-pink-300 to-pink-400 text-white py-3 px-6 rounded-lg font-semibold hover:from-soft-pink-400 hover:to-pink-500 transition-all duration-200 transform hover:scale-105 shadow-lg">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 11-4 0v-6m4 0V9a2 2 0 10-4 0v4.01"/>
                        </svg>
                        Tambah ke Keranjang
                    </button>
                    <a href="<?= $baseUrl ?>/products" 
                       class="flex-1 text-center border-2 border-gray-300 text-gray-700 py-3 px-6 rounded-lg font-semibold hover:bg-gray-50 hover:border-soft-pink-300 hover:text-soft-pink-500 transition-all duration-200">
                        Kembali ke Produk
                    </a>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
let currentPrice = 0;
let currentStock = 0;

// Update product info when product is selected
document.getElementById('product_id').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const productInfo = document.getElementById('productInfo');
    
    if (selectedOption.value) {
        currentPrice = parseInt(selectedOption.dataset.price) || 0;
        currentStock = parseInt(selectedOption.dataset.stock) || 0;
        
        document.getElementById('pricePerItem').textContent = formatPrice(currentPrice);
        document.getElementById('stockAvailable').textContent = currentStock + ' item';
        
        // Update quantity max
        const quantityInput = document.getElementById('quantity');
        quantityInput.setAttribute('max', currentStock);
        
        // Update total price
        updateTotalPrice();
        
        productInfo.classList.remove('hidden');
    } else {
        productInfo.classList.add('hidden');
        currentPrice = 0;
        currentStock = 0;
    }
});

// Update total price when quantity changes
document.getElementById('quantity').addEventListener('input', function() {
    updateTotalPrice();
});

function updateTotalPrice() {
    const quantity = parseInt(document.getElementById('quantity').value) || 0;
    const total = currentPrice * quantity;
    document.getElementById('totalPrice').textContent = formatPrice(total);
}

function formatPrice(price) {
    return 'Rp ' + price.toLocaleString('id-ID');
}

function increaseQuantity() {
    const input = document.getElementById('quantity');
    const current = parseInt(input.value) || 0;
    const max = parseInt(input.getAttribute('max')) || 999;
    
    if (current < max) {
        input.value = current + 1;
        updateTotalPrice();
    }
}

function decreaseQuantity() {
    const input = document.getElementById('quantity');
    const current = parseInt(input.value) || 0;
    
    if (current > 1) {
        input.value = current - 1;
        updateTotalPrice();
    }
}

// Initialize if product is already selected (from old input)
document.addEventListener('DOMContentLoaded', function() {
    const productSelect = document.getElementById('product_id');
    if (productSelect.value) {
        productSelect.dispatchEvent(new Event('change'));
    }
});
</script>

<?php
$content = ob_get_clean();
require_once 'app/views/layouts/landing.php';
?>
