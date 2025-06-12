<?php
// Set title untuk halaman
$title = 'Edit Produk - ' . ($product->name ?? 'Tidak Diketahui');

// Start session untuk flash messages
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Content untuk edit product
ob_start();
?>

<!-- Dashboard Header -->
<div class="mb-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit Produk</h1>
            <p class="mt-1 text-sm text-gray-500">Perbarui informasi produk bakery Anda.</p>
        </div>
        <div class="mt-4 sm:mt-0 flex space-x-3">
            <a href="<?= url('products/' . ($product->id ?? '')) ?>" 
               class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
            <button onclick="deleteProduct(<?= $product->id ?? 0 ?>, '<?= htmlspecialchars($product->name ?? '') ?>')" 
                    class="inline-flex items-center px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Hapus
            </button>
        </div>
    </div>
</div>

<!-- Flash Messages -->
<?php if (hasValidationErrors()): ?>
    <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-red-800">Terjadi kesalahan:</h3>
                <div class="mt-2 text-sm text-red-700">
                    <?php displayValidationErrors(); ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Form Card -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900">Edit Informasi Produk</h3>
        <p class="mt-1 text-sm text-gray-500">Perbarui detail produk dengan informasi yang akurat.</p>
    </div>
    
    <form action="<?= url('products/' . ($product->id ?? '')) ?>" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
        <input type="hidden" name="_method" value="PUT">
        
        <!-- Current Image Display -->
        <?php if (!empty($product->image)): ?>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Gambar Saat Ini
                </label>
                <div class="flex items-center space-x-4">
                    <img src="<?= $product->getImageUrl() ?>" 
                         alt="<?= htmlspecialchars($product->name ?? '') ?>"
                         class="h-20 w-20 object-cover rounded-lg border border-gray-200">
                    <div class="text-sm text-gray-600">
                        <p class="font-medium">Gambar produk saat ini</p>
                        <p>Upload gambar baru untuk menggantinya</p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Image Upload -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                <?= !empty($product->image) ? 'Ganti Gambar Produk' : 'Gambar Produk' ?>
            </label>
            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-soft-pink-400 transition-colors duration-200">
                <div class="space-y-1 text-center">
                    <div id="imagePreview" class="hidden">
                        <img id="previewImg" class="mx-auto h-32 w-32 object-cover rounded-lg" src="" alt="Preview">
                    </div>
                    <div id="uploadPlaceholder">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600">
                            <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-soft-pink-600 hover:text-soft-pink-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-soft-pink-500">
                                <span><?= !empty($product->image) ? 'Ganti gambar' : 'Upload gambar' ?></span>
                                <input id="image" name="image" type="file" class="sr-only" accept="image/*">
                            </label>
                            <p class="pl-1">atau drag and drop</p>
                        </div>
                        <p class="text-xs text-gray-500">PNG, JPG, GIF hingga 2MB</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                Nama Produk <span class="text-red-500">*</span>
            </label>
            <input type="text" 
                   id="name" 
                   name="name" 
                   value="<?= old('name', $product->name ?? '') ?>"
                   class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-soft-pink-500 focus:border-soft-pink-500"
                   placeholder="Masukkan nama produk"
                   required>
            <p class="mt-1 text-sm text-gray-500">Nama produk yang akan ditampilkan kepada pelanggan.</p>
        </div>

        <!-- Slug -->
        <div>
            <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">
                Slug <span class="text-red-500">*</span>
            </label>
            <input type="text" 
                   id="slug" 
                   name="slug" 
                   value="<?= old('slug', $product->slug ?? '') ?>"
                   class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-soft-pink-500 focus:border-soft-pink-500"
                   placeholder="nama-produk"
                   required>
            <p class="mt-1 text-sm text-gray-500">URL-friendly version dari nama produk.</p>
        </div>

        <!-- Category -->
        <div>
            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                Kategori <span class="text-red-500">*</span>
            </label>
            <select id="category_id" 
                    name="category_id" 
                    class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-soft-pink-500 focus:border-soft-pink-500"
                    required>
                <option value="">Pilih kategori</option>
                <?php if (!empty($categories)): ?>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category->id ?>" 
                                <?= (old('category_id', $product->category_id ?? '') == $category->id) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($category->name) ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
            <p class="mt-1 text-sm text-gray-500">Pilih kategori yang sesuai untuk produk ini.</p>
        </div>

        <!-- Description -->
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                Deskripsi <span class="text-red-500">*</span>
            </label>
            <textarea id="description" 
                      name="description" 
                      rows="4" 
                      class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-soft-pink-500 focus:border-soft-pink-500"
                      placeholder="Deskripsikan produk Anda dengan detail..."
                      required><?= old('description', $product->description ?? '') ?></textarea>
            <p class="mt-1 text-sm text-gray-500">Jelaskan produk Anda dengan detail untuk menarik pelanggan.</p>
        </div>

        <!-- Price and Stock -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Price -->
            <div>
                <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                    Harga <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-500 sm:text-sm">Rp</span>
                    </div>
                    <input type="number" 
                           id="price" 
                           name="price" 
                           value="<?= old('price', $product->price ?? '') ?>"
                           min="0"
                           step="1000"
                           class="block w-full pl-12 pr-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-soft-pink-500 focus:border-soft-pink-500"
                           placeholder="0"
                           required>
                </div>
                <p class="mt-1 text-sm text-gray-500">Harga produk dalam Rupiah.</p>
            </div>

            <!-- Stock -->
            <div>
                <label for="stock" class="block text-sm font-medium text-gray-700 mb-2">
                    Stok <span class="text-red-500">*</span>
                </label>
                <input type="number" 
                       id="stock" 
                       name="stock" 
                       value="<?= old('stock', $product->stock ?? '') ?>"
                       min="0"
                       class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-soft-pink-500 focus:border-soft-pink-500"
                       placeholder="0"
                       required>
                <p class="mt-1 text-sm text-gray-500">Jumlah stok yang tersedia.</p>
            </div>
        </div>

        <!-- Product Info -->
        <div class="bg-gray-50 rounded-lg p-4">
            <h4 class="text-sm font-medium text-gray-900 mb-3">Informasi Produk</h4>
            <dl class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                <div>
                    <dt class="font-medium text-gray-500">ID Produk</dt>
                    <dd class="text-gray-900">#<?= $product->id ?? 'N/A' ?></dd>
                </div>
                <div>
                    <dt class="font-medium text-gray-500">Dibuat</dt>
                    <dd class="text-gray-900">
                        <?= isset($product->created_at) ? formatDateIndonesian($product->created_at, 'd M Y H:i') : 'Tidak diketahui' ?>
                    </dd>
                </div>
                <div>
                    <dt class="font-medium text-gray-500">Diperbarui</dt>
                    <dd class="text-gray-900">
                        <?= isset($product->updated_at) ? formatDateIndonesian($product->updated_at, 'd M Y H:i') : 'Tidak diketahui' ?>
                    </dd>
                </div>
            </dl>
        </div>

        <!-- Submit Buttons -->
        <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
            <a href="<?= url('products/' . ($product->id ?? '')) ?>" 
               class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-soft-pink-500 transition-colors duration-200">
                Batal
            </a>
            <button type="submit" 
                    class="px-4 py-2 bg-soft-pink-500 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white hover:bg-soft-pink-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-soft-pink-500 transition-colors duration-200">
                Perbarui Produk
            </button>
        </div>
    </form>
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
// Auto-generate slug from name (only if slug is empty or matches current name)
document.getElementById('name').addEventListener('input', function() {
    const name = this.value;
    const slugField = document.getElementById('slug');
    const currentName = '<?= $product->name ?? '' ?>';
    const currentSlug = '<?= $product->slug ?? '' ?>';
    
    // Only auto-generate if slug is empty or matches the current product's slug
    if (!slugField.value || slugField.value === currentSlug) {
        const slug = name.toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '') // Remove special characters
            .replace(/\s+/g, '-') // Replace spaces with hyphens
            .replace(/-+/g, '-') // Replace multiple hyphens with single hyphen
            .trim('-'); // Remove leading/trailing hyphens
        
        slugField.value = slug;
    }
});

// Image preview functionality
document.getElementById('image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('imagePreview').classList.remove('hidden');
            document.getElementById('uploadPlaceholder').classList.add('hidden');
        };
        reader.readAsDataURL(file);
    }
});

// Drag and drop functionality
const dropZone = document.querySelector('.border-dashed');

dropZone.addEventListener('dragover', function(e) {
    e.preventDefault();
    this.classList.add('border-soft-pink-400', 'bg-soft-pink-50');
});

dropZone.addEventListener('dragleave', function(e) {
    e.preventDefault();
    this.classList.remove('border-soft-pink-400', 'bg-soft-pink-50');
});

dropZone.addEventListener('drop', function(e) {
    e.preventDefault();
    this.classList.remove('border-soft-pink-400', 'bg-soft-pink-50');
    
    const files = e.dataTransfer.files;
    if (files.length > 0) {
        const file = files[0];
        if (file.type.startsWith('image/')) {
            document.getElementById('image').files = files;
            
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('previewImg').src = e.target.result;
                document.getElementById('imagePreview').classList.remove('hidden');
                document.getElementById('uploadPlaceholder').classList.add('hidden');
            };
            reader.readAsDataURL(file);
        }
    }
});

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
