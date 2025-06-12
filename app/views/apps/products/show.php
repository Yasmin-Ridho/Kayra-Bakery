<?php
// Set title untuk halaman
$title = 'Detail Produk - ' . ($product->name ?? 'Tidak Diketahui');

// Start session untuk flash messages
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Content untuk show product
ob_start();
?>

<!-- Dashboard Header -->
<div class="mb-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Detail Produk</h1>
            <p class="mt-1 text-sm text-gray-500">Informasi lengkap tentang produk ini.</p>
        </div>
        <div class="mt-4 sm:mt-0 flex space-x-3">
            <a href="<?= url('products') ?>" 
               class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
            <a href="<?= url('products/' . ($product->id ?? '') . '/edit') ?>" 
               class="inline-flex items-center px-4 py-2 bg-soft-pink-500 hover:bg-soft-pink-600 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit Produk
            </a>
        </div>
    </div>
</div>

<!-- Flash Messages -->
<?php if ($successMessage = getFlashMessage('success')): ?>
    <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-green-800"><?= htmlspecialchars($successMessage) ?></p>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Product Details -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Product Image and Basic Info -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Product Image -->
            <div class="aspect-w-16 aspect-h-9 bg-gray-100">
                <img src="<?= $product->getImageUrl() ?>" 
                     alt="<?= htmlspecialchars($product->name ?? '') ?>"
                     class="w-full h-64 object-cover"
                     onerror="this.src='<?= url('assets/images/placeholder-product.jpg') ?>'">
            </div>
            
            <!-- Product Info -->
            <div class="p-6">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">
                            <?= htmlspecialchars($product->name ?? 'Nama tidak tersedia') ?>
                        </h2>
                        <div class="flex items-center space-x-4 mb-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-soft-pink-100 text-soft-pink-800">
                                <?= htmlspecialchars($category->name ?? 'Tidak ada kategori') ?>
                            </span>
                            <?php if (($product->stock ?? 0) > 0): ?>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Tersedia
                                </span>
                            <?php else: ?>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Habis
                                </span>
                            <?php endif; ?>
                        </div>
                        <div class="text-3xl font-bold text-gray-900 mb-4">
                            <?= $product->getFormattedPrice() ?>
                        </div>
                    </div>
                </div>
                
                <!-- Description -->
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Deskripsi Produk</h3>
                    <div class="prose prose-sm max-w-none text-gray-600">
                        <?= nl2br(htmlspecialchars($product->description ?? 'Tidak ada deskripsi')) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Sidebar Info -->
    <div class="space-y-6">
        <!-- Product Stats -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Produk</h3>
            <dl class="space-y-4">
                <div>
                    <dt class="text-sm font-medium text-gray-500">ID Produk</dt>
                    <dd class="text-sm text-gray-900">#<?= $product->id ?? 'N/A' ?></dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Slug</dt>
                    <dd class="text-sm text-gray-900 font-mono bg-gray-100 px-2 py-1 rounded">
                        <?= htmlspecialchars($product->slug ?? 'N/A') ?>
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Kategori</dt>
                    <dd class="text-sm text-gray-900">
                        <?= htmlspecialchars($category->name ?? 'Tidak ada kategori') ?>
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Stok</dt>
                    <dd class="text-sm text-gray-900">
                        <span class="font-semibold"><?= $product->stock ?? 0 ?></span> unit
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Harga</dt>
                    <dd class="text-lg font-bold text-gray-900">
                        <?= $product->getFormattedPrice() ?>
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Dibuat</dt>
                    <dd class="text-sm text-gray-900">
                        <?= isset($product->created_at) ? formatDateIndonesian($product->created_at, 'd M Y H:i') : 'Tidak diketahui' ?>
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Diperbarui</dt>
                    <dd class="text-sm text-gray-900">
                        <?= isset($product->updated_at) ? formatDateIndonesian($product->updated_at, 'd M Y H:i') : 'Tidak diketahui' ?>
                    </dd>
                </div>
            </dl>
        </div>
        
        <!-- Quick Actions -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h3>
            <div class="space-y-3">
                <a href="<?= url('products/' . ($product->id ?? '') . '/edit') ?>" 
                   class="w-full inline-flex items-center justify-center px-4 py-2 bg-soft-pink-500 hover:bg-soft-pink-600 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit Produk
                </a>
                
                <button onclick="deleteProduct(<?= $product->id ?? 0 ?>, '<?= htmlspecialchars($product->name ?? '') ?>')" 
                        class="w-full inline-flex items-center justify-center px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Hapus Produk
                </button>
                
                <a href="<?= url('products') ?>" 
                   class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 bg-white hover:bg-gray-50 text-gray-700 text-sm font-medium rounded-lg transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                    </svg>
                    Lihat Semua Produk
                </a>
            </div>
        </div>
        
        <!-- Product Status -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Status Produk</h3>
            <div class="space-y-3">
                <?php if (($product->stock ?? 0) > 0): ?>
                    <div class="flex items-center text-green-600">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-sm font-medium">Stok Tersedia</span>
                    </div>
                    <p class="text-sm text-gray-600">
                        Produk ini memiliki stok sebanyak <strong><?= $product->stock ?> unit</strong> dan siap untuk dijual.
                    </p>
                <?php else: ?>
                    <div class="flex items-center text-red-600">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-sm font-medium">Stok Habis</span>
                    </div>
                    <p class="text-sm text-gray-600">
                        Produk ini sedang tidak tersedia. Silakan perbarui stok untuk mulai menjual kembali.
                    </p>
                <?php endif; ?>
                
                <?php if (!empty($product->image)): ?>
                    <div class="flex items-center text-blue-600">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="text-sm font-medium">Memiliki Gambar</span>
                    </div>
                <?php else: ?>
                    <div class="flex items-center text-yellow-600">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                        <span class="text-sm font-medium">Belum Ada Gambar</span>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mt-4">Hapus Produk</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Apakah Anda yakin ingin menghapus produk "<span id="productName" class="font-medium"></span>"? 
                    Tindakan ini tidak dapat dibatalkan dan akan menghapus semua data termasuk gambar.
                </p>
            </div>
            <div class="items-center px-4 py-3">
                <form id="deleteForm" method="POST" class="inline">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" 
                            class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md w-24 mr-2 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300">
                        Hapus
                    </button>
                </form>
                <button onclick="closeDeleteModal()" 
                        class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-24 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Delete product functionality
function deleteProduct(id, name) {
    document.getElementById('productName').textContent = name;
    document.getElementById('deleteForm').action = '<?= url('products') ?>/' + id;
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});
</script>

<?php
$content = ob_get_clean();
include 'app/views/layouts/app.php';
?>
